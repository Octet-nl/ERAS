<?php
/**
 * System      Inschrijvingen
 * Module      Autorisaties
 * Doel        Beheren van autorisaties (gebruikers en rollen)
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
use \fb_model\fb_model\Gebruiker;
use \fb_model\fb_model\KeuzesQuery;

// Defineer variabelen voor aanmelden
$userid = $useridErr = $password = $passwordErr = $rolErr = "";
$rol = 0;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// De GET method wordt hier niet gebruikt.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set();
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // HIER GEEN $_POST dumpen, daar staat het wachtwoord in!
    //$logger->dump( $_POST );

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

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
        $validateOk += $setVar->name( $userid )
            ->onerror( $useridErr )
            ->formatter( 'strtolower' )
            ->validator( v::alnum()->noWhitespace()->length( 1, 32 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $password )
            ->onerror( $passwordErr )
            ->errormessage( "Het wachtwoord moet minimaal 6 tekens lang zijn" )
            ->validator( v::alwaysValid()->length( 6, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $rol )
            ->validator( v::alwaysValid() )
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
            $gebruiker = new Gebruiker();
            $gebruiker->setUserId( $userid );
            $gebruiker->setWachtwoord( password_hash( $password, PASSWORD_BCRYPT ) );
            $gebruiker->setRol( $rol );
            $gebruiker->setLaatsteLoginAdres( "" );
            $gebruiker->setDatumLaatsteLogin( null );
            $gebruiker->setGemaaktDoor( $autorisatie->getUserId() );
            $gebruiker->setGewijzigdDoor( $autorisatie->getUserId() );
            $gebruiker->save();
            $statusRegel = "Gebruiker " . $userid . " is opgevoerd";
            alert( "Gebruiker " . $userid . " is opgevoerd" );
            header( "Refresh:0" );
            exit;
        }
        catch ( Exception $ex )
        {
            $logger->error( $ex->getMessage() );
            $logger->error( $ex->getPrevious() );
            if ( strpos( $ex->getPrevious(), '1062 Duplicate entry' ) !== false )
            {
                $statusRegel = 'Gebruiker "' . $userid . '" bestaat al.';
                alert( 'Gebruiker "' . $userid . '" bestaat al.' );
            }
            else
            {
                $statusRegel = "Zie de foutlog voor meer informatie.";
                alert( 'Onbekende fout bij opvoeren gebruiker.' );
                $logger->errordump( $ex );
            }
        }
    }
    else
    {
        $statusRegel = "Gebruiker is niet opgevoerd. Herstel de invoer a.u.b.";
    }
}

// Deel 3

$rolArray = array();
if ( $rolArray == null )
{
    $rollen = KeuzesQuery::create()
      ->filterByKeuzeType( KEUZETYPE_AUTORISATIE )
      ->filterByIsActief( "1" )
      ->find();
    foreach ( $rollen as $dbstatus )
    {
        // Alleen rollen kleiner dan of gelijk aan de aanvrager.
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
$smarty->assign( 'rol', $rol );
$smarty->assign( 'rolErr', $rolErr );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'gebruiker_opvoeren.tpl' );
