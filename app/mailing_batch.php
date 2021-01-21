<?php
/**
 * System      ERAS
 * Module      Batch mailing verzenden
 * Doel        Verzend mailing in batches
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-10-2020
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

$doctitle = "Batch mailing";

// define variables and set to empty values
$melding = "";
$aantal = 0;
$evt = 0;
$start = 1;
$size = 10;
$evenementNaam = "onbekend";
$tekst = "<Geen tekst aanwezig>";

$inschrijvers = array();

$logger->debug( $doctitle );

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

    getGetVar( $evt );
    getGetVar( $aantal );
    getGetVar( $size );
    getGetVar( $start );
    getGetVar( $tekst );

    if ( $evt == null || $size == null || $start == null || $tekst == null )
    {
        $logger->warning( "Onjuiste aanroep, evt=" . $evt );
        $logger->warning( "Onjuiste aanroep, size=" . $size );
        $logger->warning( "Onjuiste aanroep, start=" . $start );
        $logger->warning( "Onjuiste aanroep, tekst=" . $tekst );
        $melding = "Onjuiste aanroep";
    }
    else
    {
        $logger->debug( "Evt=" . $evt );
        $logger->debug( "Size=" . $size );
        $logger->debug( "Start=" . $start );
        $logger->debug( "Tekst=" . $tekst );
        $mailingTekst = file_get_contents( $tekst );

        if ( $evt > 0 )
        {
            $logger->debug( 'Inschrijvers voor evenement ' . $evt );
            $inschrijvers = MailinglistQuery::create()
              ->filterByEvenementId( $evt )
              ->find();

            $evenementNaam = EvenementQuery::create()->findPk( $evt )->getNaam();
        }
        else
        {
            $logger->debug( 'Inschrijvers voor alle evenementen' );
            $inschrijvers = MailinglistQuery::create()
              ->find();
            $evenementNaam = "Onze evenementen";
        }
        $aantal = $inschrijvers->count();
    }

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
    $setVar->name( $evt )
        ->required()
        ->go();
    $setVar->name( $tekst )
        ->required()
        ->go();
    $setVar->name( $start )
        ->required()
        ->go();
    $setVar->name( $size )
        ->required()
        ->go();

    if ( isset( $_POST['download'] ) )
    {
        header( "Location:mailing_download.php?evt=" .$evt );
        exit;
    }

    $mailingTekst = file_get_contents( $tekst );

    $logger->debug( "Mailing tekst: " . $mailingTekst );

    if ( isset( $_POST['verzend'] ) )
    {
        try
        {
            $logger->debug( 'Voor evenement ' . $evt );
            $logger->debug( 'Tekst ' . $mailingTekst );

            if ( $evt > 0 )
            {
                $logger->debug( 'Inschrijvers voor evenement ' . $evt );
                $inschrijvers = MailinglistQuery::create()
                  ->filterByEvenementId( $evt )
                  ->paginate($start, $size);
            }
            else
            {
                $logger->debug( 'Inschrijvers voor alle evenementen' );
                $inschrijvers = MailinglistQuery::create()
                  ->paginate($start, $size);
            }

            $email = new PHPMailer( true );

            $logger->debug( 'Mailer geconstruct' );

            $ini = parse_ini_file( CONFIG_FILENAME, true );

            $logger->debug( 'Ini gevonden' );

            if ( $evt == 0 )
            {
                $evenementNaam = "onze evenementen";    
            }
            else
            {
                $evenementNaam = "evenement ";
                $evenementNaam .= EvenementQuery::create()->findPk( $evt )->getNaam();
            }

            // Magic om de huidige URL te vinden
            $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
            $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";
            $logger->debug( "Onze URL: " . $url );

            $logger->debug( 'Evenementnaam ' .$evenementNaam );

            $email->setFrom( $ini['organisatie']['email'], $ini['organisatie']['organisatienaam'] ); //Name is optional
            $email->Subject = "Informatie over " . $evenementNaam;
            $email->IsHTML( true );

            foreach( $inschrijvers as $inschrijver )
            {
                $unsubscribeLink = $url . '/mailing_afmelden.php?mail=' . $inschrijver->getEmail() . "&code=" . $inschrijver->getCode();
                $adresRegel = '<div style="font-size:0.8em;">' . $ini['organisatie']['adresregel'] . '</div>';
                $ondersteRegels = '<br/><br/><div align="center"><a href="' . $unsubscribeLink . '">afmelden bij deze nieuwsbrief</a><br/>' . $adresRegel . '</div>';

                $email->Body = $mailingTekst . $ondersteRegels;
                $email->clearAddresses();
                $email->addAddress( $inschrijver->getEmail() );
                if ( !$email->send() )
                {
                    //The reason for failing to send will be in $mail->ErrorInfo
                    //but you shouldn't display errors to users - process the error, log it on your server.
                    $statusRegel = "Door een technisch probleem kunnen wij de mailing nu niet verzenden. Zie errorlog.<br/>";
                    $signalError = true;
                    $logger->error( 'Probleem bij verzenden mail.' . $email->ErrorInfo );
                    continue;
                }
                else
                {
                    $logger->debug( "Mail verzonden naar " . $inschrijver->getEmail() );
                }
            }
            $logger->debug( "Start was " . $start );
            $start += 1;
            $logger->debug( "Start is " . $start );
            header( 'Location:mailing_batch.php?evt=' . $evt . '&start=' . $start . '&size=' . $size . '&tekst=' . $tekst );
            exit();
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
}

// DEEL 3
$togo = $aantal - ( ($start-1) * $size );
if ( $togo < 0 )
{
    $togo = 0;
}

if ( $togo == 0 )
{
    unlink( $tekst );
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'aantal', $aantal );
$smarty->assign( 'start', $start );
$smarty->assign( 'size', $size );
$smarty->assign( 'tekst', $tekst );
$smarty->assign( 'togo', $togo );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'evenementnaam', $evenementNaam);
$smarty->assign( 'melding', $melding );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'mailing_batch.tpl' );
