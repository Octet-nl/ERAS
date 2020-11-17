<?php
/**
 * System      Inschrijvingen
 * Module      Template
 * Doel        Leeg template bestand
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       08-08-2020
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

$doctitle = "Template";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\GebruikerQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$previous = "";

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{

}


// Na drukken op een van de knoppen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

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
        $setVar->name( $previous )->go();
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

// Alleen de eerste keer de vorige pagina vastleggen.
// Na de POST klopt het niet meer en verwijst hij naar de huidige pagina
if ( $previous == "" )
{
    $previous = "javascript:history.go(-1)";
    if ( isset( $_SERVER['HTTP_REFERER'] ) )
    {
        $previous = $_SERVER['HTTP_REFERER'];
    }
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'previous', $previous );

$smarty->assign( 'naam', "heer A. Nonymus" );
$smarty->assign( 'evenementnaam', "Cursus Pianospelen" );
$smarty->assign( 'evenementbegin', "01-09-2020" );
$smarty->assign( 'evenementeinde', "10-11-2020" );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$tekst = $smarty->fetch( 'test.tpl' );
echo $tekst;
