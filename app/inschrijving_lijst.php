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

$doctitle = "Inschrijvingen beheren";
$inactief = false;

$evt = 0;
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
use \fb_model\fb_model\Contactlog;
use \fb_model\fb_model\FactuurNummerQuery;
use Propel\Runtime\ActiveQuery\Criteria;

$logger = new Logger();
$logger->level( LOGLEVEL );

$history = new History();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

$statusRegel = "";
$signalError = false;

$ini = parse_ini_file( CONFIG_FILENAME, true );
$facturenDirectory = $ini['settings']['facturen_directory'] . '/';

$inschrijving_lijst = array();
$evenement_lijst = array();


// DEEL 1
// Opbouwen inschrijvingslijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    //$history->reset( );
    $history->set( );

    unset( $_SESSION["inschrijving"] );

    $status = "";

    $isget = '1';
    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];

        $statusCode = 0;
        if ( isset( $_GET['status'] ) )
        {
//ToDo: open, definitief en annuleer moeten uit de database gehaald worden
            $status = $_GET['status'];
            if ( $status == "all" || $status == "onbetaald" )
            {
                $statusCode = 0;
            }
            elseif ( $status == "open" )
            {
                $statusCode = INSCHRIJVING_STATUS_OPEN;
            }
            elseif ( $status == "definitief" )
            {
                $statusCode = INSCHRIJVING_STATUS_DEFINITIEF;
            }
            elseif ( $status == "annuleer" )
            {
                $statusCode = INSCHRIJVING_STATUS_GEANNULEERD;
            }
        }

        if ( $evt > 0 )
        {
            if ( $statusCode == 0 )
            {
                if ( $status == "onbetaald" )
                {
                    $inschrijvingen = InschrijvingQuery::create()
                    ->filterByEvenementId( $evt )
                    ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
                    ->filterByNogTeBetalen( 0, Criteria::GREATER_THAN )
                    ->find();
                }
                else
                {
                    $inschrijvingen = InschrijvingQuery::create()
                    ->filterByEvenementId( $evt )
                    ->find();
                }
            }
            else
            {
                $inschrijvingen = InschrijvingQuery::create()
                    ->filterByEvenementId( $evt )
                    ->filterByStatus( $statusCode )
                    ->find();
            }
        }
        else
        {
            if ( $statusCode == 0 )
            {
                if ( $status == "onbetaald" )
                {
                    $inschrijvingen = InschrijvingQuery::create()
                    ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
                    ->filterByNogTeBetalen( 0, Criteria::NOT_EQUAL )
                    ->find();
                }
                else
                {
                    $inschrijvingen = InschrijvingQuery::create()
                        ->find();
                    //->paginate(2, 10);
                }
            }
            else
            {
                $inschrijvingen = InschrijvingQuery::create()
                    ->filterByStatus( $statusCode )
                    ->find();
            }
        }

        foreach ( $inschrijvingen as $inschrijving )
        {
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

            if ( $evenement->getStatus() != EVENEMENT_STATUS_OPEN )
            {
                continue;
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

            $factuurNummer = 0;
            // Vind laatste factuur (met hoogste ID)
            $factuur = FactuurNummerQuery::create()->filterByInschrijvingId( $inschrijving->getId() )->orderById('desc')->findOne();
            if ( $factuur != null )
            {
                $factuurNummer =  $inschrijving->getId() . sprintf("-%04d", $factuur->getId() );
            }

            $aantalDeelnemers = DeelnemerQuery::create()->findByInschrijvingId( $inschrijving->getId() )->count();

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
            $ins_lijst["factuurnummer"] = $factuurNummer;
            $ins_lijst["annuleringsverzekering"] = annuleringsverzekeringNaam( $inschrijving->getAnnuleringsverzekering() );
            $annuleringdat = $inschrijving->getAnnuleringsverzekeringAfgesloten();
            if ( $annuleringdat != null )
            {
                $annulering = $annuleringdat->format( "d-m-Y h:m:s" );
            }
            else
            {
                $annulering = "(nvt)";
            }
            $ins_lijst["avafgesloten"] = $annulering;
            $ins_lijst["aantal_deelnemers"] = $aantalDeelnemers;
            $ins_lijst["datum"] = $inschrijving->getDatumInschrijving()->format( "d-m-Y h:m:s" );

            $logger->dump( $ins_lijst );
            array_push( $inschrijving_lijst, $ins_lijst );
        }

    }

    // Vullen evenementenlijst
    $evenementen = EvenementQuery::create()
        ->filterByStatus( EVENEMENT_STATUS_OPEN )
        ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
        ->find();

    $evenement_lijst["0"] = "Alle";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }

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
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    $evt = $_POST["evenement"];
    $logger->debug( 'Evenement filter: ' . $evt );

    if ( isset( $_POST['stat_all'] ) )
    {
        $logger->debug( 'Alle inschrijvingen.' );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt . "&status=all" );
        exit();
    }
    elseif ( isset( $_POST['stat_open'] ) )
    {
        $logger->debug( 'Openstaande inschrijvingen.' );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt . "&status=open" );
        exit();
    }
    elseif ( isset( $_POST['stat_def'] ) )
    {
        $logger->debug( 'Definitieve inschrijvingen.' );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt . "&status=definitief" );
        exit();
    }
    elseif ( isset( $_POST['stat_deb'] ) )
    {
        $logger->debug( 'Onbetaalde inschrijvingen.' );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt . "&status=onbetaald" );
        exit();
    }
    elseif ( isset( $_POST['stat_ann'] ) )
    {
        $logger->debug( 'Geannuleerde inschrijvingen.' );
        header( "Location:" . $_SERVER['PHP_SELF'] . "?evt=" . $evt . "&status=annuleer" );
        exit();
    }

    if ( isset( $_POST['aanpassen'] ) )
    {
        $logger->debug( 'Aanpassen.' );

//ToDo: Hertesten        
        $sessieVariabelen = array();
        $sessieVariabelen["inschrijving_id"] = $_POST["aanpassen"];
        $sessieVariabelen["wijzigen"] = "1";
        $_SESSION['inschrijving'] = $sessieVariabelen;

        header( "Location:inschrijving_overzicht.php?iid=" . $_POST["aanpassen"] );
        exit();
    }

    if ( isset( $_POST['betaling'] ) )
    {
        $logger->debug( 'Betaling.' );

        header( "Location:betaling_opvoeren.php?iid=" . $_POST["betaling"] );
        exit();
    }

    if ( isset( $_POST['factuur'] ) )
    {
        $logger->debug( 'Factuur.' );
        header( "Location:". $facturenDirectory . $_POST["factuur"] . ".pdf"  );
        exit();
    }

    if ( isset( $_POST['open'] ) )
    {
        $logger->debug( "Openen" );
        try
        {
            $inschrijving = InschrijvingQuery::create()->findPk( $_POST['open'] );
            $oudeStatus = $inschrijving->getStatus();
            $inschrijving->setStatus( INSCHRIJVING_STATUS_OPEN );
            $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
            $inschrijving->save();

            $contactlog = new Contactlog;
            $contactlog->setPersoonId( $inschrijving->getContactPersoonId() );
            $contactlog->setTekst( "Inschrijving (id " . $_POST['open'] . ", status " . inschrijvingStatusNaam( $oudeStatus ) . ") is geopend door " . $autorisatie->getUserId() . " op " . date( "d-m-Y H:i:s" ) );
            $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
            $contactlog->save();

        }
        catch ( Exception $ex )
        {
            $logger->error( 'Openen is mislukt. Er is iets misgegaan.' );
            $logger->warning( $ex->getMessage() );
            $logger->warning( $ex->getPrevious() );
            $logger->warning( $ex->getPrevious()->getPrevious() );
            alert( 'Openen is mislukt. Er is iets misgegaan.' );
        }
        header( "Refresh:0" );
        return;
    }

    if ( isset( $_POST['annuleer'] ) )
    {
        $logger->debug( "Annuleren" );
        $inschrijving = InschrijvingQuery::create()->findPk( $_POST['annuleer'] );
        try
        {
            $oudeStatus = $inschrijving->getStatus();
            $inschrijving->setStatus( INSCHRIJVING_STATUS_GEANNULEERD );
            $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
            $inschrijving->save();

            $contactlog = new Contactlog;
            $contactlog->setPersoonId( $inschrijving->getContactPersoonId() );
            $contactlog->setTekst( "Inschrijving (id " . $_POST['annuleer'] . " , status " . inschrijvingStatusNaam( $oudeStatus ) . ") is geannuleerd door " . $autorisatie->getUserId() . " op " . date( "d-m-Y H:i:s" ) );
            $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
            $contactlog->save();
        }
        catch ( Exception $ex )
        {
            $logger->error( 'Annuleren is mislukt. Er is iets misgegaan.' );
            $logger->warning( $ex->getMessage() );
            $logger->warning( $ex->getPrevious() );
            $logger->warning( $ex->getPrevious()->getPrevious() );
            alert( 'Annuleren is mislukt. Er is iets misgegaan.' );
        }
        header( "Refresh:0" );
        return;
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

$buttontekst = "Alle inschrijvingen";
$buttonname = "inact";

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'buttontekst', $buttontekst );
$smarty->assign( 'buttonname', $buttonname );
$smarty->assign( 'Inschrijvingen', $inschrijving_lijst );
$smarty->assign( 'statusDefinitief', inschrijvingStatusNaam( INSCHRIJVING_STATUS_DEFINITIEF ) );
$smarty->assign( 'statusGeannuleerd', inschrijvingStatusNaam( INSCHRIJVING_STATUS_GEANNULEERD ) );
$smarty->assign( 'aantal', count( $inschrijving_lijst ) );
$smarty->assign( 'evenementenLijst', $evenement_lijst );
$smarty->assign( 'evenementid', $evt );
$smarty->assign( 'factuurdir', $facturenDirectory );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'isget', $isget );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_lijst.tpl' );
