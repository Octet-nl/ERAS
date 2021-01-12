<?php
/**
 * System      ERAS
 * Module      Autorisaties
 * Doel        Gebruiker autorisatie wijzigen (wachtwoord en rol)
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       11-02-2020
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

$sessie = new Sessie();

$doctitle = "Gebruikers";
$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/
use Respect\Validation\Validator as v;

use \fb_model\fb_model\GebruikerQuery;
use \fb_model\fb_model\KeuzesQuery;

// Defineer variabelen voor aanmelden
$userid = $useridErr = $password = $passwordErr = $rolErr = $actiefErr = "";
$rol = $actief = 0;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

$id = 0;

// DEEL 1
// De GET method wordt hier niet gebruikt.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set();
    getGetVar( $id );

    if ( $autorisatie->getRol() > AUTORISATIE_STATUS_MEDEWERKER )
    {
        $gebruiker = GebruikerQuery::create()->findPk( $id );
    }
    else
    {
        $gebruiker = GebruikerQuery::create()->filterByIsActief("1")->findPk( $id );
    }
    if ( $gebruiker != null )
    {
        if ( $gebruiker->getUserId() == 'root' )
        {
            $logger->security( "Poging om user 'root' te wijzigen door gebruiker '" . $autorisatie->getUserId() . "'");
            alert( "Dit gebruiker-ID kan niet gewijzigd worden. Uw poging is gelogd." );
            echo "Dit gebruiker-ID kan niet gewijzigd worden. Uw poging is gelogd";
            exit;
        }
        $rol = $gebruiker->getRol();
        $userid = $gebruiker->getUserId();
        $actief = $gebruiker->getIsActief();
    }
    else
    {
        alert( "Gebruiker " . $id . " is niet gevonden." );
    }
}

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // HIER GEEN $_POST dumpen, daar staat het wachtwoord in!
    //$logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
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

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
        $setVar->name( $id )
            ->onerror( $statusRegel )
            ->required( true )
            ->go();

        $validateOk += $setVar->name( $userid )
            ->onerror( $useridErr )
            ->formatter( 'strtolower' )
            ->validator( v::alwaysValid() )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $password )
            ->onerror( $passwordErr )
            ->errormessage( "Het wachtwoord moet minimaal 6 tekens lang zijn" )
            ->validator( v::alwaysValid()->length( 6, 255 ) )
            ->noHtmlCleaning()
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $rol )
            ->validator( v::alwaysValid() )
            ->go();
        $validateOk += $setVar->name( $actief )
            ->onerror( $actiefErr )
            ->validator( v::alwaysValid() )
            ->required( true )
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
            $gebruiker = GebruikerQuery::create()->findPk( $id );

            // $gebruiker->setUserId( $userid );
            if ( $password != "" )
            {
                $logger->debug("Password reset");
                $gebruiker->setWachtwoord( password_hash( $password, PASSWORD_BCRYPT ) );
                $gebruiker->setDatumWachtwoordWijzig( null );
            }
            $gebruiker->setRol( $rol );
            $gebruiker->setIsActief( $actief );
            $gebruiker->setLaatsteLoginAdres( "" );
            $gebruiker->setGewijzigdDoor( $autorisatie->getUserId() );
            $gebruiker->save();
        }
        catch ( Exception $ex )
        {
            $logger->error( $ex->getMessage() );
            $logger->error( $ex->getPrevious() );
            alert( 'Onbekende fout bij wijzigen gebruiker.' );
            $logger->dump( $ex );
        }
    }
    else
    {
        $statusRegel = "Herstel de invoer a.u.b";
        $signalError = true;
    }
    $terug =  $history->get( );
    $logger->debug( "History get: " . $terug );
    header( "Location:" . $terug );
    exit;
}

// Deel 3

$rolArray = array();
if ( $rolArray == null )
{
    $rollen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_AUTORISATIE )->filterByIsActief( "1" )->find();
    foreach ( $rollen as $dbstatus )
    {
        if ( $dbstatus->getCode() <= $autorisatie->getRol() )
        {
            $rolArray[$dbstatus->getCode()] = $dbstatus->getNaam();
        }
    }
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'userid', $userid );
$smarty->assign( 'useridErr', $useridErr );
$smarty->assign( 'password', $password );
$smarty->assign( 'passwordErr', $passwordErr );
$smarty->assign( 'rollijst', $rolArray );
$smarty->assign( 'id', $id );
$smarty->assign( 'rol', $rol );
$smarty->assign( 'rolErr', $rolErr );
$smarty->assign( 'ROL_KLANT', AUTORISATIE_STATUS_KLANT );

$smarty->assign( 'actiefKeus', array(
    "1" => OPTIE_KEUZE_JA,
    "0" => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isActief', $actief );
$smarty->assign( 'isActiefErr', $actiefErr );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'gebruiker_wijzigen.tpl' );
