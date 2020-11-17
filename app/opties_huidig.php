<?php
/**
 * System      Inschrijvingen
 * Module      Session status
 * Doel        Vullen session met statusarray (voor wijzigen inschrijving/deelnemer)
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       30-10-2019
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

use fb_model\fb_model\InschrijvingHeeftOptieQuery;
use fb_model\fb_model\DeelnemerHeeftOptieQuery;
use \fb_model\fb_model\OptieQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

function inschrijvingsOpties( $inschrijvingId )
{
    GLOBAL $logger;
    $logger->debug( 'InschrijvingsID: ' . $inschrijvingId );

    $dnOptiesQuery = InschrijvingHeeftOptieQuery::create()->filterByInschrijvingId( $inschrijvingId )->find();
    if ( $dnOptiesQuery == null )
    {
        $logger->error( "Probleem bij ophalen inschrijvingsopties voor id:" . $inschrijvingId );
        return null;
    }
    $logger->verbose( 'Inschrijving OptiesQuery: ' . $dnOptiesQuery);
    return optiesHuidig( $dnOptiesQuery );
}

function deelnemerOpties( $deelnemerId )
{
    GLOBAL $logger;
    $logger->debug( 'deelnemer ID: ' . $deelnemerId );

    $dnOptiesQuery = DeelnemerHeeftOptieQuery::create()->filterByDeelnemerId( $deelnemerId )->find();
    if ( $dnOptiesQuery == null )
    {
        $logger->error( "Probleem bij ophalen deelnemeropties voor id:" . $deelnemerId );
        return null;
    }
    $logger->verbose( 'Deelnemer OptiesQuery: ' . $dnOptiesQuery);
    return optiesHuidig( $dnOptiesQuery );
}

function optiesHuidig( $dnOptiesQuery )
{
    GLOBAL $logger;

    $optieWaarde = null;
    $gekozenOpties = null;

    try
    {
    foreach ( $dnOptiesQuery as $dnOptieQuery )
    {
        $optie = OptieQuery::create()->findPK( $dnOptieQuery->getOptieId() );
        
        $logger->verbose( 'Optie: ' . $optie->getNaam() );

        if ( $optie == null )
        {
            $logger->error( "Optie niet gevonden. OptieID: " . $dnOptieQuery->getOptieId() );
            echo "Systeemfout, verwerking is afgebroken.";
            return null;
        }

        $optieWaarde = $dnOptieQuery->getOptieId();

        if ( $optie->getOptieType() == OPTIETYPE_KEUZE_RADIO )
        {
            $naam = cleanOptieNaam( $optie->getGroep() );
            $logger->debug( "Groepsnaam " . $naam . " gekozen voor optietype " . $optie->getOptieType() );
        }
        elseif ( $optie->getOptieType() == OPTIETYPE_KEUZE_MEERDERE )
        {
            $naam = cleanOptieNaam( $optie->getNaam() );
            $logger->debug( "Optienaam " . $naam . " gekozen voor optietype " . $optie->getOptieType() );
        }
        elseif ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE ||
                 $optie->getOptieType() == OPTIETYPE_AANTAL ||
                 $optie->getOptieType() == OPTIETYPE_GETAL ||
                 $optie->getOptieType() == OPTIETYPE_KOPTEKST ||
                 $optie->getOptieType() == OPTIETYPE_AKKOORD ||
                 $optie->getOptieType() == OPTIETYPE_VOORWAARDE ||
                 $optie->getOptieType() == OPTIETYPE_TEKSTREGEL ||
                 $optie->getOptieType() == OPTIETYPE_TEKSTVAK )
        {
            $naam = cleanOptieNaam( $optie->getTekstVoor() );

            //if ( $optie->getOptieType() != OPTIETYPE_AANTAL )
            {
                $optieWaarde = $dnOptieQuery->getWaarde();
            }
            $logger->debug( "Tekstnaam " . $naam . " gekozen voor optietype " . $optie->getOptieType() );
        }
        else
        {
            $logger->error( "Onjuist/onbekend optietype: " . $optie->getOptieType() );
            echo "Systeemfout, verwerking is afgebroken.";
            return null;
        }

        $logger->debug( "Naam " . $naam . " heeft waarde " . $optieWaarde );
        $gekozenOpties[$naam] = $optieWaarde;
    }
}
catch( Exception $ex)
{
    $logger->dump( $ex );
}

    return $gekozenOpties;
}
