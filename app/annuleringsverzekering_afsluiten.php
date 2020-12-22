<?php
/**
 * System      ERAS
 * Module      Afsluiten annuleringsverzekering
 * Doel        Bij inschrijving vermelden dat annuleringsverzekering is afgesloten.
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       29-08-2020
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

$doctitle = "Annuleringsverzekering afsluiten";
$inactief = false;
$evt = 0;
$isget = '0';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use Propel\Runtime\ActiveQuery\Criteria;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\Contactlog;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$ini = parse_ini_file( CONFIG_FILENAME, true );

$inschrijving_lijst = array();
$evenement_lijst = array();

$sessie = new Sessie();
$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// Opbouwen inschrijvingslijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $history->set( );

    if ( isset( $_GET['evt'] )  )
    {
        $evt = $_GET['evt'];
    }
    else
    {
        $evt = 99999999;
    }

    if ( $evt > 0 )
    {
        $inschrijvingen = InschrijvingQuery::create()
        ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
        ->filterByEvenementId( $evt )
        ->filterByAnnuleringsverzekering( ANNULERINGSVERZEKERING_GEEN, Criteria::GREATER_THAN )
        ->filterByAnnuleringsverzekeringAfgesloten( '0000-00-00 00:00:00' )
        ->find();
    }
    else
    {
        $inschrijvingen = InschrijvingQuery::create()
        ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
        ->filterByAnnuleringsverzekering( ANNULERINGSVERZEKERING_GEEN, Criteria::GREATER_THAN )
        ->filterByAnnuleringsverzekeringAfgesloten( '0000-00-00 00:00:00' )
        ->find();
    }

    foreach ( $inschrijvingen as $inschrijving )
    {

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

        if ( $evenement->getStatus() != EVENEMENT_STATUS_OPEN )
        {
            continue;
        }

        $ins_lijst = array();

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
        $ins_lijst["reeds_betaald"] = $inschrijving->getReedsBetaald();
        $ins_lijst["te_betalen"] = $inschrijving->getNogTeBetalen();
        $ins_lijst["status"] = inschrijvingStatusNaam( $inschrijving->getStatus() );
        $ins_lijst["datum"] = $inschrijving->getDatumInschrijving()->format( "d-m-Y h:m:s" );
        $ins_lijst["annulering"] = annuleringsverzekeringNaam( $inschrijving->getAnnuleringsverzekering() );

        $logger->dump( $ins_lijst );
        array_push( $inschrijving_lijst, $ins_lijst );
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

    $afgesloten_lijst['0'] = 'Niet afgesloten verzekeringen';
    $afgesloten_lijst['1'] = 'Afgesloten verzekeringen';
}

// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        //header( "Location:index.php" );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['ongedaan'] ) )
    {
        header( "Location:annuleringsverzekering_ongedaan.php" );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    if ( isset( $_POST["bevestig"] ) )
    {
        $id = $_POST["bevestig"];
        $inschrijving = InschrijvingQuery::create()->findPk( $id );
        if ( $inschrijving != null )
        {
            $logger->debug( 'Markeer AV afgesloten voor inschrijving: ' . $id . " op " . $nu );
            $inschrijving->setAnnuleringsverzekeringAfgesloten( date( "d-m-Y H:i:s" ) );
            $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
            $inschrijving->save();

            $contactlog = new Contactlog;
            $contactlog->setPersoonId( $inschrijving->getContactPersoonId() );
            $contactlog->setTekst( "Annuleringsverzekering afgesloten door " . $autorisatie->getUserId() . " op " . date( "d-m-Y H:i:s" ) );
            $contactlog->setGemaaktDoor( $email );
            $contactlog->save();
        }
        else
        {
            $logger->error( "Kan inschrijving niet vinden, ID=" . $id );
        }
    }
    else if ( isset( $_POST["aangevinkt"] ) )
    {
        if ( isset($_POST['id']) )
        {
            foreach ( $_POST['id'] as $id )
            {
                $inschrijving = InschrijvingQuery::create()->findPk( $id );
                if ( $inschrijving != null )
                {
                    $logger->debug( 'Markeer AV afgesloten voor inschrijving: ' . $id . " op " . $nu );
                    $inschrijving->setAnnuleringsverzekeringAfgesloten( date( "d-m-Y H:i:s" ) );
                    $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
                    $inschrijving->save();

                    $contactlog = new Contactlog;
                    $contactlog->setPersoonId( $inschrijving->getContactPersoonId() );
                    $contactlog->setTekst( "Annuleringsverzekering afgesloten door " . $autorisatie->getUserId() . " op " . date( "d-m-Y H:i:s" ) );
                    $contactlog->setGemaaktDoor( $email );
                    $contactlog->save();
                }
                else
                {
                    $logger->error( "Kan inschrijving niet vinden, ID=" . $id );
                }
            }
        }
        else
        {
            $logger->debug( 'Markeer aangevinkt gedrukt, maar geen vinkjes gevonden' );
        }
    }

    if ( isset( $_POST["evenement"] ) )
    {
        $evt = $_POST["evenement"];
        $logger->debug( 'Evenement filter: ' . $evt );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt  );
        exit();
    }

    try
    {
        $validateOk = 0;
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
    }

}

// Deel 3

$buttontekst = "Alle inschrijvingen";
$buttonname = "inact";

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'buttontekst', $buttontekst );
$smarty->assign( 'buttonname', $buttonname );
$smarty->assign( 'Inschrijvingen', $inschrijving_lijst );
$smarty->assign( 'evenementenLijst', $evenement_lijst );
$smarty->assign( 'evenementid', $evt );
$smarty->assign( 'aantal', count( $inschrijving_lijst ) );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'isget', $isget );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'annuleringsverzekering_afsluiten.tpl' );
