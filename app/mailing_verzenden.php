<?php
/**
 * System      Inschrijvingen
 * Module      Mailing verzenden
 * Doel        Verzend mailing voor een evenement naar mensen op de mailinglist
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       06-10-2020
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

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\MailinglistQuery;
use PHPMailer\PHPMailer\PHPMailer;

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Mailing verzenden";

// define variables and set to empty values
$bevestig = "";
$evenementnaam = "";
$evenementId = "";
$mailadres = "";
$code = "";
$evt = "";
$aantal = 0;
$batchSize = 10;
$mailingTekst = "";
$mailingTekstErr = "";
$unsubscribeLink = "";

$evenement_lijst = array();
$inschrijvers = array();

$logger->debug( $doctitle );

$footerRegel = "";
$adresRegel = "";

$statusRegel = "";
$signalError = false;

$history = new History();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );

    $history->set();

    if ( isset( $_GET['evt'] ) )
    {
        $evenementId = $_GET['evt'];
        if ( $evenementId > 0 )
        {
            $logger->debug( 'Inschrijvers voor evenement ' . $evenementId );
            $inschrijvers = MailinglistQuery::create()
              ->filterByEvenementId( $evenementId )
              ->find();
        }
        else
        {
            $logger->debug( 'Inschrijvers voor alle evenementen' );
            $inschrijvers = MailinglistQuery::create()
              ->find();
        //    ->paginate(2, 10);
        }
        $aantal = $inschrijvers->count();
    }
    else
    {
        $evenementId = 99999999;
    }

    $logger->debug( "Aanmaken mailing" );

    $ini = parse_ini_file( CONFIG_FILENAME, true );
    $footerRegel = $ini['pdf_factuur']['footer'];
    $adresRegel = '<div style="font-size:0.8em;">' . $ini['pdf_factuur']['adresregel'] . '</div>';

    // Vullen evenementenlijst
    $evenementen = EvenementQuery::create()
        ->filterByStatus( EVENEMENT_STATUS_OPEN )
        ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
        ->find();

    $evenement_lijst["99999999"] = " ";
    $evenement_lijst["0"] = "Alle";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }

    // Magic om de huidige URL te vinden
    $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
    $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";
    $logger->debug( "Onze URL: " . $url );

    $unsubscribeLink = $url . '/mailing_afmelden.php';
           
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug = $history->get();
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
    $setVar->name( $evenementId )
        ->onerror($mailingTekstErr)
        ->required()
        ->go();
    $setVar->name( $mailingTekst )
        ->noHtmlCleaning()
        ->formatter( 'stripHtml' )
        ->onerror($mailingTekstErr)
        ->required()
        ->go();

        $logger->debug( "Tekst: " . $mailingTekst );

    if ( isset( $_POST['download'] ) )
    {
        header( "Location:mailing_download.php?evt=" .$evenementId );
        exit;
    }

    $ini = parse_ini_file( CONFIG_FILENAME, true );
    $batchSize = $ini['settings']['batch_size'];

    if ( isset( $_POST['batch'] ) )
    {
        $uniqName = uniqid('mailtekst_', FALSE);
        $tmpFile = "../temp/$uniqName.txt";
        file_put_contents( $tmpFile, $mailingTekst );
        header( 'Location:mailing_batch.php?evt=' . $evenementId . '&start=1&size=' . $batchSize . '&tekst=' . $tmpFile  );
        exit();
    }

    if ( isset( $_POST['verzend'] ) )
    {
        try
        {
            $logger->debug( 'Voor evenement ' . $evenementId );
            $logger->debug( 'Tekst ' . $mailingTekst );

            $email = new PHPMailer( true );

            $logger->debug( 'Mailer geconstruct' );

            $logger->debug( 'Ini gevonden' );

            if ( $evenementId == 0 )
            {
                $evenementNaam = "onze evenementen";    
            }
            else
            {
                $evenementNaam = "evenement ";
                $evenementNaam .= EvenementQuery::create()->findPk( $evenementId )->getNaam();
            }

            // Magic om de huidige URL te vinden
            $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
            $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";
            $logger->debug( "Onze URL: " . $url );
            $unsubscribeLink = $url . '/mailing_afmelden.php';

            $ini = parse_ini_file( CONFIG_FILENAME, true );
            $adresRegel = '<div>' . $ini['pdf_factuur']['adresregel'] . '</div>';
        
            $mailingTekst .= '<br/><br/><div align="center" style="font-size:0.8em;">U ontvangt deze mail omdat u zich hiervoor heeft aangemeld. U kunt zich <a href="' . $unsubscribeLink . '">hier</a> afmelden<br/>' . $adresRegel . '</div>';
            
            $logger->debug( 'Evenementnaam ' .$evenementNaam );

            $email->setFrom( $ini['organisatie']['email'], $ini['organisatie']['organisatienaam'] ); //Name is optional
            $email->Subject = "Informatie over " . $evenementNaam;
            $email->Body = $mailingTekst;
            $email->IsHTML( true );
            $email->addAddress( $ini['organisatie']['email'] );

            $logger->debug( 'Header gevuld' );

            if ( $evenementId > 0 )
            {
                $logger->debug( 'Mail naar inschrijvers voor evenement ' . $evenementId );
                $inschrijvers = MailinglistQuery::create()
                  ->filterByEvenementId( $evenementId )
                  ->find();
            }
            else
            {
                $logger->debug( 'Mail naar inschrijvers voor alle evenementen' );
                $inschrijvers = MailinglistQuery::create()
                  ->find();
            //    ->paginate(2, 10);
            }

            foreach( $inschrijvers as $inschrijver )
            {
                $email->addBCC( $inschrijver->getEmail() );
            }

            if ( !$email->send() )
            {
                //The reason for failing to send will be in $mail->ErrorInfo
                //but you shouldn't display errors to users - process the error, log it on your server.
                $statusRegel = "Door een technisch probleem kunnen wij de mailing nu niet verzenden. Zie errorlog.<br/>";
                $signalError = true;
                $logger->error( 'Probleem bij verzenden mail.' . $email->ErrorInfo );
                $logger->debug( $message );
            }
            else
            {
                $statusRegel = "De mail is verzonden naar de geadresseerden.";
                $logger->debug( 'De mail is verzonden naar de geadresseerden.' );
                alertAndGo( "Mailing is verzonden.", "mailing_verzenden.php");
            }


        }
        catch ( Exception $ex )
        {
            $statusRegel = "Door een technisch probleem kunnen wij de mailing nu niet verzenden. Zie errorlog.<br/>";
            $signalError = true;
            $logger->error( "Unhandled exception in SetVariable" );
            $logger->errordump( $ex );
            $validateOk = 999;
        }
    }
    else if ( isset( $_POST['evenementId'] ) )
    {
        $evenementId = $_POST['evenementId'];
        $logger->debug( 'Voor evenement ' . $evenementId );
        header( "Location:mailing_verzenden.php?evt=" . $evenementId );
        exit();
    }


}
// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

$ini = parse_ini_file( CONFIG_FILENAME, true );
$imageDirectory = $ini['settings']['image_directory'] . '/';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'imageDirectory', $imageDirectory );
$smarty->assign( 'evenement_lijst', $evenement_lijst );
$smarty->assign( 'evenementId', $evenementId );
$smarty->assign( 'mailingTekst', $mailingTekst );
$smarty->assign( 'mailingTekstErr', $mailingTekstErr );
$smarty->assign( 'unsubscribeLink', $unsubscribeLink );
$smarty->assign( 'aantal', $aantal );
$smarty->assign( 'batchSize', $batchSize );
$smarty->assign( 'footerRegel', $footerRegel );
$smarty->assign( 'adresRegel', $adresRegel );
$smarty->assign( 'bevestig', $bevestig );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'mailing_verzenden.tpl' );
