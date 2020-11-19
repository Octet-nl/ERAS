<?php
/**
 * System      ERAS
 * Module      Wijzigen voucher
 * Doel        Wijzigen van een bestaande voucher
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

$doctitle = "Voucher wijzigen";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use fb_model\fb_model\Contactlog;
use fb_model\fb_model\GebruikerQuery;
use fb_model\fb_model\KeuzesQuery;
use fb_model\fb_model\PersoonQuery;
use fb_model\fb_model\VoucherQuery;
use Respect\Validation\Validator as v;

// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$voucherLijst = array();
$vouchers = array();

$voucherCode = "";
$voucherId = "";
$email = "";
$emailErr = "";
$code = "";
$geldigTot = date( 'd-m-Y', strtotime( '+2 years' ) );
$geldigTotErr = "";
$type = 0;
$typeErr = "";
$isActief = OPTIE_KEUZE_JA;
$isActiefErr = "";
$oorsprongwaarde = "";
$restwaarde = "";
$restwaardeErr = "";
$verbruikt = "";
$verbruiktErr = "";
$evenementId = null;
$evenementIdErr = "";

$formGetMail = false;
$statusRegel = "";
$signalError = false;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// prompt function
function prompt( $prompt_msg )
{
    echo ( "<script type='text/javascript'> var answer = prompt('" . $prompt_msg . "'); </script>" );
    $answer = "<script type='text/javascript'> document.write(answer); </script>";
    return ( $answer );
}

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    $history->set();

    getGetVar( $id );
    getGetVar( $em );
    getGetVar( $cd );
    getGetVar( $an );
    getGetVar( $inact );

    $voucher = null;
    if ( $id != null && $id != "" )
    {
        $voucherId = $id;

        $logger->debug( "Voucher a.d.h.v. id " . $voucherId );

        $voucher = VoucherQuery::create()->
            findPk( $voucherId );
    }
    else if ( $em != null && $em != "" )
    {
        $email = $em;

        $logger->debug( "Voucher a.d.h.v. mailadres " . $email );

        if ( $inact != null )
        {
            $voucher = VoucherQuery::create()->
//            where( 'UPPER(Voucher.Email) like ?', '%' . strtoupper( $email ) . '%' );
            filterByEmail( $email )->
            findOne();
        }
        else
        {
            $voucher = VoucherQuery::create()->
//            where( 'UPPER(Voucher.Email) like ?', '%' . strtoupper( $email ) . '%' )->
            filterByEmail( $email )->
            filterByIsActief( 1 )->
            findOne();
        }
    }
    else if ( $cd != null && $cd != "" )
    {
        $code = $cd;

        $logger->debug( "Voucher a.d.h.v. code " . $code );

        if ( $inact != null )
        {
            $voucher = VoucherQuery::create()->
                filterByCode( $code )->
                findOne();
        }
        else
        {
            $voucher = VoucherQuery::create()->
                filterByCode( $code )->
                filterByIsActief( 1 )->
                findOne();
        }
    }
    else if ( $an != null && $an != "" )
    {
        $logger->debug( "Anonieme (kortings-) bonnen" );

        if ( $inact != null )
        {
            $vouchers = VoucherQuery::create()->
                filterByEmail( null )->
                find();
        }
        else
        {
            $vouchers = VoucherQuery::create()->
                filterByEmail( null )->
                filterByIsActief( 1 )->
                find();
        }

        if ( $vouchers != null )
        {
            $logger->verbose( $vouchers );
            foreach ( $vouchers as $vouch )
            {
                $vLijst = array();
                $vLijst["type"] = $vouch->getVoucherType();
                $vLijst["code"] = $vouch->getCode();
                $vLijst["evenement"] = $vouch->getEvenementId();
                $vLijst["waarde"] = $vouch->getOorspronkelijkeWaarde();
                $vLijst["geldigTot"] = $vouch->getGeldigTot()->format( "d-m-Y" );
                if ( $vouch->getIsActief() == 1 )
                {
                    $logger->debug( "Actief" );
                    $vLijst["deleted"] = '0';
                }
                else
                {
                    $logger->debug( "Inactief" );
                    $vLijst["deleted"] = '1';
                }

                array_push( $voucherLijst, $vLijst );
            }
        }
        else
        {
            $signalError = true;
            $statusRegel = "Geen anonieme vouchers gevonden";
        }

        $formGetMail = true;
    }
    else
    {
        $formGetMail = true;
    }

    if ( $formGetMail == false )
    {
        if ( $voucher == null )
        {
            $logger->debug( "Voucher is null" );
            $signalError = true;
            $statusRegel = "Voucher is niet gevonden";
            $formGetMail = true;
        }
        else
        {
            $logger->debug( "Voucher a.d.h.v. id is niet null" );

            $logger->dump( $voucher );

            $voucherCode = $voucher->getCode();
            $voucherId = $voucher->getId();
            $restwaarde = $voucher->getRestWaarde();
            $oorsprongwaarde = $voucher->getOorspronkelijkeWaarde();
            $verbruikt = $voucher->getVerbruikt();
            $type = $voucher->getVoucherType();
            $email = $voucher->getEmail();
            $evenementId = $voucher->getEvenementId();
            $isActief = ( $voucher->getIsActief() == 1 ? OPTIE_KEUZE_JA : OPTIE_KEUZE_NEE );
            $geldigTot = $voucher->getGeldigTot()->format( 'd-m-Y' );
        }
    }

}

// Deel 2
// Na drukken op de "zoeken" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug = $history->get();
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['inactief'] ) )
    {
        $inactief = "&inact=1";
    }

    if ( isset( $_POST['getMail'] ) )
    {
        header( "Location:voucher_wijzigen.php?em=" . $_POST['email'] . $inactief );
        exit;
    }

    if ( isset( $_POST['lijst'] ) )
    {
        header( "Location:voucher_wijzigen.php?an=1" . $inactief );
        exit;
    }

    if ( isset( $_POST['getCode'] ) )
    {
        header( "Location:voucher_wijzigen.php?cd=" . $_POST['code'] . $inactief );
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
        $validateOk += $setVar->name( $oorsprongwaarde )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $restwaarde )
            ->onerror( $restwaardeErr )
            ->formatter( 'prijs' )
            ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" )->min( 1 ) )
            ->emptymessage( "Vul a.u.b een bedrag in van minimaal 1 euro." )
            ->errormessage( "Bedrag in euros.centen, minimaal 1 euro." )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $verbruikt )
            ->onerror( $verbruiktErr )
            ->defaultvalue( 0.00 )
            ->formatter( 'prijs' )
            ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" )->min( 0 ) )
            ->emptymessage( "Vul a.u.b een bedrag in." )
            ->errormessage( "Bedrag in euros.centen." )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $isActief )
            ->onerror( $isActiefErr )
            ->required( true )
            ->go();
        if ( $type == VOUCHERTYPE_VOUCHER )
        {
            $validateOk += $setVar->name( $email )
                ->onerror( $emailErr )
                ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
                ->emptymessage( "Bij tegoedbonnen/vouchers moet een email adres worden ingevuld." )
                ->required( true )
                ->go();
        }
        else
        {
            $validateOk += $setVar->name( $email )
                ->onerror( $emailErr )
                ->errormessage( "Bij kortingsbonnen geen email adres opgeven." )
                ->validator( v::nullType() )
                ->required( false )
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
        $validateOk += $setVar->name( $voucherId )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $evenementId )
            ->required( true )
            ->go();

        if ( $validateOk == 0 )
        {
            if ( rondnul( $oorsprongwaarde - ( $restwaarde + $verbruikt ) ) > 0 )
            {
                $validateOk = 999;
                $signalError = true;
                $statusregel = "Oorspronkelijk bedrag is niet gelijk aan restwaarde + verbruikt ";
                $verbruiktErr = "Oorspronkelijk bedrag is niet gelijk aan restwaarde + verbruikt ";
                $logger->error( "Oorspronkelijk bedrag is niet gelijk aan restwaarde + verbruikt" );
            }
        }

        if ( $validateOk == 0 )
        {
            if ( isset( $_POST['opslaan'] ) )
            {
                $logger->debug( "Opslaan voucher. Actief: " .$isActief );

                $dbVoucher = VoucherQuery::create()->findPk( $voucherId );
                if ( $dbVoucher == null )
                {
                    $logger->debug( "Voucher a.d.h.v. id is null" );
                    $signalError = true;
                    $statusregel = "Opvragen voucher voor id " . $voucherId . " is mislukt";
                }
                else
                {
                    $logger->debug( "Voucher a.d.h.v. id is niet null" );
                }

                $dbVoucher->setRestwaarde( $restwaarde );
                $dbVoucher->setVerbruikt( $verbruikt );
                $dbVoucher->setVoucherType( $type );
                $dbVoucher->setIsActief( vanJaNee( $isActief ) );
                $dbVoucher->setEvenementId( $evenementId );
                $dbVoucher->setGeldigTot( $geldigTot );
                $dbVoucher->setGewijzigdDoor( $autorisatie->getUserId() );
                $dbVoucher->save();

                if ( $email != null )
                {
                    $gebruiker = GebruikerQuery::create()->filterByUserId( $email )->findOne();
                    if ( $gebruiker != null )
                    {
                        $persoonId = $gebruiker->getPersoonId();
                        if ( $persoonId != null )
                        {
                            $persoon = PersoonQuery::create()->filterById( $persoonId )->find();
                            if ( $persoon != null )
                            {
                                $logger->verbose( $persoon );

                                $contactPersoonId = $persoonId;
                                $contactlog = new Contactlog;
                                $contactlog->setPersoonId( $contactPersoonId );
                                $contactlog->setTekst( "Voucher met id " . $voucherId . "(" . $voucherCode . ") is aangepast door " . $autorisatie->getUserId() .
                                    ".\n  Restwaarde: " . $restwaarde . ', Verbruikt ' . $verbruikt .
                                    ".\n  Actief: " . $isActief . ", Geldig tot: " . $geldigTot );
                                $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
                                $contactlog->save();
                            }
                        }
                    }
                }

                $logger->debug( "Voucher opgeslagen" );

                header( "Location:voucher_wijzigen.php" );
//                    $terug = $history->get();
//                    $logger->debug( "History get: " . $terug );
//                    header( "Location:" . $terug );
                exit;
            }
        }
        else
        {
            $signalError = true;
            $statusregel = "Fout geconstateerd bij invoercontrole";
        }
    }
    catch ( Exception $ex )
    {
        if ( strpos( $ex->getPrevious(), '1062 Duplicate entry' ) !== false )
        {
            $signalError = true;
            $statusRegel = 'Er bestaat al een voucher voor emailadres "' . $email;
            alert( 'Er bestaat al een voucher voor emailadres "' . $email );
            $logger->debug( 'Er bestaat al een voucher voor emailadres "' . $email );
        }
        else
        {
            $signalError = true;
            $statusRegel = "Onbekende fout. Zie de foutlog voor meer informatie.";
            alert( 'Onbekende fout bij opvoeren gebruiker.' );
            $logger->errordump( $ex );
        }
        $signalError = true;
    }
}

// Deel 3

$typenLijst = array();
if ( $typenLijst == null )
{
    $typen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_VOUCHER )->filterByIsActief( "1" )->find();
    foreach ( $typen as $mtype )
    {
        $typenLijst[$mtype->getCode()] = $mtype->getNaam();
    }
}

$smarty->assign( 'formGetMail', $formGetMail );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'voucherId', $voucherId );
$smarty->assign( 'voucherCode', $voucherCode );

$smarty->assign( 'oorsprongwaarde', $oorsprongwaarde );
$smarty->assign( 'restwaarde', $restwaarde );
$smarty->assign( 'restwaardeErr', $restwaardeErr );
$smarty->assign( 'verbruikt', $verbruikt );
$smarty->assign( 'verbruiktErr', $verbruiktErr );
$smarty->assign( 'email', $email );
$smarty->assign( 'code', $code );
$smarty->assign( 'emailErr', $emailErr );
$smarty->assign( 'evenementId', $evenementId );
$smarty->assign( 'evenementIdErr', $evenementIdErr );
$smarty->assign( 'voucherLijst', $voucherLijst );

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

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'voucher_wijzigen.tpl' );
