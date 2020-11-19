<?php
/**
 * System      ERAS
 * Module      iDeal betaling
 * Doel        Afronden betaling via iDeal (Mollie payments)
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-04-2020
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

require_once 'constanten.php';
require_once 'utilities.php';

$doctitle = "Ideal betaling";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$totaalbedrag = 0;
$evenementnaam = "";
$inschrijfnummer = 0;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

// DEEL 1
// Opbouwen deelnemerlijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    
    $ini = parse_ini_file( CONFIG_FILENAME, true );

    $logger->dump( $ini );

    getGetVar( $totaalbedrag );
    getGetVar( $evenementnaam );
    getGetVar( $inschrijfnummer );

    $smarty->assign( 'bedrag', $totaalbedrag );
    $smarty->assign( 'evenementnaam', $evenementnaam );
    $smarty->assign( 'inschrijfnummer', $inschrijfnummer );
    
    $smarty->assign( 'checkout_script', $ini["ideal_payment"]["checkout_script"] );

    //fout.php?order_id=20004&order_code=0ccPlbfzTEkuzoibMWjCEIdhMtyFqtqs
    $smarty->assign( 'url_payment', $ini["ideal_payment"]["status_stopped"] );
    $smarty->assign( 'url_success', $ini["ideal_payment"]["status_success"] );
    $smarty->assign( 'url_failure', $ini["ideal_payment"]["status_failure"] );
    $smarty->assign( 'url_pending', $ini["ideal_payment"]["status_pending"] );

    $logger->debug( "Doorzetten naar iDeal checkout" );

    $smarty->display( 'idealbetaling.tpl' );
}

