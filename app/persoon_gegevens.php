<?php
/**
 * System      Inschrijvingen
 * Module      Persoon aanpassen
 * Doel        Persoonsgegevens wijzigen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       13-01-2020
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
require_once 'persoonsgegevens_class.php';

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/
use fb_model\fb_model\VoucherQuery;
use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\EvenementQuery;
use fb_model\fb_model\ContactlogQuery;
use fb_model\fb_model\Contactlog;

use Respect\Validation\Validator as v;

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Klantgegevens";

// define variables and set to empty values
require_once 'persoon_define_variables.inc';

$validatiemelding = "";
$all = 0;
$persoon = $id = null;
$readonly = null;
$sessieVariabelen = array();
$wijzigen = false;

$voucher = null;

//$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;
$evt = 0;
$extraContact = 0;

$nieuweLog = $nieuweLogErr = "";

$logger->debug( $doctitle );

$logTekst = "";
$statusRegel = "";
$signalError = false;
$invers = 0;

$inschrijving_lijst = array();
$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

$persoonsGegevens = new Persoonsgegevens( $autorisatie->getUserId() );

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?prs= parameter,
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $history->set();

    getGetVar($nieuweLog);
    getGetVar($nieuweLogErr);

    if ( isset( $_GET['invers'] ) )
    {
        $invers = $_GET['invers'];
    }

    if ( isset( $_GET['prs'] ) )
    {
        $id = $_GET['prs'];

        if ( $id != null )
        {
            $persoonsGegevens->load( $id );

            if ( $persoonsGegevens->getEmail() != "" )
            {
                $voucher = VoucherQuery::create()->
                           filterByEmail( $persoonsGegevens->getEmail() )->
                           filterByIsActief( 1 )->
                           findOne();
            }

            $inschrijvingen = InschrijvingQuery::create()->filterByContactPersoonId( $id );
            foreach ( $inschrijvingen as $inschrijving )
            {
                $ins_item = array();
                $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                if ( $evenement == null )
                {
                    $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                }
                else
                {
                    $ins_item["inschrijfnr"] = $inschrijving->getId();
                    $ins_item["evenement"] = $evenement->getNaam();
                }
    
                array_push( $inschrijving_lijst, $ins_item );
            }

            if ( $invers == 1 )
            {
                $logRegels = ContactlogQuery::create()->
                filterByPersoonId( $id )->
                orderByDatumGemaakt()->
                find();
            }
            else
            {
                $logRegels = ContactlogQuery::create()->
                filterByPersoonId( $id )->
                orderByDatumGemaakt('desc')->
                find();
            }


            foreach( $logRegels as $logRegel )
            {
                $logTekst .= '<span class="fixed_grijs">' . $logRegel->getDatumGemaakt()->format( 'd-m-Y H:i:s' ) . " " . $logRegel->getGemaaktDoor() . "<br/>" . '</span>' .
                             str_replace( array('\n', '€'), array('<br/>', '&euro;'), $logRegel->getTekst()) . "<br/>";
            }
        }
    }
    else
    {
        $logger->debug( "Geen prs in url. Terug naar index" );
        alert( 'Geen persoonsID opgegeven' );
        header( "Location:index.php" );
        exit();
    }
}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $id )
            ->go();
        $validateOk += $setVar->name( $nieuweLog )
            ->onerror( $nieuweLogErr )
            ->validator( v::alwaysValid()->length( 0, 20000 ) )
            ->required( false )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['invers'] ) )
    {
        header( "location:persoon_gegevens.php?prs=" .$id . "&invers=1");
        exit;
    }
    if ( isset( $_POST['gewoon'] ) )
    {
        header( "location:persoon_gegevens.php?prs=" .$id );
        exit;
    }

    if ( $validateOk == 0 )
    {
        if ( isset( $_POST['toevoegen'] ) )
        {
            if ( $nieuweLog != "" )
            {
                $contactlog = new Contactlog;
                $contactlog->setPersoonId( $id );
                $contactlog->setTekst( $nieuweLog );
                $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
                $contactlog->save();
            }
        }
        header( "location:persoon_gegevens.php?prs=" .$id );
        exit;
    }
    else
    {
        header( "location:persoon_gegevens.php?prs=" .$id . "&nieuweLogErr=" .$nieuweLogErr . "&nieuweLog=" . $nieuweLog );
        exit;
    }
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

// Deze zijn voor persoon_template
if ( $id == null )
{
    $id_visibility = "hide";
}
else
{
    $id_visibility = "show";
}

require_once 'persoon_template.php';

$smarty->assign( 'id', $id );
$smarty->assign( 'all', $all );
$smarty->assign( 'wijzigen', $wijzigen );

$ini = parse_ini_file( CONFIG_FILENAME, true );
$imageDirectory = $ini['settings']['image_directory'] . '/';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'imageDirectory', $imageDirectory );

$vcode = "";
$vid = 0;
if ( $voucher != null )
{
    $vcode = $voucher->getCode();
    $vid = $voucher->getId();
}
$smarty->assign( 'voucherCode', $vcode );
$smarty->assign( 'voucherId', $vid );

$smarty->assign( 'inschrijving_lijst', $inschrijving_lijst );
$smarty->assign( 'logTekst', $logTekst );
$smarty->assign( 'nieuweLog', $nieuweLog );
$smarty->assign( 'nieuweLogErr', $nieuweLogErr );
$smarty->assign( 'invers', $invers );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'persoon_gegevens.tpl' );
