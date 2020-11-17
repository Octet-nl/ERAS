<?php
/**
 * System      Inschrijvingen
 * Module      Lijst met gebruikers
 * Doel        Autorisatie, beheer van gebruikers
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       09-01-2020
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

$doctitle = "Gebruikerslijst";
$inactief = false;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\GebruikerQuery;
use \fb_model\fb_model\KeuzesQuery;
use \fb_model\fb_model\PersoonQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$gebruiker_lijst = array();

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set();

    $gebruikers = GebruikerQuery::create()
        ->find();
    //  ->paginate(2, 10);

    $rolArray = array();
    if ( $rolArray == null )
    {
        $rollen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_AUTORISATIE )->filterByIsActief( "1" )->find();
        foreach ( $rollen as $dbstatus )
        {
            $rolArray[$dbstatus->getCode()] = $dbstatus->getNaam();
        }
    }

    foreach ( $gebruikers as $gebruiker )
    {
        $logger->debug( "Gebruiker: " . $gebruiker->getUserId() );

        if ( $gebruiker->getUserId() == 'root' )
        {
            continue;
        }

        if ( $gebruiker->getRol() > $autorisatie->getRol())
        {
            continue;
        }

        $gbr_lijst = array();
        $gbr_lijst["id"] = $gebruiker->getId();

        $persoon = PersoonQuery::create()->findPk( $gebruiker->getPersoonId() );

        if ( $persoon != null )
        {
            $dnr_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
            $dnr_lijst["email"] = $persoon->getEmail();
        }
        else
        {
            $dnr_lijst["naam"] = "";
            $dnr_lijst["email"] = "";
        }

        $dnr_lijst["id"] = $gebruiker->getId();
        $dnr_lijst["userid"] = $gebruiker->getUserId();
        $dnr_lijst["rol"] = $rolArray[$gebruiker->getRol()];
        $dnr_lijst["laatste_logindatum"] = formatDatum( $gebruiker->getDatumLaatsteLogin() );
        $dnr_lijst["laatste_loginadres"] = $gebruiker->getLaatsteLoginAdres();

        array_push( $gebruiker_lijst, $dnr_lijst );
    }

    $logger->dump( $dnr_lijst );
}

function formatDatum( $datum )
{
    if ( $datum != null )
    {
        return $datum->format( "d-m-Y" );
    }
    else
    {
        return "00-00-0000";
    }
}

// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $statusRegel = "Er is iets mis gegaan..";
        $signalError = true;
        $validateOk = 999;
    }

    $wijzigen = 0;
    $setVar->name( $wijzigen )->go();

    if ( $wijzigen > 0 )
    {
        $logger->debug( 'Gebruiker wijzigen.' );
        header( "Location:gebruiker_wijzigen.php?id=" . $wijzigen );
        exit();
    }

    if ( isset( $_POST['toevoegen'] ) )
    {
        $logger->debug( 'Gebruiker opvoeren.' );
        header( "Location:gebruiker_opvoeren.php" );
        exit();
    }

}

// Deel 3, wordt altijd uitgevoerd.


$admin_taken = false;
if ( $autorisatie->getRol() >= AUTORISATIE_STATUS_ADMINISTRATOR )
{
    $admin_taken = true;
}
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'Gebruikers', $gebruiker_lijst );
$smarty->assign( 'aantal', count( $gebruiker_lijst ) );
$smarty->assign( 'admin_taken', $admin_taken);

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'gebruiker_lijst.tpl' );
