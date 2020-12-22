<?php
/**
 * System      ERAS
 * Module      Annuleringsverzekering
 * Doel        Class voor afhandelen annuleringsverzekering
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       29-10-2019
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

use \fb_model\fb_model\AnnuleringsverzekeringQuery;

// HTML generatie voor annuleringsverzekering
class AnnuleringsVerzekering
{
    private $verzNaam = array();
    private $verzPerc = array();
    private $verzAfsluit = array();
    private $verzBTW = array();

    function __construct() 
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );

        $verzekeringen = AnnuleringsverzekeringQuery::create()->find();
        foreach( $verzekeringen as $verzekering )
        {
            $this->logger->debug( $verzekering->getCode() );
            $this->logger->debug( $verzekering->getNaam() );

            $this->verzNaam[ $verzekering->getCode() ] = $verzekering->getNaam();
            $this->verzPerc[ $verzekering->getCode() ] = $verzekering->getPercentage();
            $this->verzAfsluit[ $verzekering->getCode() ] = $verzekering->getAfsluitkosten();
            $this->verzBTW[ $verzekering->getCode() ] = $verzekering->getBTW();
        }
    }

    public function getPercentage( $code )
    {
        return $this->verzPerc[ $code ];        
    }

    public function getAfsluitkosten( $code )
    {
        return $this->verzAfsluit[ $code ];
    }

    public function getNaam( $code )
    {
        return $this->verzNaam[ $code ];
    }

    public function getAlleNamen( )
    {
        return $this->verzNaam;
    }

    public function getBTW( $code )
    {
        return $this->verzBTW[ $code ];
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

    public function bereken( $bedrag, $type )
    {
        $premie = "0.00";

        if ( $type == ANNULERINGSVERZEKERING_ALLRISK ||
             $type == ANNULERINGSVERZEKERING_GEWOON  ||
             $type == ANNULERINGSVERZEKERING_GEEN )
        {
            $premie = $bedrag * $this->getPercentage( $type );
            $premie += $this->getAfsluitkosten( $type );
            $premie += ($premie * $this->getBTW( $type )  / 100);
        }        
        return $premie;
    }

    public function getFormule( $type )
    {
        $formule = "";
        if ( $type == ANNULERINGSVERZEKERING_ALLRISK )
        {
            $formule = "annulering_allrisk = subTotaal * " . $this->getPercentage( ANNULERINGSVERZEKERING_ALLRISK ) . ";
            annulering_allrisk += " . $this->getAfsluitkosten( ANNULERINGSVERZEKERING_ALLRISK ) . " * 100;
            annulering_allrisk += (annulering_allrisk * (" . $this->getBTW( ANNULERINGSVERZEKERING_ALLRISK ) . ")/100)";
        }
        elseif ( $type == ANNULERINGSVERZEKERING_GEWOON )
        {
            $formule = "annulering_gewoon = subTotaal * " . $this->getPercentage( ANNULERINGSVERZEKERING_GEWOON ) . ";
            annulering_gewoon += " . $this->getAfsluitkosten( ANNULERINGSVERZEKERING_GEWOON ) . " * 100;
            annulering_gewoon += (annulering_gewoon * (" . $this->getBTW( ANNULERINGSVERZEKERING_GEWOON ) . ")/100)";
        }
        elseif ( $type == ANNULERINGSVERZEKERING_GEEN )
        {
            $formule = "annulering_geen = subTotaal * " . $this->getPercentage( ANNULERINGSVERZEKERING_GEEN ) . ";
            annulering_geen += " . $this->getAfsluitkosten( ANNULERINGSVERZEKERING_GEEN ) . " * 100
            annulering_geen += (annulering_geen * (" . $this->getBTW( ANNULERINGSVERZEKERING_GEEN ) . ")/100)";
        }
    
        return $formule;
    }

}
