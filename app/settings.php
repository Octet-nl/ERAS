<?php
/**
 * System      ERAS
 * Module      setup
 * Doel        Instellingen en configuratie
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-07-2020
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

require_once 'constanten.php';
require_once 'utilities.php';

use Respect\Validation\Validator as v;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Instellingen";

$sessie = new Sessie();

$organisatieNaam = "";
$organisatieEmail = "";
$organisatieWebsite = "";
$organisatieVoorwaarden = "";
$bankIbanNummer = "";
$bankBicNummer = "";
$bankTenNameVan = "";
$factuurAanmaken = "";
$factuurVerzenden = "";
$factuurTitel = "";
$factuurNotatype = "";
$organisatieLogo = "";
$organisatieFooter = "";
$organisatieAdresregel = "";
$factuurBtwPercentage = "";
$factuurBtwRegel1 = "";
$factuurBtwRegel2 = "";
$factuurBtwRegel3 = "";
$tabelEvenementKolom1 = "";
$tabelEvenementKolom2 = "";
$tabelEvenementKolom3 = "";
$tabelEvenementKolom4 = "";
$tabelEvenementKolom5 = "";
$tabelDeelnemerKolom1 = "";
$tabelDeelnemerKolom2 = "";
$tabelDeelnemerKolom3 = "";
$tabelDeelnemerKolom4 = "";
$tabelDeelnemerKolom5 = "";
$enableIDeal = "";
$idealCheckout = "";
$idealStatusStopped = "";
$idealStatusSuccess = "";
$idealStatusFailure = "";
$idealStatusPending = "";
$betalingVoorwaarden = "";
$betalingIncassoTekst = "";
$betalingContantTekst = "";
$settingLogDirectory = "";
$settingTempDirectory = "";
$settingFacturenDirectory = "";
$settingImageDirectory = "";
$settingBatchSize = "";
$settingRefresh = "";
$settingPasswordKlant = "";
$settingPasswordMedewerker = "";
$enableVerzekering = "";
$settingVerzekeringVoorwaarden = "";

$organisatieNaamErr = "";
$organisatieEmailErr = "";
$organisatieWebsiteErr = "";
$organisatieVoorwaardenErr = "";
$bankIbanNummerErr = "";
$bankBicNummerErr = "";
$bankTenNameVanErr = "";
$factuurAanmakenErr = "";
$factuurVerzendenErr = "";
$factuurTitelErr = "";
$factuurNotatypeErr = "";
$organisatieLogoErr = "";
$organisatieFooterErr = "";
$organisatieAdresregelErr = "";
$tabelEvenementKolom1Err = "";
$tabelEvenementKolom2Err = "";
$tabelEvenementKolom3Err = "";
$tabelEvenementKolom4Err = "";
$tabelEvenementKolom5Err = "";
$tabelDeelnemerKolom1Err = "";
$tabelDeelnemerKolom2Err = "";
$tabelDeelnemerKolom3Err = "";
$tabelDeelnemerKolom4Err = "";
$tabelDeelnemerKolom5Err = "";
$factuurBtwPercentageErr = "";
$factuurBtwRegel1Err = "";
$factuurBtwRegel2Err = "";
$factuurBtwRegel3Err = "";
$enableIDealErr = "";
$idealCheckoutErr = "";
$idealStatusStoppedErr = "";
$idealStatusSuccessErr = "";
$idealStatusFailureErr = "";
$idealStatusPendingErr = "";
$betalingVoorwaardenErr = "";
$betalingIncassoTekstErr = "";
$betalingContantTekstErr = "";
$settingLogDirectoryErr = "";
$settingTempDirectoryErr = "";
$settingFacturenDirectoryErr = "";
$settingImageDirectoryErr = "";
$settingBatchSizeErr = "";
$settingRefreshErr = "";
$settingPasswordKlantErr = "";
$settingPasswordMedewerkerErr = "";
$enableVerzekeringErr = "";
$settingVerzekeringVoorwaardenErr = "";

$statusRegel = "";
$signalError = false;

$history = new History();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ADMINISTRATOR );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    $history->set( );

    if ( getGetVar( $whatever ) == null )
    {
    }

    $ini = parse_ini_file( CONFIG_FILENAME, true );

    $logger->dump( $ini );

    $organisatieNaam = $ini['organisatie']['organisatienaam'];
    $organisatieEmail = $ini['organisatie']['email'];
    $organisatieWebsite = $ini['organisatie']['website'];
    $organisatieVoorwaarden = $ini['organisatie']['voorwaarden'];
    $organisatieLogo = $ini['organisatie']['logo'];
    $organisatieFooter = $ini['organisatie']['footer'];
    $organisatieAdresregel = $ini['organisatie']['adresregel'];

    $bankIbanNummer = $ini['bank']['IBAN'];
    $bankBicNummer = $ini['bank']['BIC'];
    $bankTenNameVan = $ini['bank']['ten_name_van'];

    $factuurAanmaken = $ini['pdf_factuur']['aanmaken'];
    $factuurVerzenden = $ini['pdf_factuur']['verzenden'];
    $factuurTitel = $ini['pdf_factuur']['titel'];
    $factuurNotatype = $ini['pdf_factuur']['notatype'];
    $factuurBtwPercentage = $ini['pdf_factuur']['BTW-percentage'];
    $factuurBtwRegel1 = $ini['pdf_factuur']['BTW-regel1'];
    $factuurBtwRegel2 = $ini['pdf_factuur']['BTW-regel2'];
    $factuurBtwRegel3 = $ini['pdf_factuur']['BTW-regel3'];

    $tabelEvenementKolom1 = $ini['tabelkop']['evenement-kolom1'];
    $tabelEvenementKolom2 = $ini['tabelkop']['evenement-kolom2'];
    $tabelEvenementKolom3 = $ini['tabelkop']['evenement-kolom3'];
    $tabelEvenementKolom4 = $ini['tabelkop']['evenement-kolom4'];
    $tabelEvenementKolom5 = $ini['tabelkop']['evenement-kolom5'];
    $tabelDeelnemerKolom1 = $ini['tabelkop']['deelnemer-kolom1'];
    $tabelDeelnemerKolom2 = $ini['tabelkop']['deelnemer-kolom2'];
    $tabelDeelnemerKolom3 = $ini['tabelkop']['deelnemer-kolom3'];
    $tabelDeelnemerKolom4 = $ini['tabelkop']['deelnemer-kolom4'];
    $tabelDeelnemerKolom5 = $ini['tabelkop']['deelnemer-kolom5'];

    $enableIDeal = $ini['ideal_payment']['toestaan'];
    $idealCheckout = $ini['ideal_payment']['checkout_script'];
    $idealStatusStopped = $ini['ideal_payment']['status_stopped'];
    $idealStatusSuccess = $ini['ideal_payment']['status_success'];
    $idealStatusFailure = $ini['ideal_payment']['status_failure'];
    $idealStatusPending = $ini['ideal_payment']['status_pending'];

    $betalingVoorwaarden = $ini['betaling']['voorwaarden'];
    $betalingIncassoTekst = $ini['betaling']['incasso_tekst'];
    $betalingContantTekst = $ini['betaling']['contant_tekst'];
    
    $enableVerzekering = $ini['verzekering']['toestaan'];
    $settingVerzekeringVoorwaarden = $ini['verzekering']['voorwaarden'];

    $settingBatchSize = $ini['settings']['batch_size'];
    $settingRefresh = $ini['settings']['refresh'];
    $settingPasswordKlant = $ini['settings']['password_klant'];
    $settingPasswordMedewerker = $ini['settings']['password_medewerker'];
    $settingLogDirectory = $ini['settings']['log_directory'];
    $settingTempDirectory = $ini['settings']['temp_directory'];
    $settingFacturenDirectory = $ini['settings']['facturen_directory'];
    $settingImageDirectory = $ini['settings']['image_directory'];


}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
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

    $validateOk = 0;

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $organisatieNaam )
            ->onerror( $organisatieNaamErr )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $organisatieEmail )
            ->onerror( $organisatieEmailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            ->required( true )->go();
        $validateOk += $setVar->name( $organisatieWebsite )
            ->validator( v::callback( 'urlExists' ) )
            ->errormessage( "Site niet gevonden" )
            ->onerror( $organisatieWebsiteErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $organisatieVoorwaarden )
            ->onerror( $organisatieVoorwaardenErr )
            ->validator( v::callback( 'urlExists' ) )
            ->errormessage( "Link niet gevonden" )
            ->required( false )->go();

        $validateOk += $setVar->name( $factuurAanmaken )
            ->onerror( $factuurAanmakenErr )
            ->validator( v::oneOf( v::equals( OPTIE_KEUZE_JA ), v::equals( OPTIE_KEUZE_NEE ) ) )
            ->required( true )->go();
        if ( $factuurAanmaken == OPTIE_KEUZE_JA )
        {
            $validateOk += $setVar->name( $bankIbanNummer )
                ->onerror( $bankIbanNummerErr )
                ->validator( v::iban() )
                ->required( true )->go();
            $validateOk += $setVar->name( $bankBicNummer )
                ->onerror( $bankBicNummerErr )
                ->required( false )->go();
            $validateOk += $setVar->name( $bankTenNameVan )
                ->onerror( $bankTenNameVanErr )
                ->required( true )->go();

            $validateOk += $setVar->name( $factuurVerzenden )
                ->onerror( $factuurVerzendenErr )
                ->validator( v::oneOf( v::equals( OPTIE_KEUZE_JA ), v::equals( OPTIE_KEUZE_NEE ) ) )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurTitel )
                ->onerror( $factuurTitelErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurNotatype )
                ->onerror( $factuurNotatypeErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $organisatieLogo )
                ->validator( v::callback( 'file_exists' ) )
                ->onerror( $organisatieLogoErr )
                ->errormessage( "Bestand niet gevonden" )
                ->required( true )->go();
            $validateOk += $setVar->name( $organisatieFooter )
                ->onerror( $organisatieFooterErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $organisatieAdresregel )
                ->onerror( $organisatieAdresregelErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelEvenementKolom1 )
                ->onerror( $tabelEvenementKolom1Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelEvenementKolom2 )
                ->onerror( $tabelEvenementKolom2Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelEvenementKolom3 )
                ->onerror( $tabelEvenementKolom3Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelEvenementKolom4 )
                ->onerror( $tabelEvenementKolom4Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelEvenementKolom5 )
                ->onerror( $tabelEvenementKolom5Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelDeelnemerKolom1 )
                ->onerror( $tabelDeelnemerKolom1Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelDeelnemerKolom2 )
                ->onerror( $tabelDeelnemerKolom2Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelDeelnemerKolom3 )
                ->onerror( $tabelDeelnemerKolom3Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelDeelnemerKolom4 )
                ->onerror( $tabelDeelnemerKolom4Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $tabelDeelnemerKolom5 )
                ->onerror( $tabelDeelnemerKolom5Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurBtwPercentage )
                ->formatter( 'prijs' )
                ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" )->lessThan( 100 ) )
                ->errormessage( "percentage in decimalen (99.99) en minder dan 100" )
                ->onerror( $factuurBtwPercentageErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurBtwRegel1 )
                ->onerror( $factuurBtwRegel1Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurBtwRegel2 )
                ->onerror( $factuurBtwRegel2Err )
                ->required( true )->go();
            $validateOk += $setVar->name( $factuurBtwRegel3 )
                ->onerror( $factuurBtwRegel3Err )
                ->required( true )->go();
        }     
        else
        {
            $setVar->name( $bankIbanNummer )->go();
            $setVar->name( $bankBicNummer )->go();
            $setVar->name( $bankTenNameVan )->go();
            $setVar->name( $factuurVerzenden )->go();
            $setVar->name( $factuurTitel )->go();
            $setVar->name( $factuurNotatype )->go();
            $setVar->name( $organisatieLogo )->go();
            $setVar->name( $organisatieFooter )->go();
            $setVar->name( $organisatieAdresregel )->go();
            $setVar->name( $factuurBtwPercentage )->go();
            $setVar->name( $factuurBtwRegel1 )->go();
            $setVar->name( $factuurBtwRegel2 )->go();
            $setVar->name( $factuurBtwRegel3 )->go();
            $setVar->name( $tabelEvenementKolom1 )->go();
            $setVar->name( $tabelEvenementKolom2 )->go();
            $setVar->name( $tabelEvenementKolom3 )->go();
            $setVar->name( $tabelEvenementKolom4 )->go();
            $setVar->name( $tabelEvenementKolom5 )->go();
            $setVar->name( $tabelDeelnemerKolom1 )->go();
            $setVar->name( $tabelDeelnemerKolom2 )->go();
            $setVar->name( $tabelDeelnemerKolom3 )->go();
            $setVar->name( $tabelDeelnemerKolom4 )->go();
            $setVar->name( $tabelDeelnemerKolom5 )->go();
        }
       

        $validateOk += $setVar->name( $enableIDeal )
            ->onerror( $enableIDealErr )
            ->validator( v::oneOf( v::equals( OPTIE_KEUZE_JA ), v::equals( OPTIE_KEUZE_NEE ) ) )
            ->required( true )->go();

        if ( $enableIDeal == OPTIE_KEUZE_JA )
        {
            $validateOk += $setVar->name( $idealCheckout )
                ->validator( v::callback( 'urlExists' ) )
                ->errormessage( "Link niet gevonden" )
                ->onerror( $idealCheckoutErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $idealStatusStopped )
                ->validator( v::callback( 'urlExists' ) )
                ->errormessage( "Link niet gevonden" )
                ->onerror( $idealStatusStoppedErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $idealStatusSuccess )
                ->validator( v::callback( 'urlExists' ) )
                ->errormessage( "Link niet gevonden" )
                ->onerror( $idealStatusSuccessErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $idealStatusFailure )
                ->validator( v::callback( 'urlExists' ) )
                ->errormessage( "Link niet gevonden" )
                ->onerror( $idealStatusFailureErr )
                ->required( true )->go();
            $validateOk += $setVar->name( $idealStatusPending )
                ->validator( v::callback( 'urlExists' ) )
                ->errormessage( "Link niet gevonden" )
                ->onerror( $idealStatusPendingErr )
                ->required( true )->go();
        }
        else
        {
            $setVar->name( $idealCheckout )->go();
            $setVar->name( $idealStatusStopped )->go();
            $setVar->name( $idealStatusSuccess )->go();
            $setVar->name( $idealStatusFailure )->go();
            $setVar->name( $idealStatusPending )->go();
        }

        $validateOk += $setVar->name( $betalingVoorwaarden )
            ->onerror( $betalingVoorwaardenErr )
            ->noHtmlCleaning()
            ->formatter( 'stripQuotes' )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $betalingContantTekst )
            ->onerror( $betalingContantTekstErr )
            ->noHtmlCleaning()
            ->formatter( 'stripQuotes' )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $betalingIncassoTekst )
            ->onerror( $betalingIncassoTekstErr )
            ->noHtmlCleaning()
            ->formatter( 'stripQuotes' )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $settingLogDirectory )
            ->validator( v::callback( 'dirIsWritable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingLogDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingTempDirectory )
            ->validator( v::callback( 'dirIsWritable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingTempDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingFacturenDirectory )
            ->validator( v::callback( 'dirIsWritable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingFacturenDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingImageDirectory )
            ->validator( v::callback( 'dirIsWritable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingImageDirectoryErr )
            ->required( true )->go();

        $validateOk += $setVar->name( $settingBatchSize )
            ->onerror( $settingBatchSizeErr )
            ->validator( v::intVal()->between(2, 100) )
            ->errormessage( "Kies een waarde tussen 2 en 100" )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingRefresh )
            ->onerror( $settingRefreshErr )
            ->validator( v::intVal()->between(5, 300) )
            ->errormessage( "Kies een waarde tussen 5 en 300" )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingPasswordKlant )
            ->onerror( $settingPasswordKlantErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingPasswordMedewerker )
            ->onerror( $settingPasswordMedewerkerErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $enableVerzekering )
            ->onerror( $enableVerzekeringErr )
            ->validator( v::oneOf( v::equals( OPTIE_KEUZE_JA ), v::equals( OPTIE_KEUZE_NEE ) ) )
            ->required( true )->go();

        if ( $enableVerzekering == OPTIE_KEUZE_JA )
        {
            $validateOk += $setVar->name( $settingVerzekeringVoorwaarden )
            ->onerror( $settingVerzekeringVoorwaardenErr )
            ->errormessage( "Link niet gevonden" )
            ->validator( v::callback( 'urlExists' ) )
            ->required( true )->go();
        }

        if ( $validateOk == 0 )
        {
            if ( $factuurAanmaken != OPTIE_KEUZE_JA )
            {
                $factuurVerzenden = OPTIE_KEUZE_NEE;
            }

            // Schrijf hele inhoud van het configuratiebestand
            $fp = fopen( CONFIG_FILENAME, 'w' );
            if ( $fp == null )
            {
                throw new Exception( "Kan bestand " . CONFIG_FILENAME . " niet openen." );
            }
            fprintf( $fp, ';<?php' . "\n" );
            fprintf( $fp, ';echo "<center><h1>404 Not Found</h1></center><hr><center>nginz</center>"' . "\n" );
            fprintf( $fp, ';die(""); // Cannot execute this file' . "\n" );
            fprintf( $fp, ';/*' . "\n" );
            fprintf( $fp, ';Dit bestand is niet bedoeld om met de hand gewijzigd te worden' . "\n" );
            fprintf( $fp, ';Het wordt in z\'n geheel overschreven bij update van de settings!' . "\n" );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[organisatie]' . "\n" );
            fprintf( $fp, 'organisatienaam="%s"' . "\n", $organisatieNaam );
            fprintf( $fp, 'email="%s"' . "\n", $organisatieEmail );
            fprintf( $fp, 'website="%s"' . "\n", $organisatieWebsite );
            fprintf( $fp, 'voorwaarden="%s"' . "\n", $organisatieVoorwaarden );
            fprintf( $fp, 'logo="%s"' . "\n", $organisatieLogo );
            fprintf( $fp, 'footer="%s"' . "\n", $organisatieFooter );
            fprintf( $fp, 'adresregel="%s"' . "\n", $organisatieAdresregel );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[bank]' . "\n" );
            fprintf( $fp, 'IBAN="%s"' . "\n", $bankIbanNummer );
            fprintf( $fp, 'BIC="%s"' . "\n", $bankBicNummer );
            fprintf( $fp, 'ten_name_van="%s"' . "\n", $bankTenNameVan );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[pdf_factuur]' . "\n" );
            fprintf( $fp, 'aanmaken="%s"' . "\n", $factuurAanmaken );
            fprintf( $fp, 'verzenden="%s"' . "\n", $factuurVerzenden );
            fprintf( $fp, 'titel="%s"' . "\n", $factuurTitel );
            fprintf( $fp, 'notatype="%s"' . "\n", $factuurNotatype );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'BTW-percentage=%s' . "\n", $factuurBtwPercentage );
            fprintf( $fp, 'BTW-regel1="%s"' . "\n", $factuurBtwRegel1 );
            fprintf( $fp, 'BTW-regel2="%s"' . "\n", $factuurBtwRegel2 );
            fprintf( $fp, 'BTW-regel3="%s"' . "\n", $factuurBtwRegel3 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[tabelkop]' . "\n" );
            fprintf( $fp, 'evenement-kolom1="%s"' . "\n", $tabelEvenementKolom1 );
            fprintf( $fp, 'evenement-kolom2="%s"' . "\n", $tabelEvenementKolom2 );
            fprintf( $fp, 'evenement-kolom3="%s"' . "\n", $tabelEvenementKolom3 );
            fprintf( $fp, 'evenement-kolom4="%s"' . "\n", $tabelEvenementKolom4 );
            fprintf( $fp, 'evenement-kolom5="%s"' . "\n", $tabelEvenementKolom5 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'deelnemer-kolom1="%s"' . "\n", $tabelDeelnemerKolom1 );
            fprintf( $fp, 'deelnemer-kolom2="%s"' . "\n", $tabelDeelnemerKolom2 );
            fprintf( $fp, 'deelnemer-kolom3="%s"' . "\n", $tabelDeelnemerKolom3 );
            fprintf( $fp, 'deelnemer-kolom4="%s"' . "\n", $tabelDeelnemerKolom4 );
            fprintf( $fp, 'deelnemer-kolom5="%s"' . "\n", $tabelDeelnemerKolom5 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[ideal_payment]' . "\n" );
            fprintf( $fp, 'toestaan="%s"' . "\n", $enableIDeal );
            fprintf( $fp, 'checkout_script="%s"' . "\n", $idealCheckout );
            fprintf( $fp, 'status_stopped="%s"' . "\n", $idealStatusStopped );
            fprintf( $fp, 'status_success="%s"' . "\n", $idealStatusSuccess );
            fprintf( $fp, 'status_failure="%s"' . "\n", $idealStatusFailure );
            fprintf( $fp, 'status_pending="%s"' . "\n", $idealStatusPending );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[betaling]' . "\n" );
            fprintf( $fp, 'incasso_tekst="%s"' . "\n", $betalingIncassoTekst );
            fprintf( $fp, 'contant_tekst="%s"' . "\n", $betalingContantTekst );
            fprintf( $fp, 'voorwaarden="%s"' . "\n", $betalingVoorwaarden );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[verzekering]' . "\n" );
            fprintf( $fp, 'toestaan="%s"' . "\n" , $enableVerzekering );
            fprintf( $fp, 'voorwaarden="%s"' . "\n", $settingVerzekeringVoorwaarden );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[settings]' . "\n" );
            fprintf( $fp, 'log_directory="%s"' . "\n", $settingLogDirectory );
            fprintf( $fp, 'temp_directory="%s"' . "\n", $settingTempDirectory );
            fprintf( $fp, 'facturen_directory="%s"' . "\n", $settingFacturenDirectory );
            fprintf( $fp, 'image_directory="%s"' . "\n", $settingImageDirectory );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'batch_size="%s"' . "\n", $settingBatchSize );
            fprintf( $fp, 'refresh="%s"' . "\n", $settingRefresh );
            fprintf( $fp, 'password_klant="%s"' . "\n", $settingPasswordKlant );
            fprintf( $fp, 'password_medewerker="%s"' . "\n", $settingPasswordMedewerker );
            fprintf( $fp, ';' . "\n" );            
            fprintf( $fp, ';*/' . "\n" );
            fprintf( $fp, ';?>' . "\n" );
            fclose( $fp );
            $signalError = false;
            $statusRegel = "Wijzigingen zijn opgeslagen";
        }
        else
        {
            $logger->warning( "Fout bij controle invoer, " . $validateOk );
            $signalError = true;
            $statusRegel = "Los a.u.b. het probleem op en probeer het opnieuw";
        }
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }
}

