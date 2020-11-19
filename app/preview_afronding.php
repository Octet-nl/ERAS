<?php
/**
 * System      ERAS
 * Module      Inschrijving testen
 * Doel        Toon layout afrondingsdeel
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       03-11-2020
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

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\OptieQuery;

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty(); 
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL_NONE );

$doctitle = "Inschrijving";

$statusRegel = "";
$signalError = false;

// define screen variables and set to empty values
require_once 'persoon_define_variables.inc';

$persoon = null;
$sessieVariabelen = null;
$aantal_deelnemers = 1;
$aantal_deelnemersErr = "";
$max_deelnemers = 0;
$status = 0;
$evt = 0;
$inschrijvingnummer = 0;
$prijspp = 0;
$prijsppt = 0;
$validatiemelding = "";
$optieArray = array();
$dynamicHtml = "";
$avHtml = "";
$betaalwijzeHtml = "";
$voucherHtml = "";
$statusErr = "";
$betaalwijze = 0;
$annuleringsverzekering = ANNULERINGSVERZEKERING_GEEN;
$heeft_annuleringsverzekering = 0;
$evenement_annuleringsverzekering = 0;
$reedsBetaald = "0.00";

$validateOk = 0;

if ( isset( $_SESSION['inschrijving'] ) )
{
    $sessieVariabelen = $_SESSION['inschrijving'];
}

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "inschrijving_overzicht.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// De GET method heeft de sessiestatus nodig om huidige waarden te kunnen invullen

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];

    $logger->debug( "GET controle ok" );

    if ( is_numeric( $evt ) )
    {
        $logger->debug( "Evenement " . $evt );
        $evenement = EvenementQuery::create()->findPK( $evt );
        if ( $evenement != null )
        {
            $betaalwijze = $evenement->getBetaalwijze();
            $evenement_annuleringsverzekering = $evenement->getAnnuleringsverzekering();
        }
        else
        {
            $logger->warning( "Evenement " . $evt . " is niet gevonden." );
            echo "Evenement " . $evt . " is niet gevonden.";
            return;
        }

        $items = array( 13, 3, 4, 52, 8, 11, 25 );
        $aantal_deelnemers = $items[array_rand($items)];
        $max_deelnemers = 5;

        $items = array( "23.45", "175.20", "9.50", "17.75", "48", "75.80" );
        $prijspp = $items[array_rand($items)];
        $prijsppt = $prijspp;

        $totaalPrijsOpties = number_format( "23.45", 2 );
        $logger->debug( $totaalPrijsOpties );

        $opties = OptieQuery::create()
            ->filterByPerDeelnemer( '0' )
            ->useEvenementHeeftOptieQuery()
            ->filterByEvenementId( $evt )
            ->orderByVolgorde()
            ->endUse()
            ->orderByGroep()
            ->find();

        $aantalOpties = sizeof( $opties );
        $logger->debug( "Vullen optie array, er zijn " . $aantalOpties . " opties op inschrijvingniveau" );

        $annuleringsverzekering = 2;

        $inschrijvingnummer = 2345;

        $betaaldPer = 2;

        $reedsBetaald = "12.50";

        $logger->debug( "Er zijn geen inschrijvingsopties." );
        $currentOpties = array();

        $logger->dump( $currentOpties );

        require "opties_naar_html_class.php";
        $optiesNaarHtml = new optiesNaarHtml();
        $optiesNaarHtml->setEvenementId( $evt );
        $optiesNaarHtml->setAutorisatieRol( $autorisatie->getRol() );
        $optiesNaarHtml->setKopregel( "" ); //"Opties voor deze inschrijving");
        $optiesNaarHtml->setCurrent( $currentOpties );
        $optiesNaarHtml->genereerHtml( $opties );
        $dynamicHtml = $optiesNaarHtml->getHtml();
        // optieArray bevat alle inschrijvingsopties behalve de annuleringsverzekering
        $optieArray = $optiesNaarHtml->getOptieArray();

        require_once "annuleringsverzekering.php";
        $annuleringsVerzekeringObj = new AnnuleringsVerzekering();

        // Door optieArray door te geven aan avNaarHTML wordt een eventuele
        // annuleringsverzekering ge-append aan optieArray
        require "annuleringsverzekering_naar_html_class.php";
        $avNaarHTML = new avNaarHTML( $optieArray );
        //$avNaarHTML->setCurrent( $currentOpties );
        $avNaarHTML->heeftAv( $evenement_annuleringsverzekering );
        $avNaarHTML->setAv( $annuleringsverzekering );
        if ( $annuleringsVerzekeringObj != null )
        {
            $alleNamen = array();
            $alleNamen = $annuleringsVerzekeringObj->getAlleNamen();
            $logger->dump( $alleNamen );
            // $logger->dump( $opties );
            //$avNaarHTML->genereerHtml( $opties, $alleNamen );
            $avNaarHTML->genereerHtml( $alleNamen );
        }
        else
        {
            $logger->debug( "$annuleringsVerzekeringObj is null" );
            $avNaarHTML->genereerHtml( "" );
        }
        $avHtml = $avNaarHTML->getHtml();
        // Nu is de eventuele annuleringsverzekering toegevoegd aan optieArray
        $optieArray = $avNaarHTML->getOptieArray();

        if ( $betaalwijze > 0 )
        {
            require "betaalwijze_naar_html_class.php";
            $betalingNaarHTML = new betalingNaarHTML( $betaalwijze );
            $betalingNaarHTML->setBetaalwijze( $betaalwijze );
            $betalingNaarHTML->setBetaaldPer( $betaaldPer );
            $betalingNaarHTML->genereerHtml();
            $betaalwijzeHtml = $betalingNaarHTML->getHtml();
            $voucherHtml = $betalingNaarHTML->getVoucherHtml();
        }
        else
        {
            $logger->warning( "Geen betaalwijze opgegeven" );
        }

        $logger->dump( $optieArray );
    }
    else
    {
        $logger->warning( "Geen evenement opgegeven" );
        alert( "Geen evenement opgegeven" );
        return;
    }
    //$logger->dump( $dynamicHtml );
    //$logger->dump( $avHtml );

    $_SESSION['chkv'] = "ChEcKvOuChEr";
    }

    $logger->dump( $_SESSION );

}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert niets, de invoer is gevuld met zinvolle default waarden.
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{

    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    $validateOk = 0;

    $setVar = new SetVariable();
    $validateOk += $setVar->name( $evt )
    ->onerror( $statusRegel )
    ->required( true )
    ->go();


    if ( $validateOk == 0 && isset( $_POST['opslaan'] ) )
    {
        header( "Location:preview_deelnemer.php?evt=" . $evt );
        exit;
    }


}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

//$validatiemelding = $htmlTotal . dynamic_radio_group('terugreis', $values, $html_elements, 'advert');

$_SESSION['opties'] = $optieArray;
if ( $annuleringsVerzekeringObj == null )
{
    $signalError = true;
    $statusRegel = "Geen annuleringsverzekering gevonden";
}
else
{
    $formuleAR     = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_ALLRISK );
    $formuleGewoon = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_GEWOON );
    $formuleGeen   = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_GEEN );

    $logger->debug( $formuleAR );
    $logger->debug( $formuleGewoon );
}

$ini= parse_ini_file( CONFIG_FILENAME, true );
$voorwaarden = $ini['organisatie']['voorwaarden'];

$namen = array("Jan Modaal", "Otto Normalverbraucher", "Joe Average", "Matti Meikäläinen", "M. Moyen");
$contactnaam = $namen[array_rand($namen, 1)];
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'contactpersoon_naam', $contactnaam );
$smarty->assign( 'aantal_beschikbaar', 78 );
$smarty->assign( 'contactpersoon_email', "" );
$smarty->assign( 'aantal_deelnemers', $aantal_deelnemers );
$smarty->assign( 'aantal_deelnemersErr', $aantal_deelnemersErr );
$smarty->assign( 'max_deelnemers', $max_deelnemers );
$smarty->assign( 'prijs_per_persoon', $prijsppt );
$totaalPrijs = ( $aantal_deelnemers * $prijspp ) * 1.00;
$bedrag = number_format( $totaalPrijs, 2 );
$smarty->assign( 'totaalprijs', str_replace( ',', '', $bedrag ) );
$smarty->assign( 'totaalprijs_opties', $totaalPrijsOpties );
$smarty->assign( 'dynamichtml', $dynamicHtml );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'inschrijvingnummer', $inschrijvingnummer );
$smarty->assign( 'validatiemelding', $validatiemelding );
$smarty->assign( 'heeft_annuleringsverzekering', $heeft_annuleringsverzekering );
$smarty->assign( 'annulering_allrisk_formule', $formuleAR );
$smarty->assign( 'annulering_gewoon_formule', $formuleGewoon );
$smarty->assign( 'annulering_geen_formule', $formuleGeen );
$smarty->assign( 'avhtml', $avHtml );
$smarty->assign( 'reedsbetaald', $reedsBetaald );
$smarty->assign( 'betaalwijze', $betaalwijze );
$smarty->assign( 'betaalwijzeHtml', $betaalwijzeHtml );
$smarty->assign( 'voucherHtml', $voucherHtml );
$smarty->assign( 'voorwaarden', $voorwaarden );
$smarty->assign( 'statusErr', $statusErr );
$smarty->assign( 'email', $email );
$smarty->assign( 'typeVoucher', VOUCHERTYPE_VOUCHER );
$smarty->assign( 'typeKorting', VOUCHERTYPE_KORTING );

$smarty->assign( 'isPersoneel', $autorisatie->getRol() >= AUTORISATIE_STATUS_MEDEWERKER );
// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );
$smarty->assign( 'noLogout', 'true' );

$smarty->display( 'preview_afronding.tpl' );
