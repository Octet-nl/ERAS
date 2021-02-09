<?php
/**
 * System      ERAS
 * Module      Lijst met evenementen
 * Doel        Keuzelijst, beheer van evenementen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       13-11-2019
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

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

$sessie = new Sessie();

$doctitle = "Evenementen beheren";
$inactief = false;

$signalError = false;
$statusRegel = "";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\EvenementHeeftOptieQuery;
use \fb_model\fb_model\EvenementQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenement_lijst = array();

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// Opbouwen optielijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->debug( "Evenement lijst" );
    $history->set();
    
    if ( isset( $_GET['cat'] ) )
    {
        $categorie = $_GET['cat'];
        // Toon alleen de open evenementen in deze categorie
        $evenementen = EvenementQuery::create()
            ->filterByStatus( EVENEMENT_STATUS_OPEN )
            ->filterByCategorie( $categorie )
            ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
            ->find();
        $inactief = false;
    }
    elseif ( isset( $_GET['inact'] ) )
    {
        // Toon alle evenementen
        $evenementen = EvenementQuery::create()
            ->find();
        $inactief = true;
    }
    else
    {
        // Toon alleen open evenementen die nog niet afgelopen zijn
        $evenementen = EvenementQuery::create()
            ->filterByStatus( EVENEMENT_STATUS_OPEN )
            ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
            ->find();
        $inactief = false;
    }

    foreach ( $evenementen as $evenement )
    {
        $sum = DeelnemerQuery::create()
        ->useInschrijvingQuery( 'a', 'left join' )
          ->filterByEvenementId( $evenement->getId() )
          ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
        ->enduse()
        ->count();
        $aantal_beschikbaar = $evenement->getMaxDeelnemers() - $sum;

        $evt_lijst = array();
        $evt_lijst["deleted"] = "0";
        $evt_lijst["started"] = "0";
        $evt_lijst["inschrijven"] = "0";

        $evt_lijst["id"] = $evenement->getId();
        $evt_lijst["naam"] = $evenement->getNaam();
        $evt_lijst["datum_begin"] = $evenement->getDatumBegin()->format( "d-m-Y" );
        $evt_lijst["datum_eind"] = $evenement->getDatumEind()->format( "d-m-Y" );
        $evt_lijst["inschrijving_begin"] = $evenement->getInschrijvingBegin()->format( "d-m-Y" );
        $evt_lijst["inschrijving_eind"] = $evenement->getInschrijvingEind()->format( "d-m-Y" );
        $evt_lijst["prijs"] = $evenement->getPrijs();
        $evt_lijst["status"] = evenementStatusNaam( $evenement->getStatus() );
        $evt_lijst["max_deelnemers"] = $evenement->getMaxDeelnemers();
        $evt_lijst["aantal_beschikbaar"] = $aantal_beschikbaar;
        $evt_lijst["gemaakt_datum"] = $evenement->getDatumGemaakt();
        $evt_lijst["gemaakt_door"] = $evenement->getGemaaktDoor();
        $evt_lijst["gewijzigd_datum"] = $evenement->getDatumGewijzigd();
        $evt_lijst["gewijzigd_door"] = $evenement->getGewijzigdDoor();
        if ( $evenement->getStatus() != EVENEMENT_STATUS_OPEN )
        {
            $evt_lijst["deleted"] = "1";
        }

        $startDatum = new DateTime( $evenement->getDatumBegin()->format( 'Y-m-d' ) );
        $vandaag = new DateTime( date( "Y-m-d" ) );
        if ( $vandaag >= $startDatum )
        {
            $evt_lijst["started"] = "1";
        }

        $inschrijfDatum = new DateTime( $evenement->getInschrijvingBegin()->format( 'Y-m-d' ) );
        $vandaag = new DateTime( date( "Y-m-d" ) );
        if ( $vandaag >= $inschrijfDatum )
        {
            $evt_lijst["inschrijven"] = "1";
        }

        $evt_lijst["kanVerwijderd"] = "0";
//        $evenementopties = EvenementHeeftOptieQuery::create()->filterByEvenementId( $evenement->getId() )->find();
//        if ( sizeof( $evenementopties ) == 0 )
        {
            $inschrijving = InschrijvingQuery::create()->findOneByEvenementId( $evenement->getId() );
            if ( $inschrijving == null )
            {
                $evt_lijst["kanVerwijderd"] = "1";
            }
        }

        $logger->dump( $evt_lijst );
        array_push( $evenement_lijst, $evt_lijst );
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
        $logger->debug( 'Afmelden' );
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    $status = "";
    if ( isset( $_POST['inact'] ) )
    {
        $logger->debug( 'Ook inactieve evenementen.' );
        $status = "?inact=true";
        header( "Location:evenement_lijst.php" . $status );
        exit();
    }
    if ( isset( $_POST['act'] ) )
    {
        $logger->debug( 'Alleen actieve evenementen.' );
        header( "Location:evenement_lijst.php" );
        exit();
    }

    if ( isset( $_POST['toevoegen'] ) )
    {
        header( "Location:evenement_opvoeren.php" );
    }

    if ( isset( $_POST['statistiek'] ) )
    {
        header( "Location:evenement_statistiek.php?evt=" . $_POST['statistiek'] );
        exit();
    }

    if ( isset( $_POST['verwijder'] ) )
    {
        $logger->debug( "Verwijderen" );
        $evenement = EvenementQuery::create()->findPk( $_POST['verwijder'] );
        try
        {
            $evenementopties = EvenementHeeftOptieQuery::create()->filterByEvenementId( $evenement->getId() )->find();
            if ( sizeof( $evenementopties ) != 0 )
            {
                $evenementopties->delete();
            }

            $evenement->delete();
        }
        catch ( Exception $ex )
        {
            $logger->warning( $ex->getMessage() );
            $logger->warning( $ex->getPrevious()->getPrevious() );
            if ( strpos( $ex->getPrevious()->getPrevious(), 'SQLSTATE[23000]' ) !== false )
            {
                alert( 'Dit evenement is in gebruik en kan niet verwijderd worden.\nU kunt het evenement sluiten zodat deze niet meer in de lijst verschijnt.' );
            }
            else
            {
                alert( 'Verwijderen is mislukt. Er is iets misgegaan.' );
            }
        }
        header( "Location:evenement_lijst.php" . $status );
        return;
    }

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $aanpassen )
        ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['aanpassen'] ) )
    {
        header( "Location:evenement_opvoeren.php?evt=" . $aanpassen );
    }
}

// Deel 3

if ( $inactief )
{
    $doctitle = "Alle evenementen";
    $buttontekst = "Actieve evenementen";
    $buttonname = "act";
}
else
{
    $doctitle = "Actieve evenementen";
    $buttontekst = "Alle evenementen";
    $buttonname = "inact";
}

$smarty->assign( 'doctitle', $doctitle );

$smarty->assign( 'buttontekst', $buttontekst );
$smarty->assign( 'buttonname', $buttonname );
$smarty->assign( 'Evenementen', $evenement_lijst );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'evenement_lijst.tpl' );