// Deel 3

$ini = parse_ini_file( CONFIG_FILENAME, true );
$imageDirectory = $ini['settings']['image_directory'] . '/';
$smarty->assign( 'imageDirectory', $imageDirectory );

$toonWysiwig = false;
if ( EVENEMENT_EDIT_WYSIWIG == true && LOGLEVEL > LOGLEVEL_DEBUG )
{
    $toonWysiwig = true;
}
$smarty->assign( 'toonWysiwig', $toonWysiwig );

$smarty->assign( 'ja', OPTIE_KEUZE_JA );
$smarty->assign( 'nee', OPTIE_KEUZE_NEE );

$jaNeeLijst[OPTIE_KEUZE_JA] = OPTIE_KEUZE_JA;
$jaNeeLijst[OPTIE_KEUZE_NEE] = OPTIE_KEUZE_NEE;
$smarty->assign( 'jaNeeLijst', $jaNeeLijst );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'organisatieNaam', $organisatieNaam );
$smarty->assign( 'organisatieNaamErr', $organisatieNaamErr );
$smarty->assign( 'organisatieEmail', $organisatieEmail );
$smarty->assign( 'organisatieEmailErr', $organisatieEmailErr );
$smarty->assign( 'organisatieWebsite', $organisatieWebsite );
$smarty->assign( 'organisatieWebsiteErr', $organisatieWebsiteErr );
$smarty->assign( 'organisatieVoorwaarden', $organisatieVoorwaarden );
$smarty->assign( 'organisatieVoorwaardenErr', $organisatieVoorwaardenErr );

