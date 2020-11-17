<?php
/**
 * System      Inschrijvingen
 * Module      Registreer
 * Doel        Aanmelden of account aanmaken
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       18-01-2020
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

$doctitle = "Inschrijven";
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
use fb_model\fb_model\Contactlog;
use fb_model\fb_model\Gebruiker;
use fb_model\fb_model\GebruikerQuery;
use fb_model\fb_model\System;

// Defineer variabelen voor aanmelden
$mailadres = $wachtwoord = $password = $bevestig = $email = $noregemail ="";
$mailadresErr = $wachtwoordErr = $passwordErr = $bevestigErr = $emailErr = $noregemailErr = "";
$newPassword = $repeatPassword = $newPasswordErr = $repeatPasswordErr = "";
$registerchecked = $loginchecked = $directchecked = $wijzigchecked = $wijzigWachtwoord = "";
$moetWijzigen = false;
$inschrijving = array();
$accountNodig = false;
$evt = "";

$systeem = new Sysdb();

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    if ( isset( $_GET["evt"] ) )
    {
        $evt = $_GET["evt"];
    }

    if ( isset( $_SESSION["inschrijving"] ) )
    {
        $logger->debug( "inschrijving aanwezig in session" );
        $inschrijving = $_SESSION["inschrijving"];

        if ( array_key_exists( "account_nodig", $inschrijving ) )
        {
            $accountNodig = $inschrijving["account_nodig"];
            $logger->debug( "Er is account nodig: " . $accountNodig );
        }
        else
        {
            $logger->debug( "Er is geen account_nodig entry in inschrijving" );
        }
    }

    // Bestaande autorisatie wissen
    unset( $_SESSION["auth-" . $systeem->getNaam()] );

    $registerchecked = 'checked="checked"';
} // GET

// Na drukken op één van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // Geen $_POST dumpen, hier staat het wachtwoord in klare tekst in!
    $logger->dump( $_POST );

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $evt )
            ->go();
        $validateOk += $setVar->name( $account )
            ->go();
        $validateOk += $setVar->name( $mailadres )
            ->go();
        $validateOk += $setVar->name( $accountNodig )
            ->go();
        $validateOk += $setVar->name( $wijzigWachtwoord )
            ->go();            

        if ( isset( $_POST["wijzigEmail"] ) )
        {
            $_SESSION["wijzig_email"] = $mailadres ;
            header( "location:email_wijzigen.php" );
            exit;
        }

        ///////////////////////////////////////////////
        //      Registreren nieuwe gebruiker         //
        ///////////////////////////////////////////////
        if ( $account == "register" )
        {
            $validateOk += $setVar->name( $email )
                ->onerror( $emailErr )
                ->emptymessage( "Vul uw e-mail adres in" )
                ->formatter( 'strtolower' )
                ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            //->validator( v::email()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $password )
                ->onerror( $passwordErr )
                ->emptymessage( "Vul uw wachtwoord in" )
                ->errormessage( "Uw wachtwoord moet minimaal 6 tekens lang zijn" )
                ->noHtmlCleaning()
                ->validator( v::alwaysValid()->length( 6, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $bevestig )
                ->onerror( $bevestigErr )
                ->emptymessage( "Bevestig uw wachtwooord ter controle" )
                ->noHtmlCleaning()
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $registerchecked = 'checked="checked"';

            if ( $validateOk == 0 )
            {
                $allOk = true;

                $logger->debug( "Nieuwe registratie" );
                if ( $password != "" && $bevestig != "" )
                {
                    if ( $password != $bevestig )
                    {
                        $bevestigErr = "Nieuw wachtwoord en bevestiging komen niet overeen";
                        $logger->debug( "Nieuw wachtwoord en bevestiging komen niet overeen" );
                        $allOk = false;
                    }
                }
                else
                {
                    if ( $password == "" )
                    {
                        $passwordErr = "Geen wachtwoord opgegeven";
                        $logger->debug( "Geen wachtwoord opgegeven" );
                    }
                    if ( $bevestig == "" )
                    {
                        $confirmErr = "Geen bevestiging opgegeven";
                        $logger->debug( "Geen wachtwoordbevestiging opgegeven" );
                    }
                    $allOk = false;
                }

                if ( $allOk )
                {
                    $date = new DateTime( 'now' );

                    $gebruiker = GebruikerQuery::create()->filterByUserId( $email )->findOne();
                    if ( $gebruiker != null )
                    {
                        $emailErr = "Dit email adres is reeds in gebruik.<br/>Als dit uw mailadres is, gebruik dan s.v.p. de optie \"Terugkerende klant\" hierboven.<br/>Neem contact met ons op als u uw wachtwoord vergeten bent.";
                    }
                    else
                    {
                        $gebruiker = new Gebruiker;
                        $gebruiker->setUserId( $email );
                        $gebruiker->setWachtwoord( password_hash( $password, PASSWORD_BCRYPT ) );
                        $gebruiker->setRol( AUTORISATIE_STATUS_KLANT );
                        $gebruiker->setDatumWachtwoordWijzig( $date->format( 'Y-m-d H:i:s' ) );
                        $gebruiker->setGewijzigdDoor( $email );
                        $gebruiker->setGemaaktDoor( $email );
                        $gebruiker->setDatumLaatsteLogin( $date->format( 'Y-m-d H:i:s' ) );
                        $gebruiker->setLaatsteLoginAdres( $_SERVER['REMOTE_ADDR'] );
                        $gebruiker->save();

                        $auth = array();
                        unset( $_SESSION["auth-" . $systeem->getNaam()] );
                        $auth["isLoggedIn"] = true;
                        $auth["gebruikerid"] = $gebruiker->getId();
                        $auth["userid"] = $gebruiker->getUserId();
                        $auth["rol"] = $gebruiker->getRol();
                        $_SESSION["auth-" . $systeem->getNaam()] = $auth ;

                        // Naar inschrijving opvoeren, met email adres
                        header( "Location:inschrijving_contactpersoon.php?evt=" . $evt . "&email=" . $email );
                        exit;
                    }
                }
            }
        }
        ///////////////////////////////////////////////
        //      Inschrijven zonder account           //
        ///////////////////////////////////////////////
        elseif ( $account == "zonder" )
        {
            $directchecked = 'checked="checked"';
            $date = new DateTime( 'now' );

            $validateOk = $setVar->name( $noregemail )
                ->onerror( $noregemailErr )
                ->emptymessage( "Vul uw e-mail adres in" )
                ->formatter( 'strtolower' )
                ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            //->validator( v::email()->length( 1, 255 ) )
                ->required( true )
                ->go();

            if ( $validateOk == 0 )
            {
                $logger->debug( "Validate OK" );
                $gebruiker = GebruikerQuery::create()->filterByUserId( $noregemail )->findOne();
                if ( $gebruiker != null )
                {
                    $logger->debug( "Mailadres is in gebruik" );
                    $noregemailErr = "Dit email adres is reeds in gebruik.<br/>Als dit uw mailadres is, gebruik dan s.v.p. de optie \"Terugkerende klant\" hierboven.<br/>Neem contact met ons op als u uw wachtwoord vergeten bent.";
                }
                else
                {
            //         $logger->debug( "Nieuwe gebruiker" );
            //         $gebruiker = new Gebruiker;
            //         $gebruiker->setUserId( $noregemail );
            //         $gebruiker->setWachtwoord( "" );
            //         $gebruiker->setRol( AUTORISATIE_STATUS_KLANT );
            //         $gebruiker->setDatumWachtwoordWijzig( "00-00-0000" );
            //         $gebruiker->setGewijzigdDoor( $noregemail );
            //         $gebruiker->setGemaaktDoor( $noregemail );
            //         $gebruiker->setDatumLaatsteLogin( "00-00-0000" );
            //         $gebruiker->setLaatsteLoginAdres( "" );
            //         $gebruiker->save();
    
                    $auth = array();
                    unset( $_SESSION["auth-" . $systeem->getNaam()] );
                    $auth["isLoggedIn"] = true;
                    $auth["gebruikerid"] = 0;
                    $auth["userid"] = "";
                    $auth["rol"] = AUTORISATIE_STATUS_KLANT;
                    $_SESSION["auth-" . $systeem->getNaam()] = $auth ;
        
                    // Naar inschrijving opvoeren, met email adres
                    header( "Location:inschrijving_contactpersoon.php?evt=" . $evt . "&email=" . $noregemail );
                    exit;
                }
            }
        }
        ///////////////////////////////////////////////////////////////
        //      Inloggen bestaande klant, nieuw wachtwoord           //
        ///////////////////////////////////////////////////////////////
        elseif ( $account == "login" )
        {
            $validateOk += $setVar->name( $mailadres )
                ->onerror( $mailadresErr )
                ->emptymessage( "Vul uw e-mail adres in" )
                ->formatter( 'strtolower' )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $wachtwoord )
                ->onerror( $wachtwoordErr )
                ->emptymessage( "Vul uw wachtwoord in" )
                ->errormessage( "Uw wachtwoord moet minimaal 6 tekens lang zijn" )
                ->noHtmlCleaning()
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $newPassword )
                ->onerror( $newPasswordErr )
                ->errormessage( "Uw wachtwoord moet minimaal 6 tekens lang zijn" )
                ->noHtmlCleaning()
                ->validator( v::alwaysValid()->length( 6, 255 ) )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $repeatPassword )
                ->onerror( $repeatPasswordErr )
                ->noHtmlCleaning()
                ->validator( v::alwaysValid()->length( 6, 255 ) )
                ->required( false )
                ->go();

            $allOk = false;

            $loginchecked = 'checked="checked"';

            if ( $validateOk == 0 )
            {
                $gebruiker = GebruikerQuery::create()->filterByUserId( $mailadres )->findOne();
                $logger->verbose( $gebruiker );
                if ( $gebruiker != null )
                {
                    if ( password_verify( $wachtwoord, $gebruiker->getWachtwoord() ) )
                    {
                        $allOk = true;
                        if ( $gebruiker->getRol() > AUTORISATIE_STATUS_KLANT )
                        {
                            $logger->warning( "User " . $mailadres . " kan niet aanmelden want is niet geregistreerd als klant, rol = " . $gebruiker->getRol() );
                            alertAndGo('U staat niet als klant geregistreerd maar als medewerker.\n U wordt doorgezet naar de backoffice pagina', 'index.php');
                            exit;
                        }

                        if ( $gebruiker->getDatumWachtwoordWijzig() == null && !$wijzigWachtwoord )
                        {
                            $logger->debug( "Wachtwoord nog nooit gewijzigd. Dwing nu." );
                            $moetWijzigen = "<br/>U heeft van ons een (nieuw) wachtwoord gekregen.<br/>U moet nu dit wachtwoord wijzigen:<br/><br/>";
                            $wijzigWachtwoord = true;
                            // header( 'refresh:0' );
                        }

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
                                    $confirmErr = "Nieuw wachtwoord en bevestiging komen niet overeen";
                                    $repeatPasswordErr = "Nieuw wachtwoord en bevestiging komen niet overeen";
                                    $logger->debug( "Nieuw wachtwoord en bevestiging komen niet overeen" );
                                    $allOk = false;
                                }
                            }
                            else
                            {
                                if ( $newPassword == "" )
                                {
                                    $newPasswordErr = "Geen nieuw wachtwoord opgegeven";
                                    $logger->debug( "Geen nieuw wachtwoord opgegeven" );
                                }
                                if ( $repeatPassword == "" )
                                {
                                    $repeatPasswordErr = "Geen nieuw wachtwoord opgegeven";
                                    $logger->debug( "Geen bevestiging nieuw wachtwoord opgegeven" );
                                }
                                $allOk = false;
                            }
                        }
                        if ( $allOk )
                        {
                            $gebruiker->setDatumLaatsteLogin( $date->format( 'Y-m-d H:i:s' ) );
                            $gebruiker->setLaatsteLoginAdres( $_SERVER['REMOTE_ADDR'] );
                            $gebruiker->save();

                            $auth = array();
                            unset( $_SESSION["auth-" . $systeem->getNaam()] );
                            $auth["isLoggedIn"] = true;
                            $auth["gebruikerid"] = $gebruiker->getId();
                            $auth["userid"] = $mailadres;
                            $auth["rol"] = $gebruiker->getRol();
                            $_SESSION["auth-" . $systeem->getNaam()] = $auth ;

                            $logger->info( "User " . $mailadres . " met succes ingelogd." );
                            $logger->debug( "Doorzetten naar inschrijving kiezen" );
                            header( "Location:inschrijving_kiezen.php?evt=" . $evt );
                            exit;
                        }

                    }
                    else
                    {
                        $logger->security( "User " . $mailadres . " onjuist wachtwoord. " . $_SERVER['REMOTE_ADDR'] );
                        $wachtwoordErr = "Gebruikers ID of wachtwoord is niet correct";
                    }
                }
                else
                {
                    $logger->security( "User " . $mailadres . " bestaat niet. " . $_SERVER['REMOTE_ADDR'] );
                    $wachtwoordErr = "Gebruikers ID of wachtwoord is niet correct";
                }
            }
        }
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in registreren klant" );
        echo "Er is iets misgegaan.";
        $logger->errordump( $ex );
        $validateOk = 999;
    }

} // POST

if ( $wijzigWachtwoord )
{
    $wijzigchecked = 'checked="checked"';
}

$wachtwoordvergeten = "Vermeld uw naam, het email adres waaronder u bij ons staat ingeschreven. We sturen u zo snel mogelijk een nieuw wachtwoord.%0D%0A%0D%0ANaam:%0D%0AEmail adres:%0D%0AGeboortedatum:%0D%0A";

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'infomail', $systeem->getOrganisatieMail() );
$smarty->assign( 'wachtwoordvergeten', $wachtwoordvergeten );
$smarty->assign( 'mailadres', $mailadres );
$smarty->assign( 'mailadresErr', $mailadresErr );
$smarty->assign( 'noregemail', $noregemail );
$smarty->assign( 'noregemailErr', $noregemailErr );
$smarty->assign( 'email', $email );
$smarty->assign( 'emailErr', $emailErr );
$smarty->assign( 'wachtwoord', $wachtwoord );
$smarty->assign( 'wachtwoordErr', $wachtwoordErr );
$smarty->assign( 'password', $password );
$smarty->assign( 'passwordErr', $passwordErr );
$smarty->assign( 'bevestig', $bevestig );
$smarty->assign( 'bevestigErr', $bevestigErr );

$smarty->assign( 'newPassword', $newPassword );
$smarty->assign( 'newPasswordErr', $newPasswordErr );
$smarty->assign( 'repeatPassword', $repeatPassword );
$smarty->assign( 'repeatPasswordErr', $repeatPasswordErr );

$smarty->assign( 'registerchecked', $registerchecked );
$smarty->assign( 'directchecked', $directchecked );
$smarty->assign( 'loginchecked', $loginchecked );
$smarty->assign( 'wijzigWachtwoord', $wijzigWachtwoord );
$smarty->assign( 'moetWijzigen', $moetWijzigen );
$smarty->assign( 'wijzigchecked', $wijzigchecked );
$smarty->assign( 'accountNodig', $accountNodig );

$smarty->display( 'registreer.tpl' );
