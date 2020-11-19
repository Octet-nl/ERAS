<?php
/**
 * System      ERAS
 * Module      Inschrijving kiezen
 * Doel        Ingelogde klant kan kiezen uit zijn eigen inschrijvingen of een nieuwe opvoeren
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

$doctitle = "Inschrijving kiezen";
$inactief = false;
$evt = 0;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use fb_model\fb_model\GebruikerQuery;
use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\FactuurNummerQuery;
use Propel\Runtime\ActiveQuery\Criteria;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$inschrijvingen = array();
$inschrijving_lijst = array();
$evenement_lijst = array();
$sessieVariabelen = null;
$contactpersoonId = 0;
$evenementnaam = "";
$inschrijving_open = 0;

$ini = parse_ini_file( CONFIG_FILENAME, true );
$facturenDirectory = $ini['settings']['facturen_directory'] . '/';

$sessie = new Sessie();

if ( isset( $_SESSION['inschrijving'] ) )
{
    $sessieVariabelen = $_SESSION['inschrijving'];
}

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "registreer.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

// DEEL 1
// Opbouwen inschrijvingslijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];
        $evenement = EvenementQuery::create()->findPk( $evt );
        if ( $evenement != null )
        {
            $evenementnaam = $evenement->getNaam();
        }

        $gebruiker = GebruikerQuery::create()->filterByUserId( $autorisatie->getUserId() )->findOne();
        if ( $gebruiker == null )
        {
            $logger->info( "Userid " . $autorisatie->getUserId() . " is niet gevonden!" );
        }
        if ( $gebruiker != null )
        {
            $logger->debug( "Userid: " . $gebruiker->getUserId() . ", persoon ID: " . $gebruiker->getPersoonId() );

            $contactpersoonId = $gebruiker->getPersoonId();

            // if ( $evt > 0 )
            // {
            //     $inschrijvingen = InschrijvingQuery::create()
            //         ->filterByEvenementId( $evt )
            //         ->filterByContactPersoonId( $contactpersoonId )
            //         ->find();
            // }
            // else
            {
                $inschrijvingen = InschrijvingQuery::create()
                    ->filterByContactPersoonId( $contactpersoonId )
                    ->find();
            }

            foreach ( $inschrijvingen as $inschrijving )
            {
                $logger->debug( "Inschrijving ID: " . $inschrijving->getId() );
                $ins_lijst = array();

                if ( $inschrijving->getStatus() == INSCHRIJVING_STATUS_GEANNULEERD ) //||
                //$inschrijving->getStatus() == INSCHRIJVING_STATUS_DEFINITIEF )
                {
                    continue;
                }

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

                $aantalDeelnemers = DeelnemerQuery::create()->findByInschrijvingId( $inschrijving->getId() )->count();

                $ins_lijst["opties"] = "";
                $ins_lijst["telefoon"] = $persoon->getTelefoonnummer();
                $ins_lijst["straat"] = $persoon->getStraat();
                $ins_lijst["huisnummer"] = $persoon->getHuisnummer();
                $ins_lijst["postcode"] = $persoon->getPostcode();
                $ins_lijst["huisnummer_toevoeging"] = $persoon->getToevoeging();
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
                $ins_lijst["aantal_deelnemers"] = $aantalDeelnemers;
                $ins_lijst["datum"] = $inschrijving->getDatumInschrijving()->format( "d-m-Y h:m:s" );

                $factuur = FactuurNummerQuery::create()
                            ->filterByInschrijvingId( $inschrijving->getId() )
                            ->orderById(Criteria::DESC)
                            ->findOne();

                if ( $factuur != null )
                {
                    $factuurNaam = $facturenDirectory . $inschrijving->getId() . sprintf("-%04d", $factuur->getId() ) . ".pdf";
                }
                else
                {
                    $factuurNaam = "";
                }

                $ins_lijst["factuurNaam"] = $factuurNaam;

                $logger->dump( $ins_lijst );
                array_push( $inschrijving_lijst, $ins_lijst );
            }

            // Vullen evenementenlijst
            $evenementen = EvenementQuery::create()
                ->filterByStatus( EVENEMENT_STATUS_OPEN )
                ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
                ->find();

            foreach ( $evenementen as $evenement )
            {
                $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
            }
            $evenement_lijst["0"] = "Alle";
        }
    }
}

// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    try
    {
        $setVar = new SetVariable();
        $setVar->name( $evt )->go();
        $setVar->name( $evenementnaam )->go();
        $setVar->name( $inschrijven )->go();
        $setVar->name( $contactpersoonId )->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( $inschrijven != "" )
    {
        $logger->debug( 'Nieuwe inschrijving.' );
        if ( $contactpersoonId > 0 )
        {
            header( "Location:inschrijving_contactpersoon.php?evt=" . $evt . "&prs=" . $contactpersoonId );
        }
        else
        {
            header( "Location:inschrijving_contactpersoon.php?evt=" . $evt );
        }
        exit();
    }

    if ( isset( $_POST['aanpassen'] ) )
    {
        $logger->debug( 'Aanpassen.' );
//        if ( $sessieVariabelen != null )
        {
            $sessieVariabelen["wijzigen"] = "1";
            $_SESSION['inschrijving'] = $sessieVariabelen;
        }

        header( "Location:inschrijving_overzicht.php?iid=" . $_POST["aanpassen"] );
        exit();
    }

    if ( isset( $_POST['factuur'] ) )
    {
        $logger->debug( 'Factuur.' );
        header( "Location:". $_POST["factuur"]  );
        exit();
    }

    if ( isset( $_POST['annuleer'] ) )
    {
        $logger->debug( "Annuleren" );
        $inschrijving = InschrijvingQuery::create()->findPk( $_POST['annuleer'] );
        try
        {
            $inschrijving->setStatus( INSCHRIJVING_STATUS_GEANNULEERD );
            $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
            $inschrijving->save();
            $logger->debug( 'Annuleren is gelukt. Inschrijving ID: ' . $inschrijving->getId() );
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
}

$buttontekst = "Alle inschrijvingen";
$buttonname = "inact";

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'buttontekst', $buttontekst );
$smarty->assign( 'buttonname', $buttonname );
$smarty->assign( 'Inschrijvingen', $inschrijving_lijst );
$smarty->assign( 'aantal', count( $inschrijving_lijst ) );
$smarty->assign( 'evenementenLijst', $evenement_lijst );
$smarty->assign( 'evenementnaam', $evenementnaam );
$smarty->assign( 'contactpersoonId', $contactpersoonId );
$smarty->assign( 'evenementid', $evt );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'inschrijving_open', $evt );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_kiezen.tpl' );
