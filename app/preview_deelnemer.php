<?php
/**
 * System      ERAS
 * Module      Inschrijving testen
 * Doel        Testen inschrijving van evenement in wachtstatus.
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       16-09-2020
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
require_once 'persoonsgegevens_class.php';

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\OptieQuery;

$sessie = new Sessie();

$doctitle = "Testen evenement: ";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/


$logger = new Logger();
$logger->level( LOGLEVEL );

require_once 'evenement_define_variables.inc';

$accountNodig = false;

$validatiemelding = "";

$evenement_naam = "";

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $persoonsGegevens = new Persoonsgegevens( $autorisatie->getUserId() );

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];

        $evenement = EvenementQuery::create()->findPK( $evt );
        if ( $evenement != null )
        {
            $evenement_naam = $evenement->getNaam();
            $extra_contact = $evenement->getExtraContactGegevens();
            $extra_deelnemer = $evenement->getExtraDeelnemerGegevens();
            $prijs = $evenement->getPrijs();
            $max_deelnemers = $evenement->getMaxDeelnemers();
            $accountNodig = $evenement->getAccountNodig();

            $extraContact = $extra_deelnemer;

            // Haal alle deelnemeropties voor dit evenement.
            $opties = OptieQuery::create()
                ->filterByPerDeelnemer( '1' )
                ->useEvenementHeeftOptieQuery()
                ->filterByEvenementId( $evt )
                ->orderByVolgorde()
                ->endUse()
                ->orderByGroep()
                ->find();

            $logger->debug( "Genereer dynamisch HTML" );
            require_once "opties_naar_html_class.php";
            $optiesNaarHtml = new optiesNaarHtml();
            $optiesNaarHtml->setIsPreview( true );
            $optiesNaarHtml->setEvenementId( $evt );
            $optiesNaarHtml->setAutorisatieRol( $autorisatie->getRol() );
            $optiesNaarHtml->setKopregel( "Opties voor deze deelnemer" );

            //$optiesNaarHtml->enableInternGebruik( true );
            $optiesNaarHtml->genereerHtml( $opties );
            $dynamicHtml = $optiesNaarHtml->getHtml();
            $optieArray = $optiesNaarHtml->getOptieArray();
            $logger->dump( $optieArray );

        }
        else
        {
            $logger->info( "evenement " . $evt . " is niet gevonden." );
            alertAndGo( "evenement " . $evt . " is niet gevonden.", "preview_evenement.php" );
            $id = null;
        }
    }
    else
    {
        $logger->info( "Geen evenement opgegeven." );
        alertAndGo( "Geen evenement opgegeven.", "preview_evenement.php" );
        return;
    }
}

// Na drukken op de "afronden" knop
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

    header( "Location:preview_afronding.php?evt=" . $evt );
    exit();
}

// Dit deel wordt altijd uitgevoerd

// Variabelen zijn nodig voor persoon_template
$readonly = true;
$id = 0;
$id_visibility = "hide";
require_once
 'persoon_template.php';

$namen = array("Jan Modaal", "Otto Normalverbraucher", "Joe Average", "Matti Meikäläinen", "M. Moyen");
$contactnaam = $namen[array_rand($namen, 1)];
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenement_naam', $evenement_naam );
$smarty->assign( 'contactpersoon_naam', $contactnaam );
$smarty->assign( 'extra_tekst', $extraTekst );
$smarty->assign( 'aantal_beschikbaar', 1 );
$smarty->assign( 'aantal_deelnemers', 1);
$smarty->assign( 'aantal_deelnemersErr', "" );
$smarty->assign( 'prijs_per_persoon', "123,45" );
$smarty->assign( 'wijzigingDefinitieveInschrijving', 0 );

$smarty->assign( 'dynamichtml', $dynamicHtml );
$smarty->assign( 'readonly_email', 0 );

$smarty->assign( 'deelnemerId', 59 );
$smarty->assign( 'persoonId', 95 );
$smarty->assign( 'inschrijvingnummer', 123455 );
$smarty->assign( 'all', '0' );
$smarty->assign( 'validatiemelding', $validatiemelding );

// Voor statusregel
$smarty->assign( 'isError', "");
$smarty->assign( 'statusRegel', "" );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'preview_deelnemer.tpl' );
