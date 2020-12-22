<?php
/**
 * System      ERAS
 * Module      Template
 * Doel        Leeg template bestand
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       17-03-2020
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

$doctitle = "Template";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set( );

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
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $statusRegel = "Er is iets mis gegaan..";
        $signalError = true;
        $validateOk = 999;
    }




}

// Deel 3, wordt altijd uitgevoerd.

$smarty->assign( 'doctitle', $doctitle );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'template.tpl' );
