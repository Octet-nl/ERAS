<?php
/**
 * System      ERAS
 * Module      Annuleringsverzekering naar HTML
 * Doel        HTML generator voor annuleringsverzekering
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-04-2020
 *
 * Copyright (c) 2019-2021 Hans de Rijck
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

// HTML generatie voor annuleringsverzekering
class avNaarHtml
{
    private $htmlTotal = "<br/>";
    private $optieArray = array();
    private $currentArray = array();
    private $currentNames = array();
    private $currentValues = array();
    private $currentAv = ANNULERINGSVERZEKERING_GEEN;
    private $evenementAv = 0;
    private $logger = null;

    public function __construct( $startArray = null )
    {
        if ( $startArray != null )
        {
            $this->optieArray = $startArray;
        }

        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }

    public function getHtml()
    {
        return $this->htmlTotal;
    }

    public function getOptieArray()
    {
        return $this->optieArray;
    }

    public function setAv( $heeftNu )
    {
        $this->currentAv = $heeftNu;
    }

    public function heeftAv( $heeftNu )
    {
        $this->evenementAv = $heeftNu;
    }

    public function setCurrent( $post )
    {
        $this->currentArray = $post;
        foreach ( $this->currentArray as $key => $value )
        {
            array_push( $this->currentNames, $key );
            if ( $value != "" )
            {
                array_push( $this->currentValues, $value );
            }
        }

        $this->logger->dump( $this->currentArray );
        $this->logger->dump( $this->currentNames );
    }

    public function genereerHtml( $verzNaam )
    {
        if ( $this->evenementAv )
        {
            $this->logger->debug( "Evenement heeft annuleringsverzekering" );

                $naam = "annuleringsverzekering";

                $arChecked = "";
                $gewoonChecked = "";
                $geenChecked = "";
                //if ( in_array( $naam, $this->currentNames ) )
                //{
                    $this->logger->debug( "'" . $naam . "' bestaat in annuleringsverzekering array" );
                    if ( $this->currentAv == ANNULERINGSVERZEKERING_ALLRISK )
                    {
                        $arChecked = ' checked ="checked"';
                        $this->logger->debug( "Allrisk-checked" );
                    }
                    else if ( $this->currentAv == ANNULERINGSVERZEKERING_GEWOON )
                    {
                        $gewoonChecked = ' checked="checked"';
                        $this->logger->debug( "Gewoon-checked" );
                    }
                    //else if ( $this->currentAv == ANNULERINGSVERZEKERING_GEEN )
                    else
                    {
                        $geenChecked = ' checked="checked"';
                        $this->logger->debug( "Geen-checked" );
                    }
                //}
                //else
                //{
                //    $geenChecked = ' checked="checked"';
                //    $this->logger->debug( $naam . " bestaat niet in annuleringsverzekering array" );
                //}

                $this->htmlTotal = "";

                $ini= parse_ini_file( CONFIG_FILENAME, true );
                $settingsVerzekeringVoorwaarden = $ini['settings']['verzekering_voorwaarden'];

                $html1 = '<br/>
                    <label class="radiotitel" style="margin-top: 0.2em;" for="Annuleringsverzekering">
                    <h3 style="padding-bottom: 0; margin-bottom: 0;">
                      Annuleringsverzekering:
                    </h3>
                    <h4 style="padding: 0; margin-top: 0;">
                      <a href="' . $settingsVerzekeringVoorwaarden .  '" alt="Bekijk de verzekeringsvoorwaarden" target="_blank">(informatie)</a>
                    </h4>
                    </label>
                    
                    <div class="container2">
                        <input type="radio" name="' . $naam . '" id="annuleringGeen" value="' . ANNULERINGSVERZEKERING_GEEN . '"' . $geenChecked . ' onclick="berekenAlles()">' . $verzNaam[ANNULERINGSVERZEKERING_GEEN] . '
                        <label id="asGeen"></label><br/>
                        <input type="hidden" id="prijsAnnuleringGeen" value="0.00">

                        <input class="form-control" type="radio" name="' . $naam . '" id="annuleringGewoon" value="' . ANNULERINGSVERZEKERING_GEWOON . '"' . $gewoonChecked . ' onclick="berekenAlles()">' . $verzNaam[ANNULERINGSVERZEKERING_GEWOON] . '
                        <input type="hidden" class="xshort" id="asNormXX" value="0.00" readonly onblur="berekenAlles()">
                        <label id="asNorm"></label><br/>
                        <input type="hidden" id="prijsAnnuleringGewoon" value="0.00">

                        <input type="radio" name="' . $naam . '" id="annuleringAllRisk" value="' . ANNULERINGSVERZEKERING_ALLRISK . '"' . $arChecked . ' onclick="berekenAlles()">' . $verzNaam[ANNULERINGSVERZEKERING_ALLRISK] . '
                        <input type="hidden" class="xshort" id="asArXX" value="0.00" readonly onblur="berekenAlles()">
                        <label id="asAr"></label><br/>
                        <input type="hidden" id="prijsAnnuleringAllRisk" value="0.00">

                        <span class="error"></span>
                    </div>';

                $this->htmlTotal .= $html1;

                //array_push( $this->optieArray, array( "naam" => $optie->getNaam(), "id" => $optie->getId(), "type" => $optie->getOptieType(), "groep" => $optie->getGroep(), "prijs" => $optie->getPrijs() ) );

        }
    }
}

