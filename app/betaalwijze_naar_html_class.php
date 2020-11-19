<?php
/**
 * System      ERAS
 * Module      Betaalwijze naar HTML
 * Doel        HTML generator voor betaalwijze
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

use fb_model\fb_model\Betaalwijze;
use fb_model\fb_model\BetaalwijzeQuery;

// HTML generatie voor betaalwijze
class betalingNaarHtml
{
    private $betaalwijzen = 0;
    private $betaaldPer = 0;
    private $htmlTotal = "";
    private $voucherHtml = "";
    private $logger = null;

    public function __construct( $betaalwijze = 0 )
    {
        if ( $betaalwijze != 0 )
        {
            $this->betaalwijzen = $betaalwijze;
        }

        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }

    public function setBetaalwijze( $wijze )
    {
        $this->betaalwijzen = $wijze;
    }

    public function setBetaaldPer( $wijze )
    {
        $this->betaaldPer = $wijze;
    }

    public function genereerHtml()
    {
        $this->logger->debug( 'Betaalwijze ' . $this->betaalwijzen );

        if ( $this->betaalwijzen == 0 )
        {
            echo 'Betaalwijze is nul';
            $this->logger->error( 'Betaalwijze is nul' );
            return "";
        }

        // Alleen contante betaling?
        if ( $this->betaalwijzen == BETAALWIJZE_CONTANT )
        {
            $this->htmlTotal .= '<h3><label class="radiotitel" for="Betaalwijze">Betaalwijze:</label></h3>

            <h4>U kunt contant afrekenen bij de start van het evenement</h4>';
          
            $betaalwijze = BetaalwijzeQuery::create()->findOneByCode( BETAALWIJZE_CONTANT );

            if ( $betaalwijze->getKosten() > 0 )
            {
                $this->htmlTotal .= '<strong>Kosten contante betaling: ' . geld( $betaalwijze->getKosten()) . '</strong>';
            }

            $this->htmlTotal .= '
            <input type="hidden" name="betaalwijze" id="extra_bedrag1" value="' . $betaalwijze->getCode() . '">
            <label id="asGeen"></label><br/>
            <input type="hidden" id="extra_bedrag_prijs1' . '" value="' . $betaalwijze->getKosten() . '">
            ';
        }
        else
        {
            $this->htmlTotal = '<h3><label class="radiotitel" for="Betaalwijze">Betaalwijze:</label></h3><div class="container2">';
    
            $j = 0;
            for ( $i = 0; $i < 64; ++$i )
            {
                $waarde = pow( 2, $i );
                if (  ( $waarde & $this->betaalwijzen ) )
                {
                    $geenChecked = "";
                    //$this->setBetaaldPer is nul als de inschrijving nog niet definitief is
                    if ( $this->betaaldPer == 0 )
                    {
                      if ( $j == 0 )
                      {
                          $geenChecked = "checked";
                          $this->logger->info( "default " . $waarde );
                      }
                    }
                    else
                    {
                        if ( $this->betaaldPer == $waarde )
                        {
                           $geenChecked = "checked";
                        }
                    }                   
    
                    $this->logger->debug( 'Bit ' . $i . ' is gezet. Waarde is ' . $waarde );

                    if ( $waarde == BETAALWIJZE_VOUCHER )
                    {
                        $this->voucherHtml = '
                        <h3><label for="voucher">Inwisselen voucher/kortingsbon</label></h3>
                        <input type="checkbox" name="voucherid" id="reeds_betaald' . $i . '" value="0" ' . $geenChecked . ' onclick="addPrices()"> Gebruik voucher/bon, code: 
                        <input type="text" name="vouchercode" id="vouchercode" value="" placeholder="XXXX-XXXX-XXXX">
                        <button type="button" id="controleervoucher" onclick="loadXMLDoc()">Bereken waarde</button>
                        <span id="waardevoucher">Te gebruiken waarde: &euro; <input type="text" class="xshort" name="voucherwaarde" value="" readonly> Resterend: &euro; <input type="text" class="xshort" name="voucherrest" value="" readonly> </span>
                        <input type="hidden" name="voucherprijs" id="reeds_betaald_prijs' . $i . '" value="" onchange="addPrices()">
                        <input type="hidden" name="vouchertype" id="vouchertype" value="">
                        <p id="voucherOk"></p>
                        ';
                    }
                    else
                    {
                        $betaalwijze = BetaalwijzeQuery::create()->findOneByCode( $waarde );
    
                        $kosten = "";
                        if ( $betaalwijze->getKosten() > 0)
                        {
                            $kosten = " (&euro; " . $betaalwijze->getKosten() . ")";
                        }
        
                        $this->htmlTotal .= '
                           <input type="radio" name="betaalwijze" id="extra_keuze' . $i . '" value="' . $betaalwijze->getCode() . '" ' . $geenChecked . ' onclick="berekenAlles()">' . $betaalwijze->getNaam() . $kosten . '
                           <label id="asGeen"></label><br/>
                           <input type="hidden" id="extra_keuze_prijs' . $i . '" value="' . $betaalwijze->getKosten() . '">
                           ';
                    }
                    $j += 1;
                }
            }
            $this->htmlTotal .= '
            <span class="error"></span>
            </div>';
    }


    }

    public function getHtml()
    {
        return $this->htmlTotal;
    }

    public function getVoucherHtml()
    {
        return $this->voucherHtml;
    }
}
