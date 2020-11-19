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

$doctitle = "Klant zoeken";
$inactief = false;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\PersoonQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$inschrijfnummer = $inschrijfnummerErr = "";
$postcode = $postcodeErr = "";
$huisnummer = $huisnummerErr = "";
$naam = $naamErr = "";
$email = $emailErr = "";

$evt = 0;
$personenlijst = array();

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set();
    // Opbouwen evenementlijst
    $evenementen = EvenementQuery::create()
        ->find();

    $evenement_lijst["99999999"] = " ";
    $evenement_lijst["0"] = "Alle";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }
}

// Na drukken op de "inschrijven" knop
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

    $setVar = new SetVariable();
    $validateOk = 0;

    $setVar->name( $evenement_lijst )
        ->go();

    if ( isset( $_POST['emailzoek'] ) )
    {
        $validateOk = $setVar->name( $email )
            ->onerror( $emailErr )
            ->required()
            ->go();

        if ( $validateOk == 0 )
        {
            $logger->debug( "Zoeken op email adres: '%" . $email . "%'" );

            $personen = PersoonQuery::create()
                ->where( 'UPPER(Persoon.Email) like ?', '%' . strtoupper( $email ) . '%' );

            foreach ( $personen as $persoon )
            {
                $prs_lijst = array();
                $ins_lijst = array();

                $prs_lijst["id"] = $persoon->getId();

                $prs_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
                if ( $persoon->getGeboortedatum() != null )
                {
                    $prs_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format( "d-m-Y" );
                }
                else
                {
                    $prs_lijst["geboortedatum"] = "00-00-0000";
                }

                $prs_lijst["email"] = $persoon->getEmail();
                $prs_lijst["adres"] = $persoon->getStraat() . " " . $persoon->getHuisnummer() . ", " . $persoon->getPostcode() . " " . $persoon->getWoonplaats();
                $prs_lijst["huisnummer"] = $persoon->getHuisnummer();

                $inschrijvingen = InschrijvingQuery::create()->filterByContactPersoonId( $persoon->getId() );
                foreach ( $inschrijvingen as $inschrijving )
                {
                    $ins_item = array();
                    $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                    if ( $evenement == null )
                    {
                        $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                    }
                    else
                    {
                        $ins_item["inschrijfnr"] = $inschrijving->getId();
                        $ins_item["evenement"] = $evenement->getNaam();
                    }
        
                    array_push( $ins_lijst, $ins_item );
                }

                $prs_lijst["inschrijvingen"] = $ins_lijst;

                array_push( $personenlijst, $prs_lijst );
            }
        }
    }

    if ( isset( $_POST['naamzoek'] ) )
    {
        $validateOk = $setVar->name( $naam )
            ->onerror( $naamErr )
            ->required()
            ->go();

        if ( $validateOk == 0 )
        {
            $logger->debug( "Zoeken op naam: " . '%' . $naam . '%' );

            //$personen = PersoonQuery::create()->filterByAchternaam( '%'.$naam.'%' )->find();

            $personen = PersoonQuery::create()
                ->where( 'UPPER(Persoon.Achternaam) like ?', '%' . strtoupper( $naam ) . '%' );

            // $logger->dump( $personen );

            foreach ( $personen as $persoon )
            {
                $prs_lijst = array();
                $ins_lijst = array();

                $prs_lijst["id"] = $persoon->getId();

                $prs_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
                if ( $persoon->getGeboortedatum() != null )
                {
                    $prs_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format( "d-m-Y" );
                }
                else
                {
                    $prs_lijst["geboortedatum"] = "00-00-0000";
                }

                $prs_lijst["email"] = $persoon->getEmail();
                $prs_lijst["adres"] = $persoon->getStraat() . " " . $persoon->getHuisnummer() . ", " . $persoon->getPostcode() . " " . $persoon->getWoonplaats();
                $prs_lijst["huisnummer"] = $persoon->getHuisnummer();

                $inschrijvingen = InschrijvingQuery::create()->filterByContactPersoonId( $persoon->getId() );
                foreach ( $inschrijvingen as $inschrijving )
                {
                    $ins_item = array();
                    $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                    if ( $evenement == null )
                    {
                        $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                    }
                    else
                    {
                        $ins_item["inschrijfnr"] = $inschrijving->getId();
                        $ins_item["evenement"] = $evenement->getNaam();
                    }
        
                    array_push( $ins_lijst, $ins_item );
                }

                $prs_lijst["inschrijvingen"] = $ins_lijst;

                array_push( $personenlijst, $prs_lijst );
            }

        }
    }

    if ( isset( $_POST['inschrijfnummerzoek'] ) )
    {
        $validateOk = $setVar->name( $inschrijfnummer )
            ->onerror( $inschrijfnummerErr )
            ->required()
            ->go();

        if ( $validateOk == 0 )
        {
            $logger->debug( "Zoeken op inschrijfnummer: " . $inschrijfnummer );

            $inschrijving = InschrijvingQuery::create()->findPk( $inschrijfnummer );
            if ( $inschrijving != null )
            {
                $persoon = PersoonQuery::create()->findPk( $inschrijving->getContactpersoonId() );

                $prs_lijst = array();
                $ins_lijst = array();

                $prs_lijst["id"] = $persoon->getId();

                $prs_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
                if ( $persoon->getGeboortedatum() != null )
                {
                    $prs_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format( "d-m-Y" );
                }
                else
                {
                    $prs_lijst["geboortedatum"] = "00-00-0000";
                }

                $prs_lijst["email"] = $persoon->getEmail();
                $prs_lijst["adres"] = $persoon->getStraat() . " " . $persoon->getHuisnummer() . ", " . $persoon->getPostcode() . " " . $persoon->getWoonplaats();
                $prs_lijst["huisnummer"] = $persoon->getHuisnummer();

                $inschrijvingen = InschrijvingQuery::create()->filterByContactPersoonId( $persoon->getId() );
                foreach ( $inschrijvingen as $inschrijving )
                {
                    $ins_item = array();
                    $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                    if ( $evenement == null )
                    {
                        $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                    }
                    else
                    {
                        $ins_item["inschrijfnr"] = $inschrijving->getId();
                        $ins_item["evenement"] = $evenement->getNaam();
                    }
        
                    array_push( $ins_lijst, $ins_item );
                }

                $prs_lijst["inschrijvingen"] = $ins_lijst;

                array_push( $personenlijst, $prs_lijst );

            }
        }
    }

    if ( isset( $_POST['postcode_huisnummerzoek'] ) )
    {
        $setVar->name( $huisnummer )
            ->go();

        $validateOk = $setVar->name( $postcode )
            ->onerror( $postcodeErr )
            ->required()
            ->go();

        if ( $validateOk == 0 )
        {

            if ( $huisnummer == null )
            {
                $personen = PersoonQuery::create()->filterByPostcode( $postcode )->find();
            }
            else
            {
                $personen = PersoonQuery::create()->filterByPostcode( $postcode )->filterByHuisnummer( $huisnummer )->find();
            }

            foreach ( $personen as $persoon )
            {
                $prs_lijst = array();
                $ins_lijst = array();

                $prs_lijst["id"] = $persoon->getId();

                $prs_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
                if ( $persoon->getGeboortedatum() != null )
                {
                    $prs_lijst["geboortedatum"] = $persoon->getGeboortedatum()->format( "d-m-Y" );
                }
                else
                {
                    $prs_lijst["geboortedatum"] = "00-00-0000";
                }

                $prs_lijst["email"] = $persoon->getEmail();
                $prs_lijst["adres"] = $persoon->getStraat() . " " . $persoon->getHuisnummer() . ", " . $persoon->getPostcode() . " " . $persoon->getWoonplaats();
                $prs_lijst["huisnummer"] = $persoon->getHuisnummer();

                $inschrijvingen = InschrijvingQuery::create()->filterByContactPersoonId( $persoon->getId() );
                foreach ( $inschrijvingen as $inschrijving )
                {
                    $ins_item = array();
                    $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                    if ( $evenement == null )
                    {
                        $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                    }
                    else
                    {
                        $ins_item["inschrijfnr"] = $inschrijving->getId();
                        $ins_item["evenement"] = $evenement->getNaam();
                    }
        
                    array_push( $ins_lijst, $ins_item );
                }

                $prs_lijst["inschrijvingen"] = $ins_lijst;
                $logger->dump( $prs_lijst );

                array_push( $personenlijst, $prs_lijst );
            }
        }
    }

    try {
        $validateOk = $setVar->name( $bewerk )
            ->go();
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

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'email', $email );
$smarty->assign( 'emailErr', $emailErr );
$smarty->assign( 'naam', $naam );
$smarty->assign( 'naamErr', $naamErr );
$smarty->assign( 'inschrijfnummer', $inschrijfnummer );
$smarty->assign( 'inschrijfnummerErr', $inschrijfnummerErr );
$smarty->assign( 'postcode', $postcode );
$smarty->assign( 'postcodeErr', $postcodeErr );
$smarty->assign( 'huisnummer', $huisnummer );
$smarty->assign( 'huisnummerErr', $huisnummerErr );

$smarty->assign( 'personenlijst', $personenlijst );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'klant_zoeken.tpl' );
