<?php
/**
 * System      ERAS
 * Module      index
 * Doel        Startpagina (home) van het inschrijvingssysteem
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       05-07-2020
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

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\DeelnemerQuery;

$systeem = new Sysdb( true );
$sessie = null;

$doctitle = "ERAS main";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;
$signalMessage = false;

$lopend_evenement_lijst = array();
$komend_evenement_lijst = array();

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_GEEN );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->reset();
    $history->set();

    $logger->dump( $_SESSION );

    if ( isset( $_SESSION['isUpdate']  ) )
    {
        $logger->debug( "isUpdate is gezet" );
        if ( $_SESSION['isUpdate']  != null )
        {		
          $tag = $_SESSION['isUpdate'] ;

          $logger->debug( "isUpdate is " . $tag );
          
          $logger->info( "************************************" );
          $logger->info( "*  System update naar versie " . $tag );
          $logger->info( "************************************" );
    
          $statusRegel = "Het systeem is met succes ge-update naar versie " . $tag;
          $signalMessage = true;
        }
        $logger->debug( "Destroy session" );
        session_destroy();
        $autorisatie->logOut();
        $autorisatie->setNotAuth( "login.php" );
        $autorisatie->validate( AUTORISATIE_STATUS_GEEN );
    }

    $sessie = new sessie();

    $lopendeEvenementen = EvenementQuery::create()
    ->filterByStatus( EVENEMENT_STATUS_OPEN )
    ->filterByDatumBegin( array( "max" => date( "Y-m-d" ) . " 00:00:00" ) )
    ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
    ->find();

    foreach ( $lopendeEvenementen as $lopendEvenement )
    {
        $evt_lijst = array();
        $evt_lijst["id"] = $lopendEvenement->getId();
        $evt_lijst["naam"] = $lopendEvenement->getNaam();
        $evt_lijst["datum_eind"] = $lopendEvenement->getDatumEind()->format( "d-m-Y" );

        array_push( $lopend_evenement_lijst, $evt_lijst );
    }
    $logger->dump( $lopend_evenement_lijst );

    $vandaag = strtotime(date("Y-m-d"));
    $date = date('Y-m-d', strtotime('+1 month', $vandaag));

    $komendeEvenementen = EvenementQuery::create()
    ->filterByStatus( EVENEMENT_STATUS_OPEN )
    ->filterByDatumBegin( array( "min" => date( "Y-m-d" ) . " 00:00:00", "max" => $date . " 00:00:00" ) )
    ->find();

    foreach ( $komendeEvenementen as $komendEvenement )
    {
        $sum = DeelnemerQuery::create()
        ->useInschrijvingQuery( 'a', 'left join' )
          ->filterByEvenementId( $komendEvenement->getId() )
          ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
        ->enduse()
        ->count();
        $aantal_beschikbaar = $komendEvenement->getMaxDeelnemers() - $sum;

        $evt_lijst = array();
        $evt_lijst["deleted"] = "0";
        $evt_lijst["started"] = "0";

        $evt_lijst["id"] = $komendEvenement->getId();
        $evt_lijst["naam"] = $komendEvenement->getNaam();
        $evt_lijst["datum_begin"] = $komendEvenement->getDatumBegin()->format( "d-m-Y" );
        $evt_lijst["datum_eind"] = $komendEvenement->getDatumEind()->format( "d-m-Y" );
        $evt_lijst["aantal_beschikbaar"] = $aantal_beschikbaar;

        array_push( $komend_evenement_lijst, $evt_lijst );
    }
    $logger->dump( $komend_evenement_lijst );

}


// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    $sessie = new sessie();

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
}

// Deel 3, wordt altijd uitgevoerd.

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'organisatie_naam', $systeem->getOrganisatieNaam() );

$debugMessage = "";
if ( $logger->isDebug() )
{
    $debugMessage = "Waarschuwing: DEBUGGING staat aan.<br/>";
    if ( $autorisatie->getRol() == AUTORISATIE_STATUS_ROOT )
    {
        $debugMessage .= "<br/> en u bent als ROOT ingelogd.<br/>";
    }
}
else if ( $autorisatie->getRol() == AUTORISATIE_STATUS_ROOT )
{
    $debugMessage = "Waarschuwing: U bent als ROOT ingelogd.";
}

$smarty->assign( 'lopendeEvenementen', $lopend_evenement_lijst );
$smarty->assign( 'komendeEvenementen', $komend_evenement_lijst );

$smarty->assign( 'autorisatie', $autorisatie->getRol() );

$smarty->assign( 'KLANT', AUTORISATIE_STATUS_KLANT );
$smarty->assign( 'MEDEWERKER', AUTORISATIE_STATUS_MEDEWERKER );
$smarty->assign( 'SUPERVISOR', AUTORISATIE_STATUS_SUPERVISOR );
$smarty->assign( 'ADMIN', AUTORISATIE_STATUS_ADMINISTRATOR );
$smarty->assign( 'ROOT', AUTORISATIE_STATUS_ROOT );

$loggedin = false;
if ( $autorisatie->isLoggedIn() )
{
    $loggedin = true;
}
// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'loggedin', $loggedin );
$smarty->assign( 'isMessage', $signalMessage );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );
$smarty->assign( 'debugmessage', $debugMessage );

$smarty->display( 'index.tpl' );
