<?php

/**
 * System      ERAS
 * Module      Categorie aanpasssen
 * Doel        Aanpassen evenement categorieën
 * Auteur      Hans de Rijck
 * Datum       14-07-2020
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

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// Propel
use Propel\Runtime\Propel;
use \fb_model\fb_model\Betaalwijze;
use \fb_model\fb_model\BetaalwijzeQuery;

// Validator
use Respect\Validation\Validator as v;

// Session autorisatie
$sessie = new Sessie();

// Variabelen + functies definiëren
$doctitle = 'Betaalwijze aanpassen';
$con = Propel::getConnection( fb_model\fb_model\Map\BetaalwijzeTableMap::DATABASE_NAME );
$error = '';
$betaalwijzen_lijst = array();

$volgorde = 1;
$statusRegel = "";
$signalError = false;

$naamErr = '';
$kostenErr = '';
$isActiefErr = '';

function isEven( $waarde )
{
    return ( $waarde % 2 == 0 );
}

$logger = new Logger();
$logger->level( LOGLEVEL );

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ROOT );

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
// Niets te doen    
    $history->set();
}

// POST // input validaten // errors // rollback
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

    $setVar = new SetVariable();

    $teller = 1;
    $save = new Betaalwijze();;
    $validateOk = 0;

    $con->beginTransaction();
    $con->exec( 'SET foreign_key_checks = 0' );
    $tabelLeegmaken = BetaalwijzeQuery::create()->find();
    $tabelLeegmaken->delete();

    try {
        foreach ( $_POST as $key => $value )
        {
            if ( strncmp( $key, "xx", 2 ) != 0 ) 
            {
                $logger->debug( "Key " . $key . " is geskipped");
                continue;
            }

            $logger->debug( "Foreach key " . $key . " => value " . $value);

            $nummer = substr( $key, 3 );

            $setVar->nameval( $value )->go();
            if ( $teller == 1 )
            {
                $logger->debug( "Kolom 1 " . $teller );
                $validateOk += $setVar->nameval( $key )
                    ->onerror( $naamErr )
                    ->errormessage( 'Naam van code ' . $nummer . ', waarde "' . $value . '" is niet correct.' )
                    ->validator( v::alpha( '/()éá&.,   ' ) )
                    ->go();
                if ( $validateOk == 0 )
                {
                    $logger->debug( "Kolom 1 save" );
                    $save = new Betaalwijze();
                    $save->setCode( substr( $key, 3 ) );
                    $save->setNaam( $value );
                }
                else
                {
                    throw new Exception( $error );
                }
            }
            else if ( $teller == 2 )
            {
                $logger->debug( "Kolom 2 " . $teller . " key=" . $key );
                $value = prijs( $value );
                $validateOk += $setVar->nameval( $key )
                    ->onerror( $kostenErr )
                    ->formatter( 'prijs' )
                    ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" ) )
                    ->errormessage( 'Prijs van code ' . $nummer . ', waarde "' . $value . '" is niet correct.' )
                    ->go();
                if ( $validateOk == 0 )
                {
                    $logger->debug( "Kolom 2 save, key=" . $key );
                    $save->setCode( substr( $key, 3 ) );
                    $save->setKosten( $value );
                    $save->setGewijzigdDoor( $autorisatie->getUserId() );
                }
                else
                {
                    throw new Exception( $error );
                }
            }
            else if ( $teller == 3 )
            {
                $logger->debug( "Kolom 3 " . $teller . " key=" . $key );
                $validateOk += $setVar->nameval( $key )
                    ->onerror( $isActiefErr )
                    ->errormessage( 'Waarde "' . $value . '" bij code ' . $nummer . ' niet correct, moet "0" of "1" zijn.' )
                    ->validator( v::numericVal()->min(0)->max(1) )
                    ->go();
                if ( $validateOk == 0 )
                {
                    $logger->debug( "Kolom 3 save, key=" . $key );
                    // $save is de vorige iteratie gevuld, de foreach begint met oneven.
                    $save->setCode( substr( $key, 3 ) );
                    $save->setIsActief( $value );
                    $save->save();
                }
                else
                {
                    throw new Exception( $error );
                }
            }
            else
            {
                throw new Exception( "Teller is niet 1-3" );
            }

            $teller += 1;
            if ( $teller > 3 )
            {
                $teller = 1;
            }
        }
        $con->exec( 'SET foreign_key_checks = 1' );
        $con->commit();
        $statusRegel = "Nieuwe waarden zijn opgeslagen.";
    }
    catch ( Exception $e )
    {
        $statusRegel = "Opslaan is mislukt.";
        $signalError = true;
        $logger->errordump($e);
        $con->rollback();
    }
}

// Alleen de eerste keer de vorige pagina vastleggen. 

// Opbouwen Categorie lijst
$betaalwijzen = BetaalwijzeQuery::create()->find();
foreach ( $betaalwijzen as $betaalwijze )
{
    $betaalwijze_lijst["id"] = $betaalwijze->getId();
    $betaalwijze_lijst["code"] = $betaalwijze->getCode();
    $betaalwijze_lijst["naam"] = $betaalwijze->getNaam();
    $betaalwijze_lijst["prijs"] = $betaalwijze->getKosten();
    $betaalwijze_lijst["isActief"] = $betaalwijze->getIsActief();
    array_push( $betaalwijzen_lijst, $betaalwijze_lijst );
}

// Smarty assign
$smarty->assign( 'isActiefErr', $isActiefErr );
$smarty->assign( 'naamErr', $naamErr );
$smarty->assign( 'kostenErr', $kostenErr );
$smarty->assign( 'betaalwijzen_lijst', $betaalwijzen_lijst );
$smarty->assign( 'doctitle', $doctitle );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'betaalwijze_aanpassen.tpl' );