$smarty->assign( 'bankIbanNummer', $bankIbanNummer );
$smarty->assign( 'bankIbanNummerErr', $bankIbanNummerErr );
$smarty->assign( 'bankBicNummer', $bankBicNummer );
$smarty->assign( 'bankBicNummerErr', $bankBicNummerErr );
$smarty->assign( 'bankTenNameVan', $bankTenNameVan );
$smarty->assign( 'bankTenNameVanErr', $bankTenNameVanErr );

$smarty->assign( 'factuurAanmaken', $factuurAanmaken );
$smarty->assign( 'factuurAanmakenErr', $factuurAanmakenErr );
$smarty->assign( 'factuurVerzenden', $factuurVerzenden );
$smarty->assign( 'factuurVerzendenErr', $factuurVerzendenErr );
$smarty->assign( 'factuurTitel', $factuurTitel );
$smarty->assign( 'factuurTitelErr', $factuurTitelErr );
$smarty->assign( 'factuurNotatype', $factuurNotatype );
$smarty->assign( 'factuurNotatypeErr', $factuurNotatypeErr );
$smarty->assign( 'organisatieLogo', $organisatieLogo );
$smarty->assign( 'organisatieLogoErr', $organisatieLogoErr );
$smarty->assign( 'organisatieFooter', $organisatieFooter );
$smarty->assign( 'organisatieFooterErr', $organisatieFooterErr );
$smarty->assign( 'organisatieAdresregel', $organisatieAdresregel );
$smarty->assign( 'organisatieAdresregelErr', $organisatieAdresregelErr );
$smarty->assign( 'tabelEvenementKolom1', $tabelEvenementKolom1 );
$smarty->assign( 'tabelEvenementKolom1Err', $tabelEvenementKolom1Err );
$smarty->assign( 'tabelEvenementKolom2', $tabelEvenementKolom2 );
$smarty->assign( 'tabelEvenementKolom2Err', $tabelEvenementKolom2Err );
$smarty->assign( 'tabelEvenementKolom3', $tabelEvenementKolom3 );
$smarty->assign( 'tabelEvenementKolom3Err', $tabelEvenementKolom3Err );
$smarty->assign( 'tabelEvenementKolom4', $tabelEvenementKolom4 );
$smarty->assign( 'tabelEvenementKolom4Err', $tabelEvenementKolom4Err );
$smarty->assign( 'tabelEvenementKolom5', $tabelEvenementKolom5 );
$smarty->assign( 'tabelEvenementKolom5Err', $tabelEvenementKolom5Err );
$smarty->assign( 'tabelDeelnemerKolom1', $tabelDeelnemerKolom1 );
$smarty->assign( 'tabelDeelnemerKolom1Err', $tabelDeelnemerKolom1Err );
$smarty->assign( 'tabelDeelnemerKolom2', $tabelDeelnemerKolom2 );
$smarty->assign( 'tabelDeelnemerKolom2Err', $tabelDeelnemerKolom2Err );
$smarty->assign( 'tabelDeelnemerKolom3', $tabelDeelnemerKolom3 );
$smarty->assign( 'tabelDeelnemerKolom3Err', $tabelDeelnemerKolom3Err );
$smarty->assign( 'tabelDeelnemerKolom4', $tabelDeelnemerKolom4 );
$smarty->assign( 'tabelDeelnemerKolom4Err', $tabelDeelnemerKolom4Err );
$smarty->assign( 'tabelDeelnemerKolom5', $tabelDeelnemerKolom5 );
$smarty->assign( 'tabelDeelnemerKolom5Err', $tabelDeelnemerKolom5Err );
$smarty->assign( 'factuurBtwPercentage', $factuurBtwPercentage );
$smarty->assign( 'factuurBtwPercentageErr', $factuurBtwPercentageErr );
$smarty->assign( 'factuurBtwRegel1', $factuurBtwRegel1 );
$smarty->assign( 'factuurBtwRegel1Err', $factuurBtwRegel1Err );
$smarty->assign( 'factuurBtwRegel2', $factuurBtwRegel2 );
$smarty->assign( 'factuurBtwRegel2Err', $factuurBtwRegel2Err );
$smarty->assign( 'factuurBtwRegel3', $factuurBtwRegel3 );
$smarty->assign( 'factuurBtwRegel3Err', $factuurBtwRegel3Err );

