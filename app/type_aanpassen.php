<?php

/**
 * System      ERAS
 * Module      Type aanpasssen
 * Doel        Aanpassen parameters voor types
 * Auteur      Sander Kuiper
 * Datum       14-02-2020
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

// Propel use
use Propel\Runtime\Propel;
use Respect\Validation\Validator as v;
use \fb_model\fb_model\Type;

// Validator
use \fb_model\fb_model\TypeQuery;

// Session autorisatie
$sessie = new Sessie();

// Variabelen + functies definiëren
$doctitle = 'Optietypen Aanpassen';
$actionForm = 'type_aanpassen.php';
$con = Propel::getConnection( fb_model\fb_model\Map\TypeTableMap::DATABASE_NAME );
$error = '';
$types_lijst = array();

$volgorde = 1;
$statusRegel = "";
$signalError = false;

$naamErr = '';
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
    $save = new Type();
    $validateOk = 0;

    $con->beginTransaction();
    $con->exec( 'SET foreign_key_checks = 0' );
    $tabelLeegmaken = TypeQuery::create()->find();
    $tabelLeegmaken->delete();

    try {
        foreach ( $_POST as $key => $value )
        {
            if ( strncmp( $key, "xx", 2 ) != 0 ) 
            {
                $logger->debug( "Key " . $key . " is geskipped");
                continue;
            }

            $nummer = substr( $key, 3 );

            $setVar->nameval( $value )->go();
            if ( isEven( $teller ) )
            {
                $validateOk += $setVar->nameval( $key )
                    ->onerror( $isActiefErr )
                    ->errormessage( 'Waarde "' . $value . '" bij code ' . $nummer . ' niet correct, moet "0" of "1" zijn.' )
                    ->validator( v::numericVal() )
                    ->go();
                if ( $validateOk == 0 )
                {
                    // $save is de vorige iteratie (1) al gevuld. Het begint met oneven.
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
                $validateOk += $setVar->nameval( $key )
                    ->onerror( $naamErr )
                    ->errormessage( 'Naam van code ' . $nummer . ', waarde "' . $value . '" is niet correct.' )
                    ->validator( v::alpha( '/()éá&.,   ' ) )
                    ->go();
                if ( $validateOk == 0 )
                {
                    $save = new Type();
                    $save->setCode( substr( $key, 3 ) );
                    $save->setNaam( $value );
                }
                else
                {
                    throw new Exception( $error );
                }
            }
            $teller += 1;
        }
        $con->exec( 'SET foreign_key_checks = 1' );
        $con->commit();
        $statusRegel = "Nieuwe waarden zijn opgeslagen.";
    }
    catch ( Exception $e )
    {
        $statusRegel = "Opslaan is mislukt.";
        $signalError = true;
        $con->rollback();
    }
}

// Opbouwen Type lijst
$types = typeQuery::create()->find();
foreach ( $types as $type )
{
    $type_lijst["id"] = $type->getId();
    $type_lijst["code"] = $type->getCode();
    $type_lijst["naam"] = $type->getNaam();
    $type_lijst["isActief"] = $type->getIsActief();
    array_push( $types_lijst, $type_lijst );
}

// Smarty assign
$smarty->assign( 'isActiefErr', $isActiefErr );
$smarty->assign( 'naamErr', $naamErr );
$smarty->assign( 'types_lijst', $types_lijst );
$smarty->assign( 'actionForm', $actionForm );
$smarty->assign( 'doctitle', $doctitle );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'type_aanpassen.tpl' );
