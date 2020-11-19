<?php
/**
 * System      ERAS
 * Module      iDeal betaling afhandelen
 * Doel        Terugmelding dat iDeal betaald is (Mollie payments)
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       30-06-2020
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

$doctitle = "Ideal betaald";

use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\Contactlog;

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

    $order_id = 0;
    $order_code = 0;
    try
    {
        getGetVarEx( $order_id );
        getGetVarEx( $order_code );
        
        $inschrijving = InschrijvingQuery::create()->findPk( $order_id );
        $betaald = $inschrijving->getTotaalbedrag();
        $teBetalen = $inschrijving->getReedsBetaald();
        $inschrijving->setReedsBetaald( $teBetalen + $betaald );
        $inschrijving->setNogTeBetalen( "0.00" );
        $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
        $inschrijving->save();

        $logger->info( "Inschrijving nummer " . $order_id . " is betaald per iDeal, bedrag= " . $betaald . ", ordercode=" . $order_code );
        
        $contactlog = new Contactlog;
        $contactlog->setPersoonId( $inschrijving->getContactpersoonId() );
        $contactlog->setTekst( "Inschrijving nummer " . $order_id . " is betaald per iDeal, bedrag= " . geld($betaald) . ", ordercode=" . $order_code );
        $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
        $contactlog->save();

        $ini = parse_ini_file( CONFIG_FILENAME, true );

        $logger->dump( $ini );
    
        //fout.php?order_id=20004&order_code=0ccPlbfzTEkuzoibMWjCEIdhMtyFqtqs
        $smarty->assign( 'url_success', $ini["ideal_payment"]["status_success"] );
    
        $smarty->display( 'ideal_betaald.tpl' );
    
    }
    catch (Exception $ex )
    {
        echo "Fout bij terugmelden iDeal betaling";

        $logger->error( "Fout bij terugmelden iDeal betaling:" );
        $logger->errordump( $ex );
    }


}

