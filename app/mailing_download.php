<?php
/**
 * System      ERAS
 * Module      Mailing verzenden
 * Doel        Verzend mailing voor een evenement naar mensen op de mailinglist
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       06-10-2020
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

use \fb_model\fb_model\MailinglistQuery;
use \fb_model\fb_model\EvenementQuery;

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$adressen = "";
$mededeling = "";
$inschrijvers = array();

$history = new History();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );

    $history->set();

    if ( isset( $_GET['evt'] ) )
    {
        $evenementId = $_GET['evt'];
        if ( $evenementId > 0 )
        {
            $logger->debug( 'Inschrijvers voor evenement ' . $evenementId );
            $inschrijvers = MailinglistQuery::create()
              ->filterByEvenementId( $evenementId )
              ->find();
        }
        else
        {
            $logger->debug( 'Inschrijvers voor alle evenementen' );
            $inschrijvers = MailinglistQuery::create()
              ->find();
        //    ->paginate(2, 10);
        }
        $aantal = $inschrijvers->count();
        if ($aantal == 0 )
        {
            $mededeling = "Geen inschrijvingen gevonden";
        }
        else
        {
            foreach( $inschrijvers as $inschrijver )
            {
                $evenement = EvenementQuery::create()->findPk( $inschrijver->getEvenementId() );
                $adressen .= $inschrijver->getEmail() . ";" . $inschrijver->getNaam() . ";" . $evenement->getNaam() . "\n";
            }
        }
        $mededeling = "Aantal adressen:" . $aantal;
    }
    else
    {
        $mededeling = "Onjuist gebruik";
    }


}

// DEEL 3
$smarty->assign( 'doctitle', "Download" );
$smarty->assign( 'mededeling', $mededeling );
$smarty->assign( 'adressen', $adressen );
$smarty->display( 'mailing_download.tpl' );