$smarty->assign( 'enableIDeal', $enableIDeal );
$smarty->assign( 'enableIDealErr', $enableIDealErr );
$smarty->assign( 'idealCheckout', $idealCheckout );
$smarty->assign( 'idealCheckoutErr', $idealCheckoutErr );
$smarty->assign( 'idealStatusStopped', $idealStatusStopped );
$smarty->assign( 'idealStatusStoppedErr', $idealStatusStoppedErr );
$smarty->assign( 'idealStatusSuccess', $idealStatusSuccess );
$smarty->assign( 'idealStatusSuccessErr', $idealStatusSuccessErr );
$smarty->assign( 'idealStatusFailure', $idealStatusFailure );
$smarty->assign( 'idealStatusFailureErr', $idealStatusFailureErr );
$smarty->assign( 'idealStatusPending', $idealStatusPending );
$smarty->assign( 'idealStatusPendingErr', $idealStatusPendingErr );

$smarty->assign( 'betalingVoorwaarden', $betalingVoorwaarden );
$smarty->assign( 'betalingVoorwaardenErr', $betalingVoorwaardenErr );
$smarty->assign( 'betalingIncassoTekst', $betalingIncassoTekst );
$smarty->assign( 'betalingIncassoTekstErr', $betalingIncassoTekstErr );
$smarty->assign( 'betalingContantTekst', $betalingContantTekst );
$smarty->assign( 'betalingContantTekstErr', $betalingContantTekstErr );

