<?php
/**
 * System      ERAS
 * Module      Secretariaat maak voucher
 * Doel        Aanmaken van een nieuwe voucher
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       23-06-2020
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

$doctitle = "Voucher aanmaken";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use fb_model\fb_model\Base\VoucherQuery;
use fb_model\fb_model\KeuzesQuery;
use fb_model\fb_model\Voucher;
use fb_model\fb_model\EvenementQuery;
use Respect\Validation\Validator as v;

// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenement_lijst = array();

$voucherCode = "";
$email = "";
$emailErr = "";
$geldigTot = date( 'd-m-Y', strtotime( '+2 years' ) );
$geldigTotErr = "";
$type = 0;
$typeErr = "";
$isActief = OPTIE_KEUZE_JA;
$isActiefErr = "";
$waarde = "";
$waardeErr = "";
$evenementId = null;
$evenementIdErr = "";

$evenement_lijst = array();

$statusRegel = "";
$signalError = false;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

function vulEvenementenLijst($evenement_lijst)
{
    // Opnieuw vullen evenementenlijst
    $evenementen = EvenementQuery::create()
    ->filterByStatus( EVENEMENT_STATUS_OPEN )
    ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
    ->find();

    $evenement_lijst["0"] = "Alle";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }
    return $evenement_lijst;
}


// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $history->set();

    require_once "voucherbeheer_class.php";
    $voucher = new VoucherBeheer();
    $voucherCode = $voucher->genereerUniekeCode();

    $evenement_lijst = vulEvenementenLijst( $evenement_lijst );
}

// Deel 2
// Na drukken op de "inschrijven" knop
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

    $validateOk = 0;
    try
    {
        $email = null;
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $type )
            ->onerror( $typeErr )
            ->validator( v::intVal()->min( 0 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $waarde )
            ->onerror( $waardeErr )
            ->formatter( 'prijs' )
            ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" )->min( 1 ) )
            ->emptymessage( "Vul a.u.b een bedrag in van minimaal 1 euro." )
            ->errormessage( "Bedrag in euros.centen, minimaal 1 euro." )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $isActief )
            ->onerror( $isActiefErr )
            ->required( true )
            ->go();
        if ( $type == VOUCHERTYPE_VOUCHER )
        {
            $logger->debug( "Type is Voucher." );
            $validateOk += $setVar->name( $email )
                ->onerror( $emailErr )
                ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
                ->emptymessage( "Bij tegoedbonnen/vouchers moet een email adres worden ingevuld." )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $evenementId )
                ->onerror( $evenementIdErr )
                ->errormessage( "Bij tegoedbonnen geen evenement ID opgeven." )
//                ->validator( v::nullType() )
                ->required( false )
                ->go();
        }
        else
        {
            $logger->debug( "Type is Kortingsbon." );
            $validateOk += $setVar->name( $email )
                ->onerror( $emailErr )
                ->errormessage( "Bij kortingsbonnen geen email adres opgeven." )
                ->validator( v::nullType() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $evenementId )
                ->onerror( $evenementIdErr )
                ->required( true )
                ->go();
        }
        $validateOk += $setVar->name( $geldigTot )
            ->onerror( $geldigTotErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Datum: dd-mm-yyyy" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $voucherCode )
            ->required( true )
            ->go();

        if ( $validateOk == 0 )
        {
            if ( isset( $_POST['opslaan'] ) )
            {
                $logger->debug( "Opslaan voucher." );

                $voucher = null;
                if ( $type == VOUCHERTYPE_VOUCHER )
                {
                    $voucher = VoucherQuery::create()->filterByEmail( $email )->filterByIsActief("1")->findOne();
                    if ( $voucher != null )
                    {
                        $statusRegel = 'Er bestaat al een actieve voucher voor emailadres "' . $email;
                        alert( 'Er bestaat al een actieve voucher voor emailadres "' . $email );
                        $logger->debug( 'Er bestaat al een actieve voucher voor emailadres "' . $email );
                        $signalError = true;
                        $validateOk = 999;
                    }
                }

                if ( $validateOk == 0 )
                {
                    $dbVoucher = new Voucher();
                    $dbVoucher->setCode( $voucherCode );
                    $dbVoucher->setRestWaarde( $waarde );
                    $dbVoucher->setOorspronkelijkeWaarde( $waarde );
                    $dbVoucher->setVerbruikt( "0.00" );
                    $dbVoucher->setEmail( $email );
                    if ( $evenementId != 0 )
                    {
                        $logger->debug( 'EvenementId niet 0 maar ' . $evenementId );
                        $dbVoucher->setEvenementId( $evenementId );
                    }
                    else
                    {
                        $logger->debug( 'EvenementId is null' );
                        $dbVoucher->setEvenementId( null );
                    }
                    $dbVoucher->setVoucherType( $type );
                    $dbVoucher->setIsActief( vanJaNee( $isActief ) );
                    $dbVoucher->setGeldigTot( $geldigTot );
                    $dbVoucher->setGemaaktDoor( $autorisatie->getUserId() );
                    $dbVoucher->setGewijzigdDoor( $autorisatie->getUserId() );
                    $dbVoucher->save();

                    $logger->debug( "Voucher opgeslagen" );

                    //$terug =  $history->get( );
                    //$logger->debug( "Terug naar: " . $terug );
                    //header( "Location:" . $terug );
                    alert( "Voucher " . $voucherCode . " is opgeslagen." );
                    header( "refresh:0" );
                    exit;
                }
                else
                {
                    $evenement_lijst = vulEvenementenLijst( $evenement_lijst );
                }
            }
        }
        else
        {
            $evenement_lijst = vulEvenementenLijst( $evenement_lijst );
        }
}
    catch ( Exception $ex )
    {
        if ( strpos( $ex->getPrevious(), '1062 Duplicate entry' ) !== false )
        {
            $statusRegel = 'Er bestaat al een voucher voor emailadres "' . $email;
            alert( 'Er bestaat al een voucher voor emailadres "' . $email );
            $logger->debug( 'Er bestaat al een voucher voor emailadres "' . $email );
        }
        else
        {
            $statusRegel = "Onbekende fout. Zie de foutlog voor meer informatie.";
            alert( 'Onbekende fout bij opvoeren voucher.' );
            $logger->errordump( $ex );
        }
        $signalError = true;

        $evenement_lijst = vulEvenementenLijst( $evenement_lijst );
    }
}

// Deel 3
$typenLijst = array();
if ( $typenLijst == null )
{
    $typen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_VOUCHER )->filterByIsActief( "1" )->find();
    foreach ( $typen as $type )
    {
        $typenLijst[$type->getCode()] = $type->getNaam();
    }
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'voucherCode', $voucherCode );

$smarty->assign( 'waarde', $waarde );
$smarty->assign( 'waardeErr', $waardeErr );
$smarty->assign( 'email', $email );
$smarty->assign( 'emailErr', $emailErr );

$smarty->assign( 'evenementId', $evenementId );
$smarty->assign( 'evenementIdErr', $evenementIdErr );
$smarty->assign( 'evenementLijst', $evenement_lijst);

$smarty->assign( 'typenLijst', $typenLijst );
$smarty->assign( 'type', $type );
$smarty->assign( 'typeErr', $typeErr );

$smarty->assign( 'geldigTot', $geldigTot );
$smarty->assign( 'geldigTotErr', $geldigTotErr );

$smarty->assign( 'isActiefLijst', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isActief', $isActief );
$smarty->assign( 'isActiefErr', $isActiefErr );

$smarty->assign( 'typeVoucher', VOUCHERTYPE_VOUCHER );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'voucher_aanmaken.tpl' );
