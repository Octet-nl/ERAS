<?php
/**
 * System      Inschrijvingen
 * Module      setup
 * Doel        Instellingen en configuratie
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-07-2020
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
$organisatieVerzekeringVoorwaarden = "";
$bankIbanNummer = "";
$bankBicNummer = "";
$bankTenNameVan = "";
$factuurAanmaken = "";
$factuurVerzenden = "";
$factuurTitel = "";
$factuurNotatype = "";
$factuurLogo = "";
$factuurFooter = "";
$factuurAdresregel = "";
$factuurEvenementKolom1 = "";
$factuurEvenementKolom2 = "";
$factuurEvenementKolom3 = "";
$factuurEvenementKolom4 = "";
$factuurEvenementKolom5 = "";
$factuurDeelnemerKolom1 = "";
$factuurDeelnemerKolom2 = "";
$factuurDeelnemerKolom3 = "";
$factuurDeelnemerKolom4 = "";
$factuurDeelnemerKolom5 = "";
$factuurBtwPercentage = "";
$factuurBtwRegel1 = "";
$factuurBtwRegel2 = "";
$factuurBtwRegel3 = "";
$idealCheckout = "";
$idealStatusStopped = "";
$idealStatusSuccess = "";
$idealStatusFailure = "";
$idealStatusPending = "";
$betalingVoorwaarden = "";
$settingLogDirectory = "";
$settingTempDirectory = "";
$settingFacturenDirectory = "";
$settingImageDirectory = "";
$settingBatchSize = "";

$organisatieNaamErr = "";
$organisatieEmailErr = "";
$organisatieWebsiteErr = "";
$organisatieVoorwaardenErr = "";
$organisatieVerzekeringVoorwaardenErr = "";
$bankIbanNummerErr = "";
$bankBicNummerErr = "";
$bankTenNameVanErr = "";
$factuurAanmakenErr = "";
$factuurVerzendenErr = "";
$factuurTitelErr = "";
$factuurNotatypeErr = "";
$factuurLogoErr = "";
$factuurFooterErr = "";
$factuurAdresregelErr = "";
$factuurEvenementKolom1Err = "";
$factuurEvenementKolom2Err = "";
$factuurEvenementKolom3Err = "";
$factuurEvenementKolom4Err = "";
$factuurEvenementKolom5Err = "";
$factuurDeelnemerKolom1Err = "";
$factuurDeelnemerKolom2Err = "";
$factuurDeelnemerKolom3Err = "";
$factuurDeelnemerKolom4Err = "";
$factuurDeelnemerKolom5Err = "";
$factuurBtwPercentageErr = "";
$factuurBtwRegel1Err = "";
$factuurBtwRegel2Err = "";
$factuurBtwRegel3Err = "";
$idealCheckoutErr = "";
$idealStatusStoppedErr = "";
$idealStatusSuccessErr = "";
$idealStatusFailureErr = "";
$idealStatusPendingErr = "";
$betalingVoorwaardenErr = "";
$settingLogDirectoryErr = "";
$settingTempDirectoryErr = "";
$settingFacturenDirectoryErr = "";
$settingImageDirectoryErr = "";
$settingBatchSizeErr = "";

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
    $organisatieVerzekeringVoorwaarden = $ini['organisatie']['verzekering'];

    $bankIbanNummer = $ini['bank']['IBAN'];
    $bankBicNummer = $ini['bank']['BIC'];
    $bankTenNameVan = $ini['bank']['ten_name_van'];

    $factuurAanmaken = $ini['pdf_factuur']['aanmaken'];
    $factuurVerzenden = $ini['pdf_factuur']['verzenden'];
    $factuurTitel = $ini['pdf_factuur']['titel'];
    $factuurNotatype = $ini['pdf_factuur']['notatype'];
    $factuurLogo = $ini['pdf_factuur']['logo'];
    $factuurFooter = $ini['pdf_factuur']['footer'];
    $factuurAdresregel = $ini['pdf_factuur']['adresregel'];
    $factuurEvenementKolom1 = $ini['pdf_factuur']['evenement-kolom1'];
    $factuurEvenementKolom2 = $ini['pdf_factuur']['evenement-kolom2'];
    $factuurEvenementKolom3 = $ini['pdf_factuur']['evenement-kolom3'];
    $factuurEvenementKolom4 = $ini['pdf_factuur']['evenement-kolom4'];
    $factuurEvenementKolom5 = $ini['pdf_factuur']['evenement-kolom5'];
    $factuurDeelnemerKolom1 = $ini['pdf_factuur']['deelnemer-kolom1'];
    $factuurDeelnemerKolom2 = $ini['pdf_factuur']['deelnemer-kolom2'];
    $factuurDeelnemerKolom3 = $ini['pdf_factuur']['deelnemer-kolom3'];
    $factuurDeelnemerKolom4 = $ini['pdf_factuur']['deelnemer-kolom4'];
    $factuurDeelnemerKolom5 = $ini['pdf_factuur']['deelnemer-kolom5'];
    $factuurBtwPercentage = $ini['pdf_factuur']['BTW-percentage'];
    $factuurBtwRegel1 = $ini['pdf_factuur']['BTW-regel1'];
    $factuurBtwRegel2 = $ini['pdf_factuur']['BTW-regel2'];
    $factuurBtwRegel3 = $ini['pdf_factuur']['BTW-regel3'];

    $idealCheckout = $ini['ideal_payment']['checkout_script'];
    $idealStatusStopped = $ini['ideal_payment']['status_stopped'];
    $idealStatusSuccess = $ini['ideal_payment']['status_success'];
    $idealStatusFailure = $ini['ideal_payment']['status_failure'];
    $idealStatusPending = $ini['ideal_payment']['status_pending'];

    $betalingVoorwaarden = $ini['betaling']['voorwaarden'];

    $settingLogDirectory = $ini['settings']['log_directory'];
    $settingTempDirectory = $ini['settings']['temp_directory'];
    $settingFacturenDirectory = $ini['settings']['facturen_directory'];
    $settingImageDirectory = $ini['settings']['image_directory'];

    $settingBatchSize = $ini['settings']['batch_size'];

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
            ->required( true )->go();
        $validateOk += $setVar->name( $organisatieVerzekeringVoorwaarden )
            ->onerror( $organisatieVerzekeringVoorwaardenErr )
            ->errormessage( "Link niet gevonden" )
            ->validator( v::callback( 'urlExists' ) )
            ->required( true )->go();

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

        $validateOk += $setVar->name( $factuurAanmaken )
            ->onerror( $factuurAanmakenErr )
            ->validator( v::oneOf( v::equals( OPTIE_KEUZE_JA ), v::equals( OPTIE_KEUZE_NEE ) ) )
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
        $validateOk += $setVar->name( $factuurLogo )
            ->validator( v::callback( 'file_exists' ) )
            ->onerror( $factuurLogoErr )
            ->errormessage( "Bestand niet gevonden" )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurFooter )
            ->onerror( $factuurFooterErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurAdresregel )
            ->onerror( $factuurAdresregelErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurEvenementKolom1 )
            ->onerror( $factuurEvenementKolom1Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurEvenementKolom2 )
            ->onerror( $factuurEvenementKolom2Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurEvenementKolom3 )
            ->onerror( $factuurEvenementKolom3Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurEvenementKolom4 )
            ->onerror( $factuurEvenementKolom4Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurEvenementKolom5 )
            ->onerror( $factuurEvenementKolom5Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurDeelnemerKolom1 )
            ->onerror( $factuurDeelnemerKolom1Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurDeelnemerKolom2 )
            ->onerror( $factuurDeelnemerKolom2Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurDeelnemerKolom3 )
            ->onerror( $factuurDeelnemerKolom3Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurDeelnemerKolom4 )
            ->onerror( $factuurDeelnemerKolom4Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurDeelnemerKolom5 )
            ->onerror( $factuurDeelnemerKolom5Err )
            ->required( true )->go();
        $validateOk += $setVar->name( $factuurBtwPercentage )
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
        $validateOk += $setVar->name( $betalingVoorwaarden )
            ->onerror( $betalingVoorwaardenErr )
            ->noHtmlCleaning()
            ->formatter( 'stripQuotes' )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $settingLogDirectory )
            ->validator( v::callback( 'dirWriteable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingLogDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingTempDirectory )
            ->validator( v::callback( 'dirWriteable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingTempDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingFacturenDirectory )
            ->validator( v::callback( 'dirWriteable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingFacturenDirectoryErr )
            ->required( true )->go();
        $validateOk += $setVar->name( $settingImageDirectory )
            ->validator( v::callback( 'dirWriteable' ) )
            ->formatter( 'trimDir' )
            ->errormessage( "Directory bestaat niet of kan er niet in schrijven" )
            ->onerror( $settingImageDirectoryErr )
            ->required( true )->go();

        $validateOk += $setVar->name( $settingBatchSize )
            ->onerror( $settingBatchSizeErr )
            ->validator( v::number() )
            ->required( true )->go();

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
            fprintf( $fp, 'verzekering="%s"' . "\n", $organisatieVerzekeringVoorwaarden );
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
            fprintf( $fp, 'logo="%s"' . "\n", $factuurLogo );
            fprintf( $fp, 'footer="%s"' . "\n", $factuurFooter );
            fprintf( $fp, 'adresregel="%s"' . "\n", $factuurAdresregel );
            fprintf( $fp, 'evenement-kolom1="%s"' . "\n", $factuurEvenementKolom1 );
            fprintf( $fp, 'evenement-kolom2="%s"' . "\n", $factuurEvenementKolom2 );
            fprintf( $fp, 'evenement-kolom3="%s"' . "\n", $factuurEvenementKolom3 );
            fprintf( $fp, 'evenement-kolom4="%s"' . "\n", $factuurEvenementKolom4 );
            fprintf( $fp, 'evenement-kolom5="%s"' . "\n", $factuurEvenementKolom5 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'deelnemer-kolom1="%s"' . "\n", $factuurDeelnemerKolom1 );
            fprintf( $fp, 'deelnemer-kolom2="%s"' . "\n", $factuurDeelnemerKolom2 );
            fprintf( $fp, 'deelnemer-kolom3="%s"' . "\n", $factuurDeelnemerKolom3 );
            fprintf( $fp, 'deelnemer-kolom4="%s"' . "\n", $factuurDeelnemerKolom4 );
            fprintf( $fp, 'deelnemer-kolom5="%s"' . "\n", $factuurDeelnemerKolom5 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'BTW-percentage=%s' . "\n", $factuurBtwPercentage );
            fprintf( $fp, 'BTW-regel1="%s"' . "\n", $factuurBtwRegel1 );
            fprintf( $fp, 'BTW-regel2="%s"' . "\n", $factuurBtwRegel2 );
            fprintf( $fp, 'BTW-regel3="%s"' . "\n", $factuurBtwRegel3 );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[ideal_payment]' . "\n" );
            fprintf( $fp, 'checkout_script="%s"' . "\n", $idealCheckout );
            fprintf( $fp, 'status_stopped="%s"' . "\n", $idealStatusStopped );
            fprintf( $fp, 'status_success="%s"' . "\n", $idealStatusSuccess );
            fprintf( $fp, 'status_failure="%s"' . "\n", $idealStatusFailure );
            fprintf( $fp, 'status_pending="%s"' . "\n", $idealStatusPending );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[betaling]' . "\n" );
            fprintf( $fp, 'voorwaarden="%s"' . "\n", $betalingVoorwaarden );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, '[settings]' . "\n" );
            fprintf( $fp, 'log_directory="%s"' . "\n", $settingLogDirectory );
            fprintf( $fp, 'temp_directory="%s"' . "\n", $settingTempDirectory );
            fprintf( $fp, 'facturen_directory="%s"' . "\n", $settingFacturenDirectory );
            fprintf( $fp, 'image_directory="%s"' . "\n", $settingImageDirectory );
            fprintf( $fp, ';' . "\n" );
            fprintf( $fp, 'batch_size="%s"' . "\n", $settingBatchSize );
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
            $statusRegel = "Herstel a.u.b. de fout en probeer het opnieuw";
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

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'organisatieNaam', $organisatieNaam );
$smarty->assign( 'organisatieNaamErr', $organisatieNaamErr );
$smarty->assign( 'organisatieEmail', $organisatieEmail );
$smarty->assign( 'organisatieEmailErr', $organisatieEmailErr );
$smarty->assign( 'organisatieWebsite', $organisatieWebsite );
$smarty->assign( 'organisatieWebsiteErr', $organisatieWebsiteErr );
$smarty->assign( 'organisatieVoorwaarden', $organisatieVoorwaarden );
$smarty->assign( 'organisatieVoorwaardenErr', $organisatieVoorwaardenErr );
$smarty->assign( 'organisatieVerzekeringVoorwaarden', $organisatieVerzekeringVoorwaarden );
$smarty->assign( 'organisatieVerzekeringVoorwaardenErr', $organisatieVerzekeringVoorwaardenErr );

$smarty->assign( 'bankIbanNummer', $bankIbanNummer );
$smarty->assign( 'bankIbanNummerErr', $bankIbanNummerErr );
$smarty->assign( 'bankBicNummer', $bankBicNummer );
$smarty->assign( 'bankBicNummerErr', $bankBicNummerErr );
$smarty->assign( 'bankTenNameVan', $bankTenNameVan );
$smarty->assign( 'bankTenNameVanErr', $bankTenNameVanErr );

$smarty->assign( 'ja', OPTIE_KEUZE_JA );
$smarty->assign( 'nee', OPTIE_KEUZE_NEE );

$smarty->assign( 'factuurAanmaken', $factuurAanmaken );
$smarty->assign( 'factuurAanmakenErr', $factuurAanmakenErr );
$smarty->assign( 'factuurVerzenden', $factuurVerzenden );
$smarty->assign( 'factuurVerzendenErr', $factuurVerzendenErr );
$smarty->assign( 'factuurTitel', $factuurTitel );
$smarty->assign( 'factuurTitelErr', $factuurTitelErr );
$smarty->assign( 'factuurNotatype', $factuurNotatype );
$smarty->assign( 'factuurNotatypeErr', $factuurNotatypeErr );
$smarty->assign( 'factuurLogo', $factuurLogo );
$smarty->assign( 'factuurLogoErr', $factuurLogoErr );
$smarty->assign( 'factuurFooter', $factuurFooter );
$smarty->assign( 'factuurFooterErr', $factuurFooterErr );
$smarty->assign( 'factuurAdresregel', $factuurAdresregel );
$smarty->assign( 'factuurAdresregelErr', $factuurAdresregelErr );
$smarty->assign( 'factuurEvenementKolom1', $factuurEvenementKolom1 );
$smarty->assign( 'factuurEvenementKolom1Err', $factuurEvenementKolom1Err );
$smarty->assign( 'factuurEvenementKolom2', $factuurEvenementKolom2 );
$smarty->assign( 'factuurEvenementKolom2Err', $factuurEvenementKolom2Err );
$smarty->assign( 'factuurEvenementKolom3', $factuurEvenementKolom3 );
$smarty->assign( 'factuurEvenementKolom3Err', $factuurEvenementKolom3Err );
$smarty->assign( 'factuurEvenementKolom4', $factuurEvenementKolom4 );
$smarty->assign( 'factuurEvenementKolom4Err', $factuurEvenementKolom4Err );
$smarty->assign( 'factuurEvenementKolom5', $factuurEvenementKolom5 );
$smarty->assign( 'factuurEvenementKolom5Err', $factuurEvenementKolom5Err );
$smarty->assign( 'factuurDeelnemerKolom1', $factuurDeelnemerKolom1 );
$smarty->assign( 'factuurDeelnemerKolom1Err', $factuurDeelnemerKolom1Err );
$smarty->assign( 'factuurDeelnemerKolom2', $factuurDeelnemerKolom2 );
$smarty->assign( 'factuurDeelnemerKolom2Err', $factuurDeelnemerKolom2Err );
$smarty->assign( 'factuurDeelnemerKolom3', $factuurDeelnemerKolom3 );
$smarty->assign( 'factuurDeelnemerKolom3Err', $factuurDeelnemerKolom3Err );
$smarty->assign( 'factuurDeelnemerKolom4', $factuurDeelnemerKolom4 );
$smarty->assign( 'factuurDeelnemerKolom4Err', $factuurDeelnemerKolom4Err );
$smarty->assign( 'factuurDeelnemerKolom5', $factuurDeelnemerKolom5 );
$smarty->assign( 'factuurDeelnemerKolom5Err', $factuurDeelnemerKolom5Err );
$smarty->assign( 'factuurBtwPercentage', $factuurBtwPercentage );
$smarty->assign( 'factuurBtwPercentageErr', $factuurBtwPercentageErr );
$smarty->assign( 'factuurBtwRegel1', $factuurBtwRegel1 );
$smarty->assign( 'factuurBtwRegel1Err', $factuurBtwRegel1Err );
$smarty->assign( 'factuurBtwRegel2', $factuurBtwRegel2 );
$smarty->assign( 'factuurBtwRegel2Err', $factuurBtwRegel2Err );
$smarty->assign( 'factuurBtwRegel3', $factuurBtwRegel3 );
$smarty->assign( 'factuurBtwRegel3Err', $factuurBtwRegel3Err );

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

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'settings.tpl' );
