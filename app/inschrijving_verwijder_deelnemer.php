<?php
/**
 * System      Inschrijvingen
 * Module      Verwijderen deelnemer
 * Doel        Verwijderen van een deelnemer uit een inschrijving
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-10-2019
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

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

$sessie = new Sessie();

$doctitle = "Verwijder";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use fb_model\fb_model\DeelnemerQuery;
use fb_model\fb_model\DeelnemerHeeftOptieQuery;

$unused_variable = 0;

if ( defined( 'DEBUG' ) )
{
    echo '===================post==========================<br/>';
    var_dump( $_POST );
    echo '<br/>===================get===========================<br/>';
    var_dump( $_GET );
    echo '<br/>==================session========================<br/>';
    var_dump( $_SESSION );
    echo '<br/>=================================================<br/>';
}

// Defineer variabelen voor evenement
$contactpersoon_naam = "";
$maxDeelnemers = $extraTekst = $extraInschrijven = $annuleringsverzekering = $id = $opslaan = "";
$evt = $sum = 0;
$status = 0;
$totaalprijs = "";

$logger = new Logger();
$logger->level( LOGLEVEL );

$deelnemers_lijst = array();

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $sessieVariabelen );

    if ( isset( $_GET['mut'] ) )
    {
        $deelnemerId = $_GET['mut'];

        $deelnemer = DeelnemerQuery::create()->findPK( $deelnemerId );
        if ( $deelnemer == null )
        {
            $logger->warning( "Deelnemer " . $deelnemerId . " is niet gevonden." );
            echo "Deelnemer " . $deelnemerId . " is niet gevonden.";
            return;
        }

        $deelnemer_opties = DeelnemerHeeftOptieQuery::create()->filterByDeelnemerId( $deelnemerId );
        foreach( $deelnemer_opties as $deelnemer_optie )
        {
            echo $deelnemer_optie->getWaarde();
            $deelnemer_optie->delete();
        }

        $deelnemer->delete();

        echo "Deelnemer verwijderd.";
        header( "Location:inschrijving_overzicht.php" );
        exit();
    }
    else
    {
        $logger->warning( "Geen deelnemer ID in GET voor verwijderen. Zie inschrijving_overzicht.php" );
        echo "Geen deelnemer ID opgegeven";
        return;
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    //header( "Location:deelnemer_opvoeren.php?evt=".$opslaan );
}