$smarty->assign( 'settingLogDirectory', $settingLogDirectory );
$smarty->assign( 'settingLogDirectoryErr', $settingLogDirectoryErr );
$smarty->assign( 'settingTempDirectory', $settingTempDirectory );
$smarty->assign( 'settingTempDirectoryErr', $settingTempDirectoryErr );
$smarty->assign( 'settingFacturenDirectory', $settingFacturenDirectory );
$smarty->assign( 'settingFacturenDirectoryErr', $settingFacturenDirectoryErr );
$smarty->assign( 'settingImageDirectory', $settingImageDirectory );
$smarty->assign( 'settingImageDirectoryErr', $settingImageDirectoryErr );

$smarty->assign( 'settingBatchSize', $settingBatchSize );
$smarty->assign( 'settingBatchSizeErr', $settingBatchSizeErr );
$smarty->assign( 'settingRefresh', $settingRefresh );
$smarty->assign( 'settingRefreshErr', $settingRefreshErr );

$settingPasswordLijst[PASSWORD_ZWAK] = "Zwak";
$settingPasswordLijst[PASSWORD_MEDIUM] = "Medium";
$settingPasswordLijst[PASSWORD_STERK] = "Sterk";
$settingPasswordLijst[PASSWORD_ZEERSTERK] = "Zeer sterk";

$smarty->assign( 'settingPasswordLijst', $settingPasswordLijst );
$smarty->assign( 'settingPasswordMedewerker', $settingPasswordMedewerker );
$smarty->assign( 'settingPasswordMedewerkerErr', $settingPasswordMedewerkerErr );
$smarty->assign( 'settingPasswordKlant', $settingPasswordKlant );
$smarty->assign( 'settingPasswordKlantErr', $settingPasswordKlantErr );
$smarty->assign( 'enableVerzekering', $enableVerzekering );
$smarty->assign( 'enableVerzekeringErr', $enableVerzekeringErr );
$smarty->assign( 'settingVerzekeringVoorwaarden', $settingVerzekeringVoorwaarden );
$smarty->assign( 'settingVerzekeringVoorwaardenErr', $settingVerzekeringVoorwaardenErr );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'settings.tpl' );
