<?php
/**
 * System      ERAS
 * Module      Mailing afmelden
 * Doel        Unsubscribe van mailinglist
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

use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\MailinglistQuery;
use Respect\Validation\Validator as v;

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

$doctitle = "Afmelden";

// define variables and set to empty values
$bevestig = "";
$evenementnaam = "";
$mailadres = "";
$code = "";
$vraagEmail = "0";

$logger->debug( $doctitle );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );

    $logger->debug( "Opvragen informatie over evenement" );
    if ( isset( $_GET['mail'] ) )
    {
        $mailadres = $_GET['mail'];
        $logger->debug( "Mail: " . $mailadres );

        if ( isset( $_GET['code'] ) )
        {
            $code = $_GET['code'];
            $logger->debug( "ID: " . $code );
    
            $mailing = MailinglistQuery::create()
                ->filterByEmail( $mailadres )
                ->filterByCode( $code )
                ->findOne();

            $logger->dump( $mailing );
            if ( $mailing == null )
            {
                $bevestig = "U bent niet ingeschreven op deze mailinglist.";
            }
            else
            {
                $evenement = EvenementQuery::create()->findPk( $mailing->getEvenementId() );
                $evenementnaam = $evenement->getNaam();
                $mailing->delete();
                if ( $evenement == null )
                {
                    $bevestig = "Uw bent niet ingeschreven in deze mailinglist.";
                }
                else
                {
                    $bevestig = "Uw mailadres " . $mailadres . " is uitgeschreven uit de mailinglist voor evenement " . $evenementnaam;
                }
            }
        }
        else
        {
            $bevestig = "Onjuiste link.";
            $logger->info( "Geen code in url. Terug naar evenementenlijst" );
        }
    }
    else
    {
        $vraagEmail = "1";
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    $validateOk = 0;

    if ( isset( $_POST["afmelden"] ) )
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $email )
            ->onerror( $emailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            ->required( true )
            ->go();
    }

    $mailings = MailinglistQuery::create()
        ->filterByEmail( $email )
        ->find();

    $logger->dump( $mailings );

    $bevestig = "U bent niet ingeschreven op deze mailinglist";
    $events = "";
    foreach( $mailings as $mailing )
    {
        $evenement = EvenementQuery::create()->findPk( $mailing->getEvenementId() );
        $evenementnaam = $evenement->getNaam();
        $mailing->delete();
        $events .= $evenementnaam . "<br/>";
    }
    if ( $events != "" )
    {
        $bevestig = "U bent afgemeld voor mails voor de volgende evenementen:<br/>" . $events;
    }

}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'mail', $mailadres );
$smarty->assign( 'evenementnaam', $evenementnaam );
$smarty->assign( 'bevestig', $bevestig );
$smarty->assign( 'vraagEmail', $vraagEmail );

$smarty->display( 'mailing_afmelden.tpl' );
