<?php
/**
 * System      ERAS
 * Module      Opties naar HTML
 * Doel        HTML generator voor opties
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-04-2020
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

require_once 'constanten.php';
require_once 'utilities.php';

use fb_model\fb_model\DeelnemerHeeftOptieQuery;
use Propel\Runtime\ActiveQuery\Criteria;

// HTML generatie voor opties
class optiesNaarHtml
{
    private $htmlTotal = "";
    private $optieArray = array();
    private $currentArray = array();
    private $currentNames = array();
    private $currentValues = array();
    private $evenementId = 0;
    private $useIntern = false;
    private $wijzigenDefinitieveInschrijving = false;
    private $kopregel = "Opties";
    private $logger = null;
    private $autorisatieRol = 0;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }


    public function setEvenementId( $evt )
    {
        $this->evenementId = $evt;
    }

    public function getHtml()
    {
        return $this->htmlTotal;
    }

    public function enableInternGebruik( $truefalse )
    {
        if ( $truefalse === true || $truefalse === false )
        {
            $this->useIntern = $truefalse;
        }
    }

    public function getOptieArray()
    {
        return $this->optieArray;
    }

    public function setKopregel( $kopregel )
    {
        $this->kopregel = $kopregel;
    }

    public function setAutorisatieRol( $rol )
    {
        $this->autorisatieRol = $rol;
    }

    public function setCurrent( $post )
    {
        $this->currentArray = $post;
        if ( $post == null )
        {
            // Geen opties
            $this->currentArray = array();
            return;
        }
        foreach ( $this->currentArray as $key => $value )
        {
            array_push( $this->currentNames, cleanOptieNaam( $key ) );
            if ( $value != "" )
            {
                array_push( $this->currentValues, $value );
            }
        }

        $this->logger->dump( $this->currentArray );
        $this->logger->dump( $this->currentNames );
        $this->logger->dump( $this->currentValues );
    }

    private function getTooltipTekst( $optieTooltip, $position = "" )
    {
        $returnTekst = "";
        if ( $optieTooltip != null && $optieTooltip != "" )
        {
            $returnTekst = '
            <div class="tooltip">?
                <span class="tooltiptext ' . $position . '">' . $optieTooltip . '
                </span>
            </div>';
        }
        return $returnTekst;
    }

    public function setWijzigenDefinitieveInschrijving( $wijzigen )
    {
        $this->wijzigenDefinitieveInschrijving = $wijzigen;
    }

    public function getWijzigenDefinitieveInschrijving()
    {
        return $this->wijzigenDefinitieveInschrijving;
    }

    private function compressHtmlX( $data )
    {
        //return preg_replace('~>\s+<~', '><', $data);
        return preg_replace( '~>\s*\n\s*<~', '><', $data );
    }

    private function compressHtml( $content )
    {
        return $content;

        $i = 0;
        $content = preg_replace( '~>\s+<~', '><', $content );
        $content = preg_replace( '/\s\s+/', ' ', $content );

        while ( $i < 5 )
        {
            $content = str_replace( '  ', ' ', $content );
            $i++;
        }

        return trim( $content );
    }

    public function genereerHtml( $opties )
    {
        $vorigeGroep = "";
        $groepIsOpen = false;
        $optieTeller = 1;
        $aantalDeelnemersGehad = false;

        if ( count( $opties ) == 0 )
        {
            $this->logger->debug( "Geen opties." );
            return;
        }

        if ( $this->kopregel != "" )
        {
            $this->htmlTotal .= '<div style="clear:left"><br/> <h4>' . $this->kopregel . '</h4></div>';
        }

        if ( $this->wijzigenDefinitieveInschrijving )
        {
            $this->htmlTotal .= '<div style="clear:left"> <br/> <h3>Let op: dit is een definitieve inschrijving</h3> 
            <h4>Opties kunnen niet gewijzigd worden.</h4></div>';
        }

        $hideArray = array();

        foreach ( $opties as $optie )
        {
            $this->logger->verbose( "Foreach optie: " . $optie->getNaam() );

            if ( $this->useIntern == false && $optie->getInternGebruik() )
            {
                $this->logger->verbose( "Skip: Geen interne medewerker en optie voor intern gebruik: " . $optie->getNaam() );
                continue;
            }

            if ( $optie->getStatus() != OPTIE_STATUS_ACTIEF ) // Status 1 is actief
            {
                $this->logger->verbose( "Skip: Optie niet actief: " . $optie->getNaam() );
                continue;
            }

            if (  ( $optie->getLaterWijzigen() == "0" && $this->getWijzigenDefinitieveInschrijving() ) && ( $this->autorisatieRol < AUTORISATIE_STATUS_MEDEWERKER ) )
            {
                $this->logger->verbose( "Skip: Wil later wijzigen en later wijzigen niet toegestaan: " . $optie->getNaam() );
                continue;
            }

            // Instemmingsopties niet voor medewerkers
            if ( $optie->getOptieType() == OPTIETYPE_AKKOORD && $this->autorisatieRol >= AUTORISATIE_STATUS_MEDEWERKER)
            {
                continue;
            }


            $optieTeller += 1;

            $optiesOver = -1;
            $optieSom = 0;
            // Bepalen totaal aantal uitgegeven opties (als er een maximum is)
            if ( $optie->getTotaalAantal() != null )
            {
                if ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
                {
                    // Bij ja/nee opties alleen de JA opties meetellen. Aan NEE opties zit geen limiet.
//                    $optieSom = DeelnemerHeeftOptieQuery::create()
//                        ->filterByOptieId( $optie->getId() )
//                        ->filterByWaarde( OPTIE_KEUZE_JA )
//                        ->count();
//ToDo:
                    // Deze is uit "evenement_statistiek.php"    
                    $optieSom = DeelnemerHeeftOptieQuery::create()
                        ->useDeelnemerQuery( 'a', 'left join' )
                         ->useInschrijvingQuery( 'b', 'left join' )
                          ->filterByEvenementId( $this->evenementId )
                         ->enduse()
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->filterByWaarde( OPTIE_KEUZE_JA )
                        ->count();                        
                }
                elseif ( $optie->getOptieType() == OPTIETYPE_AANTAL )
                {
                    $optieAantallen = DeelnemerHeeftOptieQuery::create()
                        ->useDeelnemerQuery( 'a', 'left join' )
                         ->useInschrijvingQuery( 'b', 'left join' )
                          ->filterByEvenementId( $this->evenementId )
                         ->enduse()
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->find();
                    foreach ( $optieAantallen as $optieAantal )
                    {
                        $optieSom += $optieAantal->getWaarde();
                    }
                }
                elseif ( $optie->getOptieType() == OPTIETYPE_GETAL )
                {
                    $optieSom = DeelnemerHeeftOptieQuery::create()
                        ->useDeelnemerQuery( 'a', 'left join' )
                         ->useInschrijvingQuery( 'b', 'left join' )
                          ->filterByEvenementId( $this->evenementId )
                         ->enduse()
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->filterByWaarde( "0", Criteria::NOT_EQUAL )
                        ->count();
                }
                else
                {
                    $optieSom = DeelnemerHeeftOptieQuery::create()
                        ->useDeelnemerQuery( 'a', 'left join' )
                         ->useInschrijvingQuery( 'b', 'left join' )
                          ->filterByEvenementId( $this->evenementId )
                         ->enduse()
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->count();
                }
                $optiesOver = $optie->getTotaalAantal() - $optieSom;
                $this->logger->verbose( "Totaal opties: " . $optie->getTotaalAantal() . ", reeds verbruikt: " . $optieSom . ", over: " . $optiesOver );
            }

            $prijsregel = "";
            $optieBeschikbaar = true;
            $disabled = "";

            $optieMax = "";
            if ( $optie->getPrijs() != 0 )
            {
                $this->logger->verbose( "Prijsberekening" );

                $prijsregel = "&nbsp;( &euro; " . $optie->getPrijs();

                if ( $optie->getTotaalAantal() != null )
                //if ( $optie->getOptieType() == OPTIETYPE_AANTAL )
                //if ( $optie->getPrijsPer() != "" )
                {
                    if ( $optiesOver >= 0 ) // Als er geen maximum is dan is $optiesOver = -1
                    {
                        if ( $optiesOver > 0 )
                        {
                            $prijsregel .= ", beschikbaar: " . $optiesOver;
                            $optieMax = 'max="' . $optiesOver . '"';
                        }
                        else
                        {
                            $prijsregel = '<span class="grijs">' . $prijsregel . ', niet meer beschikbaar.</span>';
                            $optieBeschikbaar = false;
                            $optieMax = 'max="0"';
                        }
                    }
                }
                $prijsregel .= " )";
            }
            else
            {
                $this->logger->verbose( "Geen prijs opgegeven" );

                if ( $optiesOver >= 0 ) // Als er geen maximum is dan is $optiesOver = -1
                {
                    if ( $optiesOver > 0 )
                    {
                        $prijsregel = "&nbsp;(Beschikbaar: " . $optiesOver . ")";
                        $optieMax = 'max="' . $optiesOver . '"';
                    }
                    else
                    {
                        $prijsregel = '<span class="grijs">&nbsp;(Niet meer beschikbaar.)</span>';
                        $optieBeschikbaar = false;
                        $optieMax = 'max="0"';
                    }
                }
            }

            $aantalType = "aantal";

            $this->logger->verbose( "Optioneel afsluiten radio of select groep" );

            if ( $vorigeGroep != "" && $optie->getOptieType() != OPTIETYPE_KEUZE_RADIO &&
                $optie->getOptieType() != OPTIETYPE_KEUZE_MEERDERE )
            {
                // Ander type optie
                // Geen onderdeel meer van de laatste groep. Deze afsluiten.
                $html1 = "  <span class=\"error\"></span>
                          </div>
                          ";
                $this->htmlTotal .= $this->compressHtml( $html1 );
                $groepIsOpen = false;
                $vorigeGroep = "";
            }
            elseif ( $vorigeGroep != "" && $vorigeGroep != $optie->getGroep() )
            {
                // Nieuwe groep.
                // Geen onderdeel meer van de laatste groep. Deze afsluiten.
                $html1 = "  <span class=\"error\"></span>
                          </div>
                          ";
                $this->htmlTotal .= $this->compressHtml( $html1 );
                $groepIsOpen = false;
                $vorigeGroep = "";
            }

            ///////////////////////////////////////////////
            //
            // Genereer HTML afhankelijk van het optietype
            //
            ///////////////////////////////////////////////

            $this->logger->verbose( "HTML generatie per optie" );

            // $labelTekst wordt gebruikt voor voorwaardelijke opties
            $labelTekst = "";
            if ( $optie->getLabel() != "" )
            {
                $labelTekst = 'name="' . $optie->getLabel() . '"';
            }

            // Als een voorwaardelijke optie op "nee" staat, dan wordt de naam (label) in hideArray opgeslagen
            // De DIV wordt dan verborgen gemaakt.
            if ( in_array( $optie->getLabel(), $hideArray ) )
            {
                $labelTekst .= ' class="option" ';
            }

            $tekstAchterCheck = "";
            $tekstAchterJaNee = "";
            if ( $optie->getTekstAchter() != null && $optie->getTekstAchter() != "" )
            {
                $tekstAchterCheck = '<div ' . $labelTekst . ' style="font-style:italic;padding:0em 0em 1.2em 1.0em">' . $optie->getTekstAchter() . '</div>';
                $tekstAchterJaNee = '<div ' . $labelTekst . ' style="font-style:italic;padding:0em 0em 1.2em 0em">' . $optie->getTekstAchter() . '</div>';
            }

            $witregel = "<br/>";
            if ( $optie->getHeeftHorizontaleLijn() == HORIZONTALE_LIJN_BOVEN ||
                 $optie->getHeeftHorizontaleLijn() == HORIZONTALE_LIJN_BEIDE )
            {
                $html1 = '<div ' . $labelTekst . '><br/><hr/></div>';
                $this->htmlTotal .= $html1;
                $witregel = "";
            }

            if ( $optie->getOptieType() == OPTIETYPE_AANTAL )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $waarde = 0;
                if ( is_array( $this->currentArray ) && array_key_exists( $naam, $this->currentArray ) )
                {
                    $waarde = $this->currentArray[$naam];
                    if ( $optiesOver >= 0 )
                    {
                        $optieMax = 'max="' . ( $waarde + $optiesOver ) . '"';
                    }
                }

                $this->logger->verbose( "Optie_Aantal Naam: " . $naam . " optieId: " . $optie->getId() . " waarde: " . $waarde );

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst(), "right" );

                $html1 = '<div ' . $labelTekst . '>
                            '.$witregel.'
                            <label for="' . $naam . '">' . $optie->getTekstVoor() . ':</label>
                            <input ' . $disabled . ' type="number" name="' . $naam . '" id="' . $aantalType
                            . $optieTeller . '"  value="' . $waarde . '" min="0" ' . $optieMax
                            . ' onblur="addPrices(' . $optieTeller . ')">' . $tooltipTekst . $prijsregel . '
                            <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">'
                            . $tekstAchterCheck . '
                            <span class="error"></span>
                          </div>
                          ';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                // array_push( $this->optieArray, array( $naam, $optie->getId(), $optie->getOptieType(), "", $optie->getPrijs() ) );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_GETAL )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $waarde = 0;
                if ( is_array( $this->currentArray ) && array_key_exists( $naam, $this->currentArray ) )
                {
                    $waarde = $this->currentArray[$naam];
                }

                $this->logger->verbose( "Optie_Getal Naam: " . $naam . " optieId: " . $optie->getId() . " waarde: " . $waarde );

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst(), "right" );
                $html1 = '<div ' . $labelTekst . '>
                            '.$witregel.'
                            <label for="' . $naam . '">' . $optie->getTekstVoor() . ':</label>
                            <input ' . $disabled . ' type="number" name="' . $naam . '" id="' . $aantalType
                            . $optieTeller . '"  value="' . $waarde . '" onblur="addPrices(' . $optieTeller . ')">'
                            . $tooltipTekst . $prijsregel . '
                            <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">
                            ' . $tekstAchterJaNee . '
                            <span class="error"></span>
                          </div>
                          ';

                $this->htmlTotal .= $this->compressHtml( $html1 );
                // array_push( $this->optieArray, array( $naam, $optie->getId(), $optie->getOptieType(), "", $optie->getPrijs() ) );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_TEKSTREGEL )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $waarde = "";
                if ( array_key_exists( $naam, $this->currentArray ) )
                {
                    $waarde = $this->currentArray[$naam];
                }

                $this->logger->verbose( "Optie_Tekst Naam: " . $naam . " optieId: " . $optie->getId() . " waarde: " . $waarde );

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst() );

                $html1 = '<div ' . $labelTekst . '>
                            '.$witregel.'
                            <label for="' . $naam . '">' . $optie->getTekstVoor() . ':</label>
                            <input type="text" class="medium" name="' . $naam . '" id="' . $aantalType
                            . $optieTeller . '" value="' . $waarde . '"  placeholder="'
                            . $optie->getTekstAchter() . '" onblur="addPrices(' . $optieTeller . ')" >'
                            . $tooltipTekst . $prijsregel . '
                            <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">
                            <span class="error"></span>
                          </div>
                          ';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_TEKSTVAK )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $waarde = "";
                if ( array_key_exists( $naam, $this->currentArray ) )
                {
                    $waarde = $this->currentArray[$naam];
                }

                $this->logger->verbose( "Optie_Tekst Naam: " . $naam . " optieId: " . $optie->getId() . " waarde: " . $waarde );

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst() );

                $html1 = '<div ' . $labelTekst . '>
                            '.$witregel.'
                            <label for="' . $naam . '">' . $optie->getTekstVoor() . ':</label>
                            <textarea rows="4" cols="50" maxlength="512" name="' . $naam . '" id="'
                            . $aantalType . $optieTeller . '"  placeholder="' . $optie->getTekstAchter()
                            . '" onblur="addPrices(' . $optieTeller . ')">' . $waarde . '</textarea>'
                            . $tooltipTekst . $prijsregel . '
                            <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">
                            <span class="error"></span>
                          </div>
                          ';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_KOPTEKST )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $this->logger->verbose( "Optie_Label Naam: " . $naam . " optieId: " . $optie->getId() );

                $html1 = '<div ' . $labelTekst . '>
                          '.$witregel.'
                          <h3>' . $optie->getTekstVoor() . ' </h3>
                          </div>';
                
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_VASTE_TEKST )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $this->logger->verbose( "Optie_Vaste_Tekst Naam: " . $naam . " optieId: " . $optie->getId() );

                $html1 = '<div ' . $labelTekst . '>
                            '.$witregel.'
                            <label class="wide" for="' . $naam . '"><strong>' . $optie->getTekstVoor() . '</strong></label>
                          </div>
                          ';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_AKKOORD)
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $this->logger->verbose( "Optie_Akkoord Naam: " . $naam . " optieId: " . $optie->getId() );

                $html1 = '<div ' . $labelTekst . '>
                    '.$witregel.'
                    <input type="checkbox" title="Akkoord' .  $optieTeller . '" name="' . $naam . '" required value="' . OPTIE_KEUZE_JA . '">
                    <label class="wide">' . $optie->getTekstVoor() . '</label>
                    <br/>
                    <br/>
                    </div>';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );
            }
            elseif ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $jaChecked = "";
                $neeChecked = "";

                $this->logger->verbose( "Optie_Keuze_ja_nee Naam: " . $naam . " optieId: " . $optie->getId() ); //. " currentArray: " . $this->currentArray[$naam] );

                if ( in_array( $naam, $this->currentNames ) )
                {
                    $this->logger->verbose( "'" . $naam . "' bestaat in array" );
                    if ( $this->currentArray[$naam] == OPTIE_KEUZE_JA )
                    {
                        $jaChecked = "checked = \"checked\"";
                        $this->logger->verbose( "ja-checked" );
                    }
                    else
                    {
                        $neeChecked = "checked = \"checked\"";
                        $this->logger->verbose( "nee-checked" );
                    }
                }
                else
                {
                    if ( $optie->getIsDefault() )
                    {
                        $jaChecked = "checked = \"checked\"";
                    }
                    else
                    {
                        $neeChecked = "checked = \"checked\"";
                    }
                }

                if ( $jaChecked == "" && $optieBeschikbaar == false )
                {
                    $disabled = 'disabled';
                }

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst(), "right" );

                $html1 = ' <div ' . $labelTekst . '>
                            '.$witregel.'
                            <label class="radiotitel" for="' . $naam . '">' . $optie->getTekstVoor() . ':</label>
                            <input ' . $disabled . ' class="form-control" type="radio" name="' . $naam
                            . '" id="' . $aantalType . $optieTeller . '" value="' . 'ja' . '" ' . $jaChecked
                            . ' onclick="addPrices(' . $optieTeller . ')">ja
                            <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                $optieTeller += 1;
                $html1 = '
                            <input class="form-control" type="radio" name="' . $naam
                            . '" id="' . $aantalType . $optieTeller . '" value="' . 'nee' . '" ' . $neeChecked
                            . ' onclick="addPrices(' . $optieTeller . ')">nee'
                            . $tooltipTekst . $prijsregel .
                            '<input type="hidden" id="prijs' . $optieTeller . '" value="0.00">
                            <span class="error"></span>
                          </div>
                            ' . $tekstAchterJaNee . '
                        ';
                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => $optie->getPrijs() ) );

            }
            elseif ( $optie->getOptieType() == OPTIETYPE_VOORWAARDE )
            {
                $naam = cleanOptieNaam( $optie->getTekstVoor() );

                $jaChecked = "";
                $neeChecked = "";

                $this->logger->verbose( "Optie_Voorwaarde Naam: " . $naam . " optieId: " . $optie->getId() ); //. " currentArray: " . $this->currentArray[$naam] );

                if ( in_array( $naam, $this->currentNames ) )
                {
                    $this->logger->verbose( "'" . $naam . "' bestaat in array" );
                    if ( $this->currentArray[$naam] == OPTIE_KEUZE_JA )
                    {
                        $jaChecked = "checked = \"checked\"";
                        $this->logger->verbose( "ja-checked" );
                    }
                    else
                    {
                        $neeChecked = "checked = \"checked\"";
                        $this->logger->verbose( "nee-checked" );
                    }
                }
                else
                {
                    $neeChecked = "checked = \"checked\"";
                }

                if ( $jaChecked == "" && $optieBeschikbaar == false )
                {
                    $disabled = 'disabled';
                }

                if ( $neeChecked != "" )
                {
                    array_push( $hideArray, $optie->getLabel() );
                }

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst(), "right" );

                $html1 = '<div class="container">
                            '.$witregel.'
                            <label class="radiotitel" for="' . $naam . '">' . $optie->getTekstVoor() . '</label>
                            <input ' . $disabled . ' class="form-control" type="radio" name="' . $naam
                            . '" value="ja" ' . $jaChecked
                            . ' onclick="enableVoorwaarde(\'' . $optie->getLabel() . '\')">ja';

                $this->htmlTotal .= $this->compressHtml( $html1 );
                $optieTeller += 1;
                $html1 = '
                            <input class="form-control" type="radio" name="' . $naam
                            . '" value="nee" ' . $neeChecked
                            . ' onclick="disableVoorwaarde(\'' . $optie->getLabel() . '\')">nee'
                            . $tooltipTekst .
                            '
                          </div>
                            ' . $tekstAchterJaNee ;

                $this->htmlTotal .= $this->compressHtml( $html1 );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "prijs" => "0.00" ) );

            }
            elseif ( $optie->getOptieType() == OPTIETYPE_KEUZE_RADIO ||
                $optie->getOptieType() == OPTIETYPE_KEUZE_MEERDERE )
            {
                $groep = $optie->getGroep();
                $selectType = 'radio';

                if ( $optie->getOptieType() == OPTIETYPE_KEUZE_MEERDERE )
                {
                    $naam = cleanOptieNaam( $optie->getNaam() );

                    $selectType = 'checkbox';
                    $this->logger->verbose( "Optie_Keuze_meerdere Groep: " . $naam . " optieId: " . $optie->getId() . " tekst: " . $optie->getTekstVoor() ); // . " currentArray: " . $this->currentArray[$naam] );
                }
                else
                {
                    $naam = cleanOptieNaam( $groep );
                    $this->logger->verbose( "Optie_Keuze_radio Groep: " . $naam . " optieId: " . $optie->getId() . " tekst: " . $optie->getTekstVoor() ); //. " currentArray: " . $this->currentArray[$naam] );
                }

                $isChecked = "";

                if ( in_array( $naam, $this->currentNames ) )
                {
                    //if ( in_array( $optie->getId(), $this->currentValues ) )
                    if ( $optie->getId() == $this->currentArray[$naam] )
                    {
                        $this->logger->verbose( "Optie komt overeen, button checked: " . $naam . " waarde: " . $optie->getId() );
                        $isChecked = "checked = \"checked\"";
                    }
                }
                else
                {
                    if ( $optie->getIsDefault() )
                    {
                        $this->logger->verbose( "Default checked: " . $naam . " waarde: " . $optie->getId() );
                        $isChecked = "checked = \"checked\"";
                    }
                }

                if ( $isChecked == "" && $optieBeschikbaar == false )
                {
                    $disabled = 'disabled';
                }

                $tooltipTekst = $this->getTooltipTekst( $optie->getTooltipTekst(), "right" );

                if ( $groep == $vorigeGroep )
                {
                    $html1 = "
                                <input " . $disabled . " type=\"" . $selectType . "\" name=\"" . $naam . "\" id=\"" . $aantalType . $optieTeller . "\"  value=\"" . $optie->getId() . "\" " . $isChecked . " onclick=\"addPrices(" . $optieTeller . ")\">" . $optie->getTekstVoor() .
                    $tooltipTekst . $prijsregel . "<br/>
                                <input type=\"hidden\" id=\"prijs" . $optieTeller . "\" value=\"" . $optie->getPrijs() . "\">
                                " . $tekstAchterCheck . "
                              ";
                    $this->htmlTotal .= $this->compressHtml( $html1 );
                }
                else
                {
                    $html1 = '<div ' . $labelTekst . '>
                                '.$witregel.'
                                <label class="radiotitel" for="' . $naam . '">' . $optie->getGroep() . ':</label><br/>
                                <input ' . $disabled . ' class="form-control" type="' . $selectType . '" name="' . $naam
                    . '" id="' . $aantalType . $optieTeller . '"  value="' . $optie->getId()
                    . '" ' . $isChecked . ' onclick="addPrices(' . $optieTeller . ')">'
                    . $optie->getTekstVoor() . $prijsregel . $tooltipTekst . '<br/>
                                <input type="hidden" id="prijs' . $optieTeller . '" value="' . $optie->getPrijs() . '">'
                        . $tekstAchterCheck . '
                                ';
                    $this->htmlTotal .= $this->compressHtml( $html1 );
                    $vorigeGroep = $groep;
                    $groepIsOpen = true;
                }
                // array_push( $this->optieArray, array( "naam" => $optie->getTekstVoor(), "id" => $optie->getId(), "type" => $optie->getOptieType(), "groep" => $optie->getGroep(), "prijs" => $optie->getPrijs() ) );
                array_push( $this->optieArray, array( "naam" => $naam, "id" => $optie->getId(), "type" => $optie->getOptieType(), "groep" => $optie->getGroep(), "prijs" => $optie->getPrijs() ) );
            }

            if ( $optie->getHeeftHorizontaleLijn() == HORIZONTALE_LIJN_ONDER ||
                $optie->getHeeftHorizontaleLijn() == HORIZONTALE_LIJN_BEIDE )
            {
                $html1 = '<div ' . $labelTekst . '><hr/></div>';
                $this->htmlTotal .= $html1;
            }
        }
        if ( $groepIsOpen )
        {
            $html1 = '    <span class="error"></span>
                          </div>
                    ';
            $this->htmlTotal .= $this->compressHtml( $html1 );
        }

        // $this->logger->dump( $this->htmlTotal );

        return $this->htmlTotal;
    }

}
