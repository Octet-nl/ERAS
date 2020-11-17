<?php
/**
 * System      Inschrijvingen
 * Module      Factuur
 * Doel        Opmaak PDF factuur
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-05-2020
 *
 * Copyright (c) 2019-2020 Hans de Rijck
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

class Factuur extends FPDF2
{
    private $titel = "";
    private $logo = "";
    private $footer = "";
    private $address = "";
    private $ini = array();

    //iconv("UTF-8", "ISO-8859-1", $factuurEvenementKolom1 )

    private function toAnsi( $utfstring )
    {
        return iconv("UTF-8", "ISO-8859-1", $utfstring );
    }

    public function setIni( $ini )
    {
        $this->ini = $ini;
    }

    public function getIni()
    {
        return $this->ini;
    }

    public function setDocumentTitle( $titel )
    {
        $this->titel = $this->toAnsi($titel);
    }

    public function setAddress( $address )
    {
        $this->address = $this->toAnsi($address);
    }

    public function setLogo( $logo )
    {
        $this->logo = $logo;
    }

    public function setFooter( $footer )
    {
        $this->footer = $this->toAnsi($footer);
    }

    public function Header()
    {
        $this->SetFont( 'Helvetica', 'B', 24 );
        $this->Cell( 60 );
        $this->SetTextColor( 100, 100, 100 );
        $this->Cell( 60, 10, $this->titel, 0, 0, 'C' );
        $this->Image( $this->logo, 12, 5, 15 );
        $this->Ln( 15 );
        $this->Line( 0, 22, $this->GetPageWidth(), 20 );
        $this->Ln( 10 );
//        $this->SetFont('Arial','B',14);
        //        $this->Cell(20);
        //        $this->Cell(10,10,'Bevestiging',1,1,'C',true);
        $this->Ln( 10 );
        $this->SetTextColor( 255, 255, 255 );
    }

    public function addFrom( $titel, $str, $str2 )
    {
        $this->SetFont( 'Helvetica', '', 8 );
        $this->setXY( 10, 30 );
        $this->Cell( 100, 5, $titel, 1, 2, 'L', true );
        $x = $this->GetX();
        $y = $this->GetY();
        $this->MultiCell( 25, 4, $str, 'LB', 1 );
        $this->setXY( $x + 25, $y );
        $this->MultiCell( 75, 4, $str2, 'RB', 1 );
    }

    public function addTo( $str )
    {
        $x = $this->GetX();
        $this->setXY( $x + 120, 30 );
        $this->Cell( 70, 5, 'Aan', 1, 2, 'L', true );
        $y = $this->GetY();
        $this->MultiCell( 70, 5, $str, 'LRB', 1 );
        $this->Ln( 10 );
    }

    public function addOrderDetail( $evt, $rdate, $nummer, $aantal, $prijsper, $totaal )
    {
        $x = 10;
        $y = 70;
        $this->SetFont( 'Helvetica', '', 9 );
        $this->Cell( 550 );
        $this->setXY( $x, $y );
        $this->Cell( 85, 7, $this->toAnsi($this->ini['pdf_factuur']['evenement-kolom1']), 1, 2, 'L', true );
        $this->CellFitScale( 85, 8, $evt, 'LRB', 1 );
        $this->setXY( $x + 85, $y );
        $this->Cell( 45, 7, $this->toAnsi($this->ini['pdf_factuur']['evenement-kolom2']), 1, 2, 'L', true );
        $this->Cell( 45, 8, $rdate, 'LRB', 1 );
//        $this->setXY( $x + 110, $y );
        //        $this->Cell( 20, 7, 'Inschrijfnr', 1, 2, 'L', true );
        //        $this->Cell( 20, 8, $nummer, 'LRB', 1 );
        $this->setXY( $x + 130, $y );

        $this->Cell( 15, 7, $this->toAnsi($this->ini['pdf_factuur']['evenement-kolom3']), 1, 2, 'C', true );
        $this->Cell( 15, 8, $aantal, 'LRB', 1, 'R' );
        $this->setXY( $x + 145, $y );

        $this->Cell( 20, 7, $this->toAnsi($this->ini['pdf_factuur']['evenement-kolom4']), 1, 2, 'C', true );
        $this->Cell( 20, 8, geldAnsi( $prijsper ), 'LRB', 1, 'R' );

        $this->setXY( $x + 165, $y );
        $this->Cell( 25, 7, $this->toAnsi($this->ini['pdf_factuur']['evenement-kolom5']), 1, 2, 'C', true );
        $this->Cell( 25, 8, geldAnsi( $totaal ), 'LRB', 1, 'R' );

        $this->Ln( 10 );
    }

    private function tabelheader()
    {
        $x = $this->GetX();
        $y = $this->GetY();
        $this->setXY( $x, $y );
        $this->Cell( 50, 7, $this->toAnsi($this->ini['pdf_factuur']['deelnemer-kolom1']), 1, 2, 'L', true );
        $this->setXY( $x + 50, $y );
        $this->Cell( 80, 7, $this->toAnsi($this->ini['pdf_factuur']['deelnemer-kolom2']), 1, 2, 'L', true );
//        $this->setXY( $x + 100, $y );
        //        $this->Cell( 30, 7, '', 1, 2, 'L', true );
        $this->setXY( $x + 130, $y );
        $this->Cell( 15, 7, $this->toAnsi($this->ini['pdf_factuur']['deelnemer-kolom3']), 1, 2, 'C', true );
        $this->setXY( $x + 145, $y );
        $this->Cell( 20, 7, $this->toAnsi($this->ini['pdf_factuur']['deelnemer-kolom4']), 1, 2, 'C', true );
        $this->setXY( $x + 165, $y );
        $this->Cell( 25, 7, $this->toAnsi($this->ini['pdf_factuur']['deelnemer-kolom5']), 1, 2, 'C', true );
    }

    public function populateTable( $data, $aantal_deelnemers, $startprijs )
    {
        $total = $startprijs * $aantal_deelnemers;

        if ( sizeof( $data ) > 0 )
        {

            $this->tabelheader();

            $i = 1;
            $aantal = "";
            $prijs = "";
            $price = 0;
            $vorigeDeelnemer = "";
            $deelnemer = "";
            foreach ( $data as $d )
            {
//            echo "positie Y " . $this->GetY() . "<br/>";
                if ( $this->GetY() > 250 )
                {
                    $this->AddPage();
                    $this->tabelheader();
                }
                if ( $vorigeDeelnemer != $d["deelnemer"] )
                {
                    $deelnemer = $d["deelnemer"];
                    $vorigeDeelnemer = $d["deelnemer"];
                    $this->Ln( 2 );
                }
                else
                {
                    $deelnemer = "";
                }

                if ( isset( $d["aantal"] ) && isset( $d["prijs"] ) )
                {
                    $price = $d["prijs"] * $d["aantal"];
                    $aantal = $d["aantal"];
                    $prijs = $d["prijs"];
                }
                else
                {
                    if ( isset( $d["prijs"] ) )
                    {
                        $prijs = $d["prijs"];
                        $price = $d["prijs"];
                    }
                    else
                    {
                        $price = 0;
                    }
                }
                $this->Ln( 0 );
                $x = $this->GetX();
                $y = $this->GetY();
                $this->setXY( $x, $y );
                $this->CellFitScale( 50, 4, $deelnemer, 0, 2, 'L' );
                $this->setXY( $x + 50, $y );
                $this->CellFitScale( 50, 4, $d["naam"], 0, 2, 'L' );
                $this->setXY( $x + 100, $y );
                $this->CellFitScale( 30, 4, $d["omschrijving"], 0, 2, 'L' );
                $this->setXY( $x + 130, $y );
                $this->Cell( 15, 4, $aantal, 0, 2, 'R' );
                $this->setXY( $x + 145, $y );
                $this->Cell( 20, 4, geldAnsi( $prijs ), 0, 2, 'R' );
                $this->setXY( $x + 165, $y );
                $this->Cell( 25, 4, geldAnsi( $price ), 0, 2, 'R' );
                $total += $price;
                $i++;
            }
        }

        $this->Ln( 8 );

        $x = $this->GetX();
        $y = $this->GetY();

        $this->setXY( $x + 120, $y );
        $this->Cell( 45, 5, $this->toAnsi($this->ini['pdf_factuur']['BTW-regel1']), 1, 2, 'C', true );
        $this->setXY( $x + 165, $y );
        $this->Cell( 25, 5, geldAnsi( $total - $total * ( $this->ini['pdf_factuur']['BTW-percentage'] / 100 ) ), 1, 2, 'R' );
        $this->Ln( 0 );
        $x = $this->GetX();
        $y = $this->GetY();

        $this->setXY( $x + 120, $y );
        $this->Cell( 45, 5, $this->toAnsi($this->ini['pdf_factuur']['BTW-regel2']), 1, 2, 'C', true );
        $this->setXY( $x + 165, $y );
        $this->Cell( 25, 5, geldAnsi( $total * ( $this->ini['pdf_factuur']['BTW-percentage'] / 100 ) ), 1, 2, 'R' );
        $this->Ln( 0 );
        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetFont( 'Helvetica', 'B', 9 );
        $this->setXY( $x + 120, $y );
        $this->Cell( 45, 5, $this->toAnsi($this->ini['pdf_factuur']['BTW-regel3']), 1, 2, 'C', true );
        $this->setXY( $x + 165, $y );
        $this->Cell( 25, 5, geldAnsi( $total ), 1, 2, 'R' );
        $this->Ln( 2 );

    }

    public function Footer()
    {
        $this->SetY( -20 );
        $this->SetTextColor( 100, 100, 100 );
        $this->SetFont( 'Arial', '', 9 );
        $this->Cell( 0, 8, $this->footer, 0, 0, 'C' );
        $this->SetY( -15 );
        $this->SetFont( 'Times', 'I', 8 );
        $this->Cell( 0, 8, $this->address, 0, 0, 'C' );
    }

}
