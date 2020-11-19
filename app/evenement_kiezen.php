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

$doctitle = "Evenement: ";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\EvenementQuery;

// Defineer variabelen voor evenement
$evenement_naam = $korteOmschrijving = $langeOmschrijving = $datumBegin = $datumEind = $prijs = "";
$maxDeelnemers = $annuleringsverzekering = $id = $opslaan = "";
$evt = $sum = 0;
$status = 0;

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenementen_lijst = array();

$doctitle = "Inschrijven Evenement";

//$autorisatie = new Autorisatie();
//$autorisatie->setNotAuth( "login.php" );
//$autorisatie->validate( AUTORISATIE_STATUS_GEEN );

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?evt= parameter,
// Voorbeeld: http://www.mijnsite.com/evenement?evt=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van evenement 234.
// Wordt de ?id= parameter niet opgegeven dan gaat het om een nieuw evenement en wordt
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    // Bestaande inschrijvingsgegevens verwijderen voordat een nieuwe wordt opgevoerd.
    unset( $_SESSION['inschrijving'] );

    $systeem = new Sysdb( true );

    $evenementen = EvenementQuery::create()
                   ->filterByStatus( array(EVENEMENT_STATUS_OPEN, EVENEMENT_STATUS_GEANNULEERD, EVENEMENT_STATUS_VOL) )
                   ->find();

    if ( $evenementen == null )
    {
        alert( "Er zijn geen actieve evenementen." );
        exit;
    }

    foreach ( $evenementen as $evenement )
    {
        $startDatum = new DateTime( $evenement->getDatumBegin()->format( 'Y-m-d' ) );
        $vandaag = new DateTime( date( "Y-m-d" ) );

        //ToDo: Als het evenement al is begonnen, kun je niet meer inschrijven.
        // (Is dat terecht?).
        //if ( $vandaag > $startDatum )
        //{
        //    continue;
        //}

        if ( $evenement->getStatus() == EVENEMENT_STATUS_VOL )
        {
            $aantal_beschikbaar = 0;
        }
        else
        {
            $sum = DeelnemerQuery::create()
              ->useInschrijvingQuery( 'a', 'left join' )
              ->filterByEvenementId( $evenement->getId() )
              ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
              ->enduse()
              ->count();
            $aantal_beschikbaar = $evenement->getMaxDeelnemers() - $sum;
        }

        $evt_lijst = array();
        $evt_lijst["id"] = $evenement->getId();
        $evt_lijst["naam"] = $evenement->getNaam();
        $evt_lijst["categorie"] = $evenement->getCategorie();
        $evt_lijst["korteOmschrijving"] = $evenement->getKorteOmschrijving();
        $evt_lijst["langeOmschrijving"] = $evenement->getLangeOmschrijving();
        $evt_lijst["datumBegin"] = $evenement->getDatumBegin()->format( 'd-m-Y' );
        $evt_lijst["datumEind"] = $evenement->getDatumEind()->format( 'd-m-Y' );
        $evt_lijst["prijs"] = $evenement->getPrijs();
        $evt_lijst["maxDeelnemers"] = $evenement->getMaxDeelnemers();
        $evt_lijst["status"] = $evenement->getStatus();
        $evt_lijst["beschikbaar"] = $aantal_beschikbaar;

        setlocale(LC_ALL, 'nl_NL');

        $nu = new DateTime();
        $totInschrijfOpen = ( $evenement->getInschrijvingBegin()->getTimestamp() - $nu->getTimestamp() ) / 60;
        $totInschrijfSluit = ( $evenement->getInschrijvingEind()->getTimestamp() - $nu->getTimestamp() ) / 60;
        if ( $totInschrijfOpen > 0 )
        {
            $statusTekst = "De inschrijving is gesloten en opent op " . strftime( '%A %e %B %Y om %H:%M:%S', $evenement->getInschrijvingBegin()->getTimestamp() );
            $isEvenementOpen = false;
        }
        else
        {
            $statusTekst = "De inschrijving is geopend en sluit op " . strftime( '%A %e %B %Y om %H:%M:%S', $evenement->getInschrijvingEind()->getTimestamp() );
            $isEvenementOpen = true;
        }

        if ( $totInschrijfSluit < 0 )
        {
            $statusTekst = "De inschrijving is gesloten op " . strftime( '%A %e %B %Y om %H:%M:%S', $evenement->getInschrijvingEind()->getTimestamp() );
            $isEvenementOpen = false;
        }

        if ( $evenement->getStatus() != EVENEMENT_STATUS_OPEN )
        {
            $isEvenementOpen = false;
            $statusTekst = "Dit evenement is gesloten voor inschrijving, de status is: " . evenementStatusNaam( $evenement->getStatus() );
        }
        $logger->debug( $statusTekst );

        $evt_lijst["statusTekst"] = $statusTekst;
        array_push( $evenementen_lijst, $evt_lijst );
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $opslaan )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    //header( "Location:registreer.php?evt=".$opslaan );
    header( "Location:evenement_inschrijving.php?evt=" . $opslaan );
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'statusGeannuleerd', EVENEMENT_STATUS_GEANNULEERD );
$smarty->assign( 'Evenementen', $evenementen_lijst );

$smarty->display( 'evenementen_lijst.tpl' );
