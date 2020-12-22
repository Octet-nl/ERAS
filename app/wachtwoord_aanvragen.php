<?php
/**
 * System      ERAS
 * Module      Wachtwoord aanvragen
 * Doel        Wachtwoord vergeten, nieuw wachtwoord aanvragen.
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       21-09-2020
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

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';
require_once 'code_generator_class.php';

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$sessie = new Sessie();

$doctitle = "Wachtwoord aanvragen";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use Respect\Validation\Validator as v;
use \fb_model\fb_model\Contactlog;
use \fb_model\fb_model\GebruikerQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\WachtwoordReset;
use \fb_model\fb_model\WachtwoordResetQuery;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$logger = new Logger();
$logger->level( LOGLEVEL );

$email = $emailErr = "";
$bevestig = "";

$history = new History();

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set( );
    getGetVar( $email );
}


// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    
    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        header( "Location:" . $terug );
        exit;
    }

    if ( !isset( $_POST['stuur'] ) )
    {
        header( "Refresh:0" );
        exit;
    }

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $email )
        ->onerror( $emailErr )
        ->emptymessage( "Vul uw e-mail adres in" )
        ->formatter( 'strtolower' )
        ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
        //->validator( v::email()->length( 1, 255 ) )
        ->required( true )
        ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $emailErr = "Er is iets mis gegaan..";
        $validateOk = 999;
    }
    if ( $validateOk == 0 )
    {
        // Testen of we dit mailadres kennen
        $gebruiker = GebruikerQuery::create()
            ->filterByUserId( $email )
            ->findOne();
        if ( $gebruiker == null )
        {
            $emailErr = "Dit mailadres is bij ons niet bekend. ";
            $validateOk = 999;
        }
    }

    if ( $validateOk == 0 )
    {
        $codeGen = new CodeBeheer();
        $codeGen->setLengte(36);
        $code = $codeGen->genereer(false);

        $huidigeCode = WachtwoordResetQuery::create()->filterByEmail( $email )->find( );
        if ( $huidigeCode != null )
        {
            $huidigeCode->delete();
        }

        // Genereer unieke code
        while ( WachtwoordResetQuery::create()->filterByToken( $code )->findOne( ) != null )
        {
            $code = $codeGen->genereer(false);
        }

        $my_date_time = date("d-m-Y H:i:s", strtotime("+30 minutes"));

        $wwReset = new WachtwoordReset();
        $wwReset->setEmail( $email );
        $wwReset->setToken( $code );
        $wwReset->setGeldigTot( $my_date_time );
        $wwReset->setGemaaktDoor( $email );
        $wwReset->save();

        $ini = parse_ini_file( CONFIG_FILENAME, true );

        // Magic om de huidige URL te vinden
        $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";
        $logger->debug( "Onze URL: " . $url );
    
        $resetLink = $url . '/wachtwoord_nieuw.php?token=' . $code;
        
        $message = "Geachte mevrouw/heer<br/><br/>
        Klik <a href=" . $resetLink . ">hier</a> om het wachtwoord van uw account te resetten.<br/>
        Als de link niet werkt kunt u ook het volgende in de adresregel van uw browser kopieren:<br/><br/>" .  
            $resetLink . "
        <br/>
        Deze link is 30 minuten geldig.<br/><br/>
        Voor meer informatie, bezoek onze website<br/>
        " . $ini['organisatie']['website'] . "
        <br/><br/>
        " . $ini['organisatie']['organisatienaam'] . "
        <br/><br/>
        <hr>
        Als u dit niet aangevraagd heeft, verzoeken wij u deze mail te negeren. ";

        $persoonId = $gebruiker->getPersoonId();
        if ( $persoonId != null )
        {
            $persoon = PersoonQuery::create()->filterById( $persoonId )->find();
            if ( $persoon != null )
            {
                $contactPersoonId = $persoonId;
                $contactlog = new Contactlog;
                $contactlog->setPersoonId( $contactPersoonId );
                $contactlog->setTekst(  "Wachtwoord reset door gebruiker aangevraagd (wachtwoord vergeten)." );
                $contactlog->setGemaaktDoor( $email );
                $contactlog->save();
            }
        }

        try
        {
            $mail = new PHPMailer( true );

            $logger->debug( 'Mailer geconstruct' );

            $ini = parse_ini_file( CONFIG_FILENAME, true );
            $mail->setFrom( $ini['organisatie']['email'] ); //Name is optional
            $mail->Subject = "Wachtwoord vergeten";
            $mail->Body = $message;
            $mail->IsHTML( true );
            $mail->addAddress( $email );

            $logger->debug( 'Header gevuld' );

            if ( !$mail->send() )
            {
                //The reason for failing to send will be in $mail->ErrorInfo
                //but you shouldn't display errors to users - process the error, log it on your server.
                $bevestig = "De mail met de reset-link is aangemaakt, maar door een technisch probleem kunnen wij deze nu niet verzenden. Neem a.u.b. contact met ons op.<br/>";
                $logger->error( 'Probleem bij verzenden mail.' . $mail->ErrorInfo );
                $logger->debug( $message );
            }
            else
            {
                $bevestig = "De mail met de reset-link is verzonden naar uw email adres (" . $mailadres . ").<br/>Deze link is 30 minuten geldig.";
                $logger->debug( 'De mail met de reset-link is verzonden naar ' . $mailadres );
            }
        }
        catch ( Exception $e )
        {
            alert( "De mail met de reset-link is aangemaakt, maar door een technisch probleem kunnen wij deze nu niet verzenden. Neem hiervoor a.u.b. contact met ons op.");
            $bevestig = "De mail met de reset-link is aangemaakt, maar door een technisch probleem kunnen wij deze nu niet verzenden. Neem a.u.b. contact met ons op.<br/>";
            $logger->error( "De mail met de reset-link is aangemaakt, verzenden geeft exceptie:" );
            $logger->error( $e->getMessage() );
            $logger->debug( $message );
            //        alertAndGo( $bevestig, "evenement_kiezen.php" );
            //        exit();
        }
    }

}

// Deel 3, wordt altijd uitgevoerd.

$smarty->assign( 'doctitle', $doctitle );

$smarty->assign( 'bevestig', $bevestig );

$smarty->assign( 'email', $email );
$smarty->assign( 'emailErr', $emailErr );

$smarty->display( 'wachtwoord_aanvragen.tpl' );
