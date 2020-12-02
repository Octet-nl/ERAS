<?php
/**
 * System      ERAS
 * Module      Inschrijving opvoeren
 * Doel        Startscherm opvoeren nieuwe inschrijving
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

$doctitle = "Inschrijving";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\EvenementQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

require_once 'evenement_define_variables.inc';

$isInschrijvingOpen = false;
$isEvenementOpen = false;
$statusTekst = "";
$accountNodig = false;

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?evt= parameter,
// Voorbeeld: http://www.mijnsite.com/evenement?evt=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van evenement 234.
// Wordt de ?id= parameter niet opgegeven dan gaat het om een nieuw evenement en wordt
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    unset( $_SESSION['inschrijving'] );

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];

        $evenement = EvenementQuery::create()->findPK( $evt );
        if ( $evenement != null )
        {
            $evenement_naam = $evenement->getNaam();
            $korteOmschrijving = $evenement->getKorteOmschrijving();
            $langeOmschrijving = $evenement->getLangeOmschrijving();
            $datumBegin = $evenement->getDatumBegin()->format( 'd-m-Y' );
            $datumEind = $evenement->getDatumEind()->format( 'd-m-Y' );
            $inschrijvingBegin = $evenement->getInschrijvingBegin();
            $inschrijvingEind = $evenement->getInschrijvingEind();
            $extra_contact = $evenement->getExtraContactGegevens();
            $extra_deelnemer = $evenement->getExtraDeelnemerGegevens();
            $prijs = $evenement->getPrijs();
            $max_deelnemers = $evenement->getMaxDeelnemers();
            $accountNodig = $evenement->getAccountNodig();
            $status = $evenement->getStatus();

            $isEvenementOpen = true;

            setlocale(LC_ALL, 'nl_NL');

            $nu = new DateTime();
            $totInschrijfOpen = ( $inschrijvingBegin->getTimestamp() - $nu->getTimestamp() ) / 60;
            $totInschrijfSluit = ( $inschrijvingEind->getTimestamp() - $nu->getTimestamp() ) / 60;
            if ( $totInschrijfOpen > 0 )
            {
                $statusTekst = "De inschrijving is gesloten en opent op " . strftime( '%A %e %B %Y om %H:%M:%S', $inschrijvingBegin->getTimestamp() );
                $isEvenementOpen = false;
                $logger->debug( $statusTekst );
            }
            else
            {
                $statusTekst = "De inschrijving is geopend en sluit op " . strftime( '%A %e %B %Y om %H:%M:%S', $inschrijvingEind->getTimestamp() );
                $isEvenementOpen = true;
                $logger->debug( $statusTekst );
            }

            if ( $totInschrijfSluit < 0 )
            {
                $statusTekst = "De inschrijving is gesloten op " . strftime( '%A %e %B %Y om %H:%M:%S', $inschrijvingEind->getTimestamp() );
                $isEvenementOpen = false;
                $logger->debug( $statusTekst );
            }

            if ( $status != EVENEMENT_STATUS_OPEN )
            {
                $isEvenementOpen = false;
                $statusTekst = "Dit evenement is gesloten voor inschrijving, de status is: " . evenementStatusNaam( $status );
                $logger->debug( $statusTekst );
            }

            if ( $isEvenementOpen )
            {
                $sum = DeelnemerQuery::create()
                    ->useInschrijvingQuery( 'a', 'left join' )
                    ->filterByEvenementId( $evenement->getId() )
                    ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
                    ->enduse()
                    ->count();
                $aantal_beschikbaar = $evenement->getMaxDeelnemers() - $sum;

                if ( $aantal_beschikbaar <= 0 )
                {
                    $isEvenementOpen = false;
                    $statusTekst = "Er zijn geen plaatsen meer beschikbaar voor dit evenement.";
                }
                else
                {
                    if ( $aantal_beschikbaar == 1 )
                    {
                        $statusTekst = "Er is nog één plaats beschikbaar.";
                    }
                    else
                    {
                        $statusTekst = "Er zijn nog " . $aantal_beschikbaar . " plaatsen beschikbaar.";
                    }
                }
            }
        }
        else
        {
            $logger->info( "evenement " . $evt . " is niet gevonden." );
            alertAndGo( "evenement " . $evt . " is niet gevonden.", "evenement_kiezen.php" );
            $id = null;
        }
    }
    else
    {
        $logger->info( "Geen evenement opgegeven." );
        alertAndGo( "Geen evenement opgegeven.", "evenement_kiezen.php" );
        return;
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    try
    {
        $setVar = new SetVariable();
        $setVar->name( $evt )
            ->go();
        $setVar->name( $evenement_naam )
            ->go();
        $setVar->name( $aantal_beschikbaar )
            ->go();
        $setVar->name( $max_deelnemers )
            ->go();
        $setVar->name( $extra_contact )
            ->go();
        $setVar->name( $extra_deelnemer )
            ->go();
        $setVar->name( $accountNodig )
            ->go();
        $setVar->name( $prijs )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    $logger->debug( "Instellen sessievariabelen" );

    $sessieVariabelen = array();
    $sessieVariabelen["evenement_id"] = $evt;
    $sessieVariabelen["evenement_naam"] = $evenement_naam;
    $sessieVariabelen["aantal_beschikbaar"] = $aantal_beschikbaar;
    $sessieVariabelen["max_deelnemers"] = $max_deelnemers;
    $sessieVariabelen["extra_contact"] = $extra_contact;
    $sessieVariabelen["extra_deelnemer"] = $extra_deelnemer;
    $sessieVariabelen["account_nodig"] = $accountNodig;
    $sessieVariabelen['inschrijving_status'] = INSCHRIJVING_STATUS_OPEN;
    $sessieVariabelen["prijs"] = $prijs;

    $_SESSION['inschrijving'] = $sessieVariabelen;

    $logger->dump( $sessieVariabelen );

    // Inschrijving staat nog open
    if ( isset( $_POST["inschrijven"] ) )
    {
        $logger->debug( "Naar registratie/inloggen met event " . $evt );
        //header( "Location:inschrijving_contactpersoon.php?evt=" . $evt );
        //header( "Location:inschrijving_contactpersoon.php" );
        header( "Location:registreer.php?evt=" . $evt );

        exit;
    }
    else
    // Inschrijving staat niet meer open, klant vraagt informatie
    {
        $logger->debug( "Naar informatie met event " . $evt );
        //header( "Location:inschrijving_contactpersoon.php?evt=" . $evt );
        //ToDo: Deze pagina moet nog gemaakt worden
        header( "Location:mailing_aanmelden.php?evtn=" . $evenement_naam . "&evti=" . $evt );
        exit;
    }

//    $routing = new Routing();
    //    $routing->setNext( 'contactpersoon' );
    //    $routing->setParameter( 'evt', $evt );
    //    $routing->setParameter( 'prs', 3 );
    //    $routing->go();

    exit();
}

// Dit deel wordt altijd uitgevoerd
// Hidden variabelen (voor doorgeven waarden na de POST)

$smarty->assign( 'evt', $evt );
$smarty->assign( 'evenement_naam', $evenement_naam );
$smarty->assign( 'aantal_beschikbaar', $aantal_beschikbaar );
$smarty->assign( 'extra_contact', $extra_contact );
$smarty->assign( 'extra_deelnemer', $extra_deelnemer );
$smarty->assign( 'prijs', $prijs );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenementNummer', $evt );
$smarty->assign( 'evenementNaam', $evenement_naam );
$smarty->assign( 'langeOmschrijving', $langeOmschrijving );
$smarty->assign( 'datumBegin', $datumBegin );
$smarty->assign( 'datumEind', $datumEind );
$smarty->assign( 'statusTekst', $statusTekst );
$smarty->assign( 'status', $statusTekst );
if ( $isEvenementOpen )
{
    $button = '<button name="inschrijven">Inschrijven</button>' . '<button name="info">Belangstelling</button>';
}
else
{
    $button = '<button name="info">Belangstelling</button>';
}
$smarty->assign( 'button', $button );
$smarty->assign( 'max_deelnemers', $max_deelnemers );
$smarty->assign( 'accountNodig', $accountNodig );

$smarty->display( 'evenement_inschrijving.tpl' );
