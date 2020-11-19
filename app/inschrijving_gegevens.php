<?php
/**
 * System      ERAS
 * Module      Inschrijvingsgegevens
 * Doel        Overzicht van een inschrijving
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       24-03-2020
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

$doctitle = "Inschrijvingen beheren";
$inactief = false;
$id = 0;
$isget = '0';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\PersoonQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$inschrijving_lijst = array();

$sessie = new Sessie();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// Opbouwen inschrijvingslijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

//    unset( $_SESSION["inschrijving"] );

    $isget = '1';
    if ( isset( $_GET['id'] ) )
    {
        $id = $_GET['id'];

        $inschrijving = InschrijvingQuery::create()
            ->findPk( $id );

        $ins_lijst = array();

        $persoon = PersoonQuery::create()->findPk( $inschrijving->getContactPersoonId() );
        if ( $persoon == null )
        {
            $logger->error( "Persoon niet gevonden. Id=" . $inschrijving->getContactPersoonId() );
        }
        $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
        if ( $evenement == null )
        {
            $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
        }

        $ins_lijst["id"] = $inschrijving->getId();
        $ins_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
        if ( $persoon->getGeboortedatum() != null )
        {
            $ins_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format( "d-m-Y" );
        }
        else
        {
            $ins_lijst["geboortedatum"] = "00-00-0000";
        }

        $ins_lijst["opties"] = "";
        $ins_lijst["telefoon"] = $persoon->getTelefoonnummer();
        $ins_lijst["straat"] = $persoon->getStraat();
        $ins_lijst["huisnummer"] = $persoon->getHuisnummer();
        $ins_lijst["postcode"] = $persoon->getPostcode();
        $ins_lijst["huisnummer"] = $persoon->getHuisnummer();
        $ins_lijst["woonplaats"] = $persoon->getWoonplaats();
        $ins_lijst["email"] = $persoon->getEmail();
        $ins_lijst["evenement_naam"] = $evenement->getNaam();
        $ins_lijst["extra_contact"] = $evenement->getExtraContactGegevens();
        $ins_lijst["extra_deelnemer"] = $evenement->getExtraDeelnemerGegevens();
        $ins_lijst["totaalbedrag"] = $inschrijving->getTotaalbedrag();
        $ins_lijst["korting"] = $inschrijving->getKorting();
        $ins_lijst["contactid"] = $inschrijving->getContactPersoonId();
        $ins_lijst["reeds_betaald"] = $inschrijving->getReedsBetaald();
        $ins_lijst["te_betalen"] = $inschrijving->getNogTeBetalen();
        $ins_lijst["status"] = inschrijvingStatusNaam( $inschrijving->getStatus() );
        $ins_lijst["datum"] = $inschrijving->getDatumInschrijving()->format( "d-m-Y h:m:s" );

        $deelnemer_lijst = array();
        $deelnemers = DeelnemerQuery::create()->findByInschrijvingId( $inschrijving->getId() );

        $logger->dump( $ins_lijst );
        //array_push( $inschrijving_lijst, $ins_lijst );
        $inschrijving_lijst = $ins_lijst;

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
            $dnr_lijst["telefoon"] = $persoon->getTelefoonnummer();
            $dnr_lijst["straat"] = $persoon->getStraat();
            $dnr_lijst["huisnummer"] = $persoon->getHuisnummer();
            $dnr_lijst["postcode"] = $persoon->getPostcode();
            $dnr_lijst["huisnummer"] = $persoon->getHuisnummer();
            $dnr_lijst["woonplaats"] = $persoon->getWoonplaats();
            $dnr_lijst["email"] = $persoon->getEmail();
        
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
    

    }

    // // Vullen evenementenlijst
    // $evenementen = EvenementQuery::create()
    //     ->filterByStatus( EVENEMENT_STATUS_OPEN )
    //     ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
    //     ->find();

    // $evenement_lijst["0"] = "Alle";
    // foreach ( $evenementen as $evenement )
    // {
    //     $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    // }

}

// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $bewerk )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $statusRegel = "Er is iets misgegaan...";
        $signalError = true;
        $validateOk = 999;
        exit;
    }

    if ( isset( $_POST['terug'] ) )
    {
        header( "Location:deelnemer_lijst.php" );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }


}

$buttontekst = "Alle inschrijvingen";
$buttonname = "inact";

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'buttontekst', $buttontekst );
$smarty->assign( 'buttonname', $buttonname );
//$smarty->assign( 'Inschrijvingen', $inschrijving_lijst );
$smarty->assign( 'inschrijving', $inschrijving_lijst );
$smarty->assign( 'deelnemerLijst', $deelnemer_lijst );
$smarty->assign( 'evenementid', $id );
$smarty->assign( 'evt', $id );
$smarty->assign( 'isget', $isget );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_gegevens.tpl' );
