<?php
/**
 * System      ERAS
 * Module      Reset wachtwoord
 * Doel        Resetten van een vergeten wachtwoord
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       23-09-2020
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

$sessie = new Sessie();

$doctitle = "Reset wachtwoord";
$logger = new Logger();
$logger->level( LOGLEVEL );

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use Respect\Validation\Validator as v;
use \fb_model\fb_model\Contactlog;
use \fb_model\fb_model\GebruikerQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\WachtwoordResetQuery;

// Defineer variabelen voor aanmelden
$newPassword = $newPasswordErr = $repeatPassword = $repeatPasswordErr = "";
$previous = "";
$wijzigWachtwoord = false;

$email = "";
$token = "";
$klaar = "";

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );
    sleep( 1 );
    getGetVar( $token );

    if ( isset( $_GET['klaar'] ) )
    {
        $klaar = "Uw wachtwoord is gewijzigd.";
    }
    else
    {
        $logger->debug( "Token: " . $token );
        if ( $token == null )
        {
            $logger->error( "Wachtwoord reset aangeroepen zonder token" );
            die( "Onjuist gebruik" );
            exit;
        }

        $code = new CodeBeheer();

        if ( !$code->check( $token, true ) )
        {
            $klaar = "Dit is geen geldige link.";
//            echo "fout";
            //            exit;
        }
        else
        {
            $logger->debug( "Token is geldig" );

            $token = WachtwoordResetQuery::create()->filterByToken( $token )->findOne();

            if ( $token == null )
            {
                $logger->security( "Onjuist token opgegeven: " . $token . ", IP adres: " . $_SERVER['REMOTE_ADDR'] );
                $klaar = "Dit is geen geldige link.";
                //            exit;
            }
            else
            {
                $ouderdom = tijdVerschil( date( "Y-m-d H:i:s" ), $token->getGeldigTot()->format( "Y-m-d H:i:s" ) );
                if ( $ouderdom < 0 )
                {
                    $klaar = "Deze link is te oud. Vraag a.u.b. opnieuw aan.";
                    //                exit;
                }
                else
                {
                    $logger->debug( "Nog geldig (s) " . $ouderdom );
                    $email = $token->getEmail();
                    //$mail->delete();
                }
            }
        }

    }

} // GET

// DEEL 2
// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // Geen $_POST dumpen, hier staat het wachtwoord in klare tekst in!
    // $logger->dump( $_POST );

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $previous )
            ->go();
        $validateOk += $setVar->name( $email )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $newPassword )
            ->onerror( $newPasswordErr )
            ->noHtmlCleaning()
            ->validator( v::alwaysValid()->length( 1, 255 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $repeatPassword )
            ->onerror( $repeatPasswordErr )
            ->noHtmlCleaning()
            ->validator( v::alwaysValid()->length( 1, 255 ) )
            ->required( false )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( $validateOk == 0 )
    {
        try
        {
            $allOk = false;
            $gebruiker = GebruikerQuery::create()->filterByUserId( $email )->filterByIsActief("1")->findOne();
            if ( $gebruiker != null )
            {
                $allOk = true;
                $date = new DateTime( 'now' );
                $logger->debug( "Wachtwoord wijziging gevraagd" );
                if ( $newPassword != "" && $repeatPassword != "" )
                {
                    if ( $newPassword == $repeatPassword )
                    {
                        $gebruiker->setWachtwoord( password_hash( $newPassword, PASSWORD_BCRYPT ) );
                        $gebruiker->setDatumWachtwoordWijzig( $date->format( 'Y-m-d H:i:s' ) );
                        $gebruiker->save();

                        $persoonId = $gebruiker->getPersoonId();
                        if ( $persoonId != null )
                        {
                            $persoon = PersoonQuery::create()->filterById( $persoonId )->find();
                            if ( $persoon != null )
                            {
                                $logger->verbose( $persoon );
                                $contactPersoonId = $persoonId;
                                $contactlog = new Contactlog;
                                $contactlog->setPersoonId( $contactPersoonId );
                                $contactlog->setTekst( "Wachtwoord door gebruiker gereset (wachtwoord vergeten)." );
                                $contactlog->setGemaaktDoor( $email );
                                $contactlog->save();
                            }
                        }

                        $logger->debug( "Wachtwoord is gewijzigd" );
                        alert( "Uw wachtwoord is gewijzigd." );
                        header( "Location:" . $_SERVER['PHP_SELF'] . "?klaar=1" );
                        exit();

                    }
                    else
                    {
                        $newPasswordErr = "Nieuw wachtwoord en bevestiging komen niet overeen";
                        $repeatPasswordErr = "Nieuw wachtwoord en bevestiging komen niet overeen";
                        $logger->debug( "Nieuw wachtwoord en bevestiging komen niet overeen" );
                        $allOk = false;
                    }
                }
                else
                {
                    $newPasswordErr = "Geen nieuw wachtwoord opgegeven";
                    $logger->debug( "Geen nieuw wachtwoord opgegeven" );
                    $allOk = false;
                }
            }
        }
        catch ( \Exception $e )
        {
            $logger->security( 'Probleem met inloggen' );
            $logger->errordump( $e );
            $validatiemelding = 'Probleem met inloggen.';
            alert( 'Probleem met inloggen. ' . $e->getMessage() );
        }

    }
    else
    {
        $logger->info( "Validatie " . $userid . " niet akkoord, validateOk=" . $validateOk );
    }

} // POST

// DEEL 3
if ( $wijzigWachtwoord )
{
    $wijzigchecked = 'checked="checked"';
}
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'previous', $previous );
$smarty->assign( 'klaar', $klaar );
$smarty->assign( 'email', $email );
$smarty->assign( 'newPassword', $newPassword );
$smarty->assign( 'newPasswordErr', $newPasswordErr );
$smarty->assign( 'repeatPassword', $repeatPassword );
$smarty->assign( 'repeatPasswordErr', $repeatPasswordErr );

$smarty->display( 'wachtwoord_nieuw.tpl' );
