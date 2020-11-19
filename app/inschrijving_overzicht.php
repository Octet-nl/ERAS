<?php
/**
 * System      ERAS
 * Module      Lijst met open evenementen
 * Doel        Keuzelijst, overzicht van evenementen waarop kan worden ingeschreven
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       02-10-2019
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

$doctitle = "Overzicht inschrijving";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use fb_model\fb_model\DeelnemerQuery;
use fb_model\fb_model\PersoonQuery;

// Defineer variabelen voor evenement
$contactpersoon_naam = "";
$maxDeelnemers = $extraTekst = $extraInschrijven = $annuleringsverzekering = $id = $opslaan = "";
$evt = $sum = 0;
$status = 0;
$aantalDeelnemers = 0;
$aantal_beschikbaar = 0;
$totaalprijs = "";
$wijzigingDefinitieveInschrijving = false;
$isMedewerker = false;
$inschrijvingId = 0;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$deelnemers_lijst = array();

$deelnemer_lijst = array();
$sessieVariabelen = array();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "registreer.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( isset( $_GET['iid'] ) )
    {
        $logger->debug( "Inschrijving overzicht a.d.h.v. inschrijving ID" );

        $inschrijvingId = $_GET['iid'];

        require_once "session_status.php";

        $sessionOk = setSessieVariabelen( $inschrijvingId, $autorisatie->getUserId() );
        if ( $sessionOk )
        {
            $sessieVariabelen = $_SESSION['inschrijving'];
//            $sessieVariabelen['wijzigen'] = "1";
            //            $_SESSION['inschrijving'] = $sessieVariabelen;
        }
        else
        {
            // Geen inschrijvingsdata? Verwijs naar keuzepagina
            $logger->error( "Probleem bij laden sessiestatus" );
            header( "Location:evenement_kiezen.php" );
            exit();
        }
    }
    else
    {
        $logger->debug( '"Inschrijving overzicht a.d.h.v. sessie "inschrijving"' );
        if ( isset( $_SESSION['inschrijving'] ) )
        {
            $sessieVariabelen = $_SESSION['inschrijving'];
        }
        else
        {
            $logger->info( "Geen sessiestatus en geen inschrijvingID opgevraagd." );
            // Geen inschrijvingsdata? Verwijs naar keuzepagina
            header( "Location:evenement_kiezen.php" );
            exit();
        }
    }

    if ( $autorisatie->getRol() >= AUTORISATIE_STATUS_MEDEWERKER )
    {
        $isMedewerker = true;
    }

    //ToDo: Dit kan weg
//    if ( !empty( $sessieVariabelen['wijzigen'] ) && $sessieVariabelen['wijzigen'] == "1" )
    if ( $autorisatie->getRol() <= AUTORISATIE_STATUS_KLANT )
    {
        if (  ( $sessieVariabelen['inschrijving_status'] == INSCHRIJVING_STATUS_DEFINITIEF ) )
        {
            $wijzigingDefinitieveInschrijving = true;
            $logger->debug( "Wijziging definitieve inschrijving door klant" );
        }
        $logger->debug( "Wijziging maar geen definitieve inschrijving" );
    }
    else
    {
        $wijzigingDefinitieveInschrijving = false;
        $logger->debug( "Geen wijziging inschrijving door klant" );
    }

    $logger->dump( $sessieVariabelen );

    $evt = $sessieVariabelen["evenement_id"];

    $sum = DeelnemerQuery::create()
        ->useInschrijvingQuery( 'a', 'left join' )
        ->filterByEvenementId( $evt )
        ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
        ->enduse()
        ->count();
    $aantal_beschikbaar = $sessieVariabelen["max_deelnemers"] - $sum;

    $inschrijvingId = $sessieVariabelen["inschrijving_id"];

    $deelnemers = DeelnemerQuery::create()->filterByInschrijvingId( $inschrijvingId );

    $aantalDeelnemers = 0;
    $totaalprijs = 0;
    foreach ( $deelnemers as $deelnemer )
    {
        $aantalDeelnemers += 1;
        $persoon = PersoonQuery::create()->findPK( $deelnemer->getPersoonId() );
        $deelnemer_lijst["deelnemer_naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
        $deelnemer_lijst["deelnemer_id"] = $deelnemer->getId();
        $deelnemer_lijst["deelnemer_persoon_id"] = $persoon->getId();
        if ( $persoon->getGeboortedatum() != null )
        {
            $deelnemer_lijst["geb_datum"] = $persoon->getGeboortedatum()->format( 'd-m-Y' );
        }
        else
        {
            $deelnemer_lijst["geb_datum"] = "";
        }
        $deelnemer_lijst["mail"] = $persoon->getEmail();
        $deelnemer_lijst["telefoonnr"] = $persoon->getTelefoonnummer();
        $deelnemer_lijst["bedrag"] = $deelnemer->getTotaalbedrag();
        array_push( $deelnemers_lijst, $deelnemer_lijst );

        $totaalprijs += $deelnemer->getTotaalbedrag();
    }

    if ( !$wijzigingDefinitieveInschrijving )
    {
        $aantal_beschikbaar -= $aantalDeelnemers;
    }

    $totaalprijs = number_format( $totaalprijs, 2 );
    if ( $sessieVariabelen != null )
    {
        $sessieVariabelen["aantal_deelnemers"] = $aantalDeelnemers;
        $_SESSION['inschrijving'] = $sessieVariabelen;
    }
    $logger->dump( $deelnemers_lijst );
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    if ( isset( $_POST['overzicht'] ) )
    {
        header( "Location:inschrijving_kiezen.php?evt=" );
        exit;
    }

    try
    {
        $setVar = new SetVariable();
        $setVar->name( $aantalDeelnemers )->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $sessieVariabelen = $_SESSION['inschrijving'];
    }
    else
    {
        $logger->error( "Systeemfout: Geen sessiestatus in POST." );
        // Geen inschrijvingsdata? Verwijs naar keuzepagina
        header( "Location:evenement_kiezen.php" );
        exit();
    }

    $inschrijvingId = $sessieVariabelen["inschrijving_id"];

//ToDo: Alle URL's hieronder moeten zonder parameter werken
    $actie = "";
    if ( isset( $_POST["afronden"] ) )
    {
        $logger->debug( 'Afronden aanvraag.' );
        header( "Location:inschrijving_afronden.php?evt=" . $sessieVariabelen["evenement_id"] );
        exit();
    }
    elseif ( isset( $_POST["toevoegen"] ) )
    {
        $logger->debug( 'Toevoegen deelnemer.' );
        header( "Location:inschrijving_deelnemer.php?evt=" . $sessieVariabelen["evenement_id"] );
        exit();
    }
    elseif ( isset( $_POST["bewerk"] ) )
    {
        $logger->debug( 'Bewerk deelnemer.' );
        header( "Location:inschrijving_deelnemer.php?evt=" . $sessieVariabelen["evenement_id"] . "&mut=" . $_POST['bewerk'] );
        exit();
    }
    elseif ( isset( $_POST["bewerk_contact"] ) )
    {
        $logger->debug( 'Bewerk contactpersoon ' . $_POST['bewerk_contact'] );
        if ( $aantalDeelnemers > 0 )
        {
            header( "Location:persoon_aanpassen.php?prs=" . $_POST['bewerk_contact'] . "&evt=" . $sessieVariabelen["evenement_id"] );
        }
        else
        {
            header( "Location:inschrijving_contactpersoon.php?prs=" . $_POST['bewerk_contact'] . "&evt=" . $sessieVariabelen["evenement_id"] . "&iid=" . $inschrijvingId );
        }
        exit();
    }
    elseif ( isset( $_POST["verwijder"] ) )
    {
        $logger->debug( 'Verwijder deelnemer.' );
        header( "Location:inschrijving_verwijder_deelnemer.php?evt=" . $sessieVariabelen["evenement_id"] . "&mut=" . $_POST['verwijder'] );
        exit();
    }

    //header( "Location:deelnemer_opvoeren.php?evt=".$opslaan );
}

// Deel 3

$logger->debug( "Totaal beschikbaar: " . $sessieVariabelen["max_deelnemers"] . ", Gebruikt: " . $sum . ", Over: " . $aantal_beschikbaar );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenement_naam', $sessieVariabelen["evenement_naam"] );
$smarty->assign( 'inschrijvingnummer', $inschrijvingId );
$smarty->assign( 'aantal_beschikbaar', $aantal_beschikbaar );
$smarty->assign( 'contactpersoon_naam', $sessieVariabelen["contactpersoon_naam"] );
$smarty->assign( 'contactpersoon_email', $sessieVariabelen["contactpersoon_email"] );
$smarty->assign( 'contactpersoon_id', $sessieVariabelen["contactpersoon_id"] );
$smarty->assign( 'deelnemers', $deelnemers_lijst );
$smarty->assign( 'totaalprijs', $totaalprijs );
$smarty->assign( 'aantalDeelnemers', $aantalDeelnemers );
$smarty->assign( 'changeDefinitief', $wijzigingDefinitieveInschrijving );
$smarty->assign( 'isMedewerker', $isMedewerker );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_overzicht.tpl' );
