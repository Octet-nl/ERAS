<?php
/**
 * System      Inschrijvingen
 * Module      Login
 * Doel        Aanmelden met userid/password
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-11-2019
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

$doctitle = "Aanmelden";
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

use \fb_model\fb_model\GebruikerQuery;

// Defineer variabelen voor aanmelden
$userid = $useridErr = $password = $passwordErr = $moetWijzigen = "";
$newPassword = $newPasswordErr = $repeatPassword = $repeatPasswordErr = "";
$wijzigchecked = $previous = "";
$wijzigWachtwoord = false;

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    if ( $previous == "" )
    {
        $previous = "javascript:history.go(-1)";
        if ( isset( $_SESSION['referer'] ) )
        {
            $previous = $_SESSION['referer'];
            $logger->debug( "referer=" . $previous );
        }
        $logger->debug( "Previous=" . $previous );
    }
    else
    {
        $logger->debug( "Previous was al gevuld met " . $previous );
    }

    if ( isset( $_GET['uid'] ) )
    {
        $userid = $_GET['uid'];
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
        $validateOk += $setVar->name( $wijzigWachtwoord )
            ->go();
        $validateOk += $setVar->name( $previous )
            ->go();
        $validateOk += $setVar->name( $userid )
            ->onerror( $useridErr )
            ->formatter( 'strtolower' )
            ->validator( v::alnum()->noWhitespace()->length( 1, 64 ) )
        //->validator( v::regex("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/")->length( 1, 64 ) )
        //->validator( v::email()->length( 1, 64 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $password )
            ->onerror( $passwordErr )
            ->noHtmlCleaning()
            ->validator( v::alwaysValid()->length( 1, 255 ) )
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
            // Afremmen wachtwoord raden
            sleep(1);
            $allOk = false;
            $gebruiker = GebruikerQuery::create()->filterByUserId( $userid )->findOne();
            if ( $gebruiker != null )
            {
                if ( password_verify( $password, $gebruiker->getWachtwoord() ) )
                {
                    if ( $gebruiker->getDatumWachtwoordWijzig() == null && !$wijzigWachtwoord )
                    {
                        $logger->debug( "Wachtwoord nog nooit gewijzigd. Dwing nu." );
                        $moetWijzigen = "Dit is de eerste keer dat u aanmeldt.<br/>U moet nu uw wachtwoord wijzigen:<br/><br/>";
                        $wijzigWachtwoord = true;
                        //header( 'refresh:0' );
                    }
                    else
                    {
                        $allOk = true;
                        $date = new DateTime( 'now' );
                        if ( $wijzigWachtwoord )
                        {
                            $logger->debug( "Wachtwoord wijziging gevraagd" );
                            if ( $newPassword != "" && $repeatPassword != "" )
                            {
                                if ( $newPassword == $repeatPassword )
                                {
                                    $gebruiker->setWachtwoord( password_hash( $newPassword, PASSWORD_BCRYPT ) );
                                    $gebruiker->setDatumWachtwoordWijzig( $date->format( 'Y-m-d H:i:s' ) );
                                    $logger->debug( "Wachtwoord is gewijzigd" );
                                    alert( "Uw wachtwoord is gewijzigd." );
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
                        if ( $allOk )
                        {
                            $gebruiker->setDatumLaatsteLogin( $date->format( 'Y-m-d H:i:s' ) );
                            $gebruiker->setLaatsteLoginAdres( $_SERVER['REMOTE_ADDR'] );
                            $gebruiker->save();

                            $systeem = new Sysdb();
//ToDo: Kijken of dit werkt:
                            session_destroy();
                            $sessie = new Sessie();

                            $auth = array();
                            unset( $_SESSION["auth-" . $systeem->getNaam()] );
                            $auth["isLoggedIn"] = true;
                            $auth["gebruikerid"] = $gebruiker->getId();
                            $auth["userid"] = $gebruiker->getUserId();
                            if ( $gebruiker->getUserId() == 'root')
                            {
                                if ( $gebruiker->getRol() != AUTORISATIE_STATUS_ROOT )
                                {
                                    $logger->security( "Beveilingsprobleem, user 'root' heeft verkeerde rol, namelijk " . rolNaam( $gebruiker->getRol() ) );
                                    alert( "Beveilingsprobleem, 'root' heeft een verkeerde rol" );
                                    echo "Beveilingsprobleem, 'root' heeft een verkeerde rol";
                                    exit;
                                }
                            }
                            if ( $gebruiker->getRol() == AUTORISATIE_STATUS_ROOT )
                            {
                                if ( $gebruiker->getUserId() != 'root' )
                                {
                                    $logger->security( "Beveilingsprobleem, Rol 'root' heeft verkeerd userid, namelijk " . $gebruiker->getUserId() );
                                    alert( "Beveilingsprobleem, deze gebruiker heeft een verkeerde rol" );
                                    echo "Beveilingsprobleem, deze gebruiker heeft een verkeerde rol";
                                    exit;
                                }
                            }
                            $auth["rol"] = $gebruiker->getRol();
                            $_SESSION["auth-" . $systeem->getNaam()] = $auth ;

                            $logger->security( "User " . $userid . " met succes ingelogd." );
                            $logger->debug( "Doorzetten naar Location:" . $previous );
                            header( "Location:" . $previous );
                        }
                    }

                }
                else
                {
                    $logger->security( "User " . $userid . " onjuist wachtwoord." );
                    $passwordErr = "Gebruikers ID of wachtwoord is niet correct";
                }
            }
            else
            {
                $logger->info( "User " . $userid . " bestaat niet." );
                $passwordErr = "Gebruikers ID of wachtwoord is niet correct";
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
$logger->debug( "Previous=" . $previous );

if ( $wijzigWachtwoord )
{
    $wijzigchecked = 'checked="checked"';
}
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'previous', $previous );
$smarty->assign( 'userid', $userid );
$smarty->assign( 'useridErr', $useridErr );
$smarty->assign( 'password', $password );
$smarty->assign( 'passwordErr', $passwordErr );
$smarty->assign( 'newPassword', $newPassword );
$smarty->assign( 'moetWijzigen', $moetWijzigen );
$smarty->assign( 'wijzigchecked', $wijzigchecked );
$smarty->assign( 'newPasswordErr', $newPasswordErr );
$smarty->assign( 'repeatPassword', $repeatPassword );
$smarty->assign( 'repeatPasswordErr', $repeatPasswordErr );

$smarty->display( 'login.tpl' );
