<?php
/**
 * System      ERAS
 * Module      Lijst met deelnemers
 * Doel        Keuzelijst, beheer van deelnemers
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       13-11-2019
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

$doctitle = "Deelnemers beheren";
$inactief = false;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\EvenementQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$evt = 0;
$deelnemer_lijst = array();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];
    }
    else
    {
        $evt = 99999999;
    }

    if ( $evt > 0 )
    {
        $logger->debug( 'Deelnemers voor evenement ' . $evt );
        $deelnemers = DeelnemerQuery::create()
        ->useInschrijvingQuery( 'a', 'left join' )
            ->filterByEvenementId( $evt )
        ->enduse()
        ->find();
    }
    else
    {
        $logger->debug( 'Deelnemers voor alle evenementen' );
        $deelnemers = DeelnemerQuery::create()
        ->find();
    //    ->paginate(2, 10);
    }

    foreach ( $deelnemers as $deelnemer )
    {
        $dnr_lijst = array();
        $dnr_lijst["id"] = $deelnemer->getId();

        $persoon = PersoonQuery::create()->findPk( $deelnemer->getPersoonId() );
        $inschrijving = InschrijvingQuery::create()->findPk( $deelnemer->getInschrijvingId() );
        $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );

        if ( $evenement->getStatus() != EVENEMENT_STATUS_OPEN )
        {
            continue;
        }
        
        $dnr_lijst["id"] = $deelnemer->getId();
        $dnr_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
        if ( $persoon->getGeboortedatum() != null )
        {
            $dnr_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format("d-m-Y");
        }
        else
        {
            $dnr_lijst["geboortedatum"] = "00-00-0000";
        }

        $dnr_lijst["email"] = $persoon->getEmail();
        $dnr_lijst["evenement_naam"] = $evenement->getNaam();
        $dnr_lijst["deelnemer_nummer"] = $deelnemer->getId();
        $dnr_lijst["inschrijving_nummer"] = $inschrijving->getId();
        $dnr_lijst["persoon_nummer"] = $deelnemer->getPersoonId();
        $dnr_lijst["totaalbedrag"] = $deelnemer->getTotaalbedrag();
        $dnr_lijst["status"] = inschrijvingStatusNaam( $inschrijving->getStatus() ); //$deelnemer->getStatus();

        $logger->dump( $dnr_lijst );
        array_push( $deelnemer_lijst, $dnr_lijst );
    }       

    // Vullen evenementenlijst
    $evenementen = EvenementQuery::create()
        ->filterByStatus( EVENEMENT_STATUS_OPEN )
        ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
        ->find();

    $evenement_lijst["99999999"] = " ";
    $evenement_lijst["0"] = "Alle";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }

}

// Na drukken op de "inschrijven" knop
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        header( "Location:index.php" );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }
//ToDo: Deze is nog lang niet af!
    if ( isset( $_POST['evenement'] ) )
    {
        $evt = $_POST['evenement'];
        $logger->debug( 'Voor evenement ' . $evt );
        header( "Location:deelnemer_lijst.php?evt=" . $evt );
        exit();
    }

    if ( isset( $_POST['verwijder'] ) )
    {
        $logger->debug( "Verwijderen" );
        $deelnemer = DeelnemerQuery::create()->findPk( $_POST['verwijder'] );
        try
        {
            $deelnemer->delete();
        }
        catch( Exception $ex )
        {
            $logger->warning( $ex->getMessage() );
            $logger->warning( $ex->getPrevious()->getPrevious());
            if (strpos($ex->getPrevious()->getPrevious(), 'SQLSTATE[23000]') !== false) 
            {
                alert('Dit evenement is in gebruik en kan niet verwijderd worden.\nU kunt het evenement sluiten zodat deze niet meer in de lijst verschijnt.');
            }
            else
            {
                alert('Verwijderen is mislukt. Er is iets misgegaan.');
            }
            $statusRegel = "Er is iets mis gegaan..";
            $signalError = true;
            }
        header( "Refresh:0" );
        return;
    }

    try { $setVar = new SetVariable();
    $validateOk += $setVar->name( $bewerk )
         ->go();
    }
    catch( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $statusRegel = "Er is iets mis gegaan..";
        $signalError = true;
        $validateOk = 999;
    }

}

$buttontekst = "Alle evenementen";
$buttonname = "kies";

$smarty->assign('doctitle', $doctitle );
$smarty->assign('buttontekst', $buttontekst );
$smarty->assign('buttonname', $buttonname );
$smarty->assign('Deelnemers', $deelnemer_lijst );
$smarty->assign('aantal', count($deelnemer_lijst) );
$smarty->assign( 'evenementenLijst', $evenement_lijst );
$smarty->assign( 'evenementid', $evt );
$smarty->assign( 'evt', $evt );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'deelnemer_lijst.tpl' );
