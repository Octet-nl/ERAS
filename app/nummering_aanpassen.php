<?php
/**
 * System      ERAS
 * Module      Nummering aanpasssen
 * Doel        Aanpassen startnummer voor evenementen en inschrijvingen
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

// Validator
use Respect\Validation\Validator as v;

// Session autorisatie
$sessie = new Sessie();

// Variabelen + functies definiëren
$doctitle = 'Nummering aanpassen';
$error = '';

$evenementStart = 0;
$evenementNummer = 0;
$evenementErr = "";
$inschrijvingStart = 0;
$inschrijvingNummer = 0;
$inschrijvingErr = "";
$mailingStart = 0;
$mailingNummer = 0;
$mailingErr = "";

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
$autorisatie->validate( AUTORISATIE_STATUS_ADMINISTRATOR );

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
// Niets te doen    
    $history->set();
    $conn = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT );
    if ( mysqli_connect_errno() )
    {
        $logger->error( "Connectie met database is mislukt: errno=" . mysqli_connect_error() . " - " . mysqli_connect_errno() );
        alert( "Connectie met database is mislukt: errno=" . mysqli_connect_error() . " - " . mysqli_connect_errno() );
        exit;
    }
    else
    {
        $logger->info( "Connected" );

        $result = mysqli_query( $conn, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='eras' AND TABLE_NAME='fb_evenement';");
        if( $result )
        {
            $evenementStart = mysqli_fetch_assoc($result)['AUTO_INCREMENT'];
            mysqli_free_result( $result );
        }
        else
        {
            $logger->error( "Probleem met opvragen evenement AUTO_INCREMENT" . mysqli_error($conn ) );
            alertAndGo( "Probleem met opvragen evenement AUTO_INCREMENT" . mysqli_error($conn ), "index.php" );
        }
        $result = mysqli_query( $conn, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='eras' AND TABLE_NAME='fb_inschrijving';");
        if( $result )
        {
            $inschrijvingStart = mysqli_fetch_assoc($result)['AUTO_INCREMENT'];
            mysqli_free_result( $result );
        }
        else
        {
            $logger->error( "Probleem met opvragen inschrijving AUTO_INCREMENT" . mysqli_error($conn ) );
            alertAndGo( "Probleem met opvragen inschrijving AUTO_INCREMENT" . mysqli_error($conn ), "index.php" );
        }
        $result = mysqli_query( $conn, "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='eras' AND TABLE_NAME='fb_mailinglist';");
        if( $result )
        {
            $mailingStart = mysqli_fetch_assoc($result)['AUTO_INCREMENT'];
            mysqli_free_result( $result );
        }
        else
        {
            $logger->error( "Probleem met opvragen mailinglist AUTO_INCREMENT" . mysqli_error($conn ) );
            alertAndGo( "Probleem met opvragen mailinglist AUTO_INCREMENT" . mysqli_error($conn ), "index.php" );
        }
        mysqli_close( $conn );
    }
}

// POST 
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

    try{

        $setVar = new SetVariable();
        $validateOk = 0;

        $validateOk += $setVar->name( $evenementStart )->required()->go();
        $validateOk += $setVar->name( $inschrijvingStart )->required()->go();
        $validateOk += $setVar->name( $mailingStart )->required()->go();

        $validateOk += $setVar->name( $evenementNummer )
            ->onerror( $evenementErr )
            ->errormessage( "Startwaarde moet hoger zijn dan huidige waarde" )
            ->validator( v::intVal()->min( (int)$evenementStart + 1 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $inschrijvingNummer )
            ->onerror( $inschrijvingErr )
            ->errormessage( "Startwaarde moet hoger zijn dan huidige waarde" )
            ->validator( v::intVal()->min( (int)$inschrijvingStart + 1 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $mailingNummer )
            ->onerror( $mailingErr )
            ->errormessage( "Startwaarde moet hoger zijn dan huidige waarde" )
            ->validator( v::intVal()->min( (int)$mailingStart + 1 ) )
            ->required( true )
            ->go();


        if ( $validateOk == 0 )
        {
            //
            $conn = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT );
            if ( mysqli_connect_errno() )
            {
                $logger->error( "Connectie met database is mislukt: errno=" . mysqli_connect_error() . " - " . mysqli_connect_errno() );
                alert( "Connectie met database is mislukt: errno=" . mysqli_connect_error() . " - " . mysqli_connect_errno() );
                exit;
            }
            else
            {
                $logger->debug( "Connected" );
        
                if ( $evenementNummer != $evenementStart + 1 )
                {
                    $result = mysqli_query( $conn, "ALTER TABLE fb_evenement AUTO_INCREMENT = " . $evenementNummer . ";");
                    if ( $result == false )
                    {
                        $logger->error( "Er is iets misgegaan bij het wijzigen van het evenementnummer<br/>" . mysqli_error( $conn ) );
                        alert( "Er is iets misgegaan bij het wijzigen van het evenementnummer<br/>" . mysqli_error( $conn ) );
                        exit;
                    }
                    $logger->debug( "Auto increment evenementnummer is gewijzigd" );
                }
                if ( $inschrijvingNummer != $inschrijvingStart + 1 )
                {
                    $result = mysqli_query( $conn, "ALTER TABLE fb_inschrijving AUTO_INCREMENT = " . $inschrijvingNummer . ";");
                    if ( $result == false )
                    {
                        $logger->error( "Er is iets misgegaan bij het wijzigen van het inschrijfnummer<br/>" . mysqli_error( $conn ) );
                        alert( "Er is iets misgegaan bij het wijzigen van het inschrijfnummer<br/>" . mysqli_error( $conn ) );
                        exit;
                    }
                    $logger->debug( "Auto increment inschrijvingsnummer is gewijzigd" );
                }
                if ( $mailingNummer != $mailingStart + 1 )
                {
                    $result = mysqli_query( $conn, "ALTER TABLE fb_mailinglist AUTO_INCREMENT = " . $mailingNummer . ";");
                    if ( $result == false )
                    {
                        $logger->error( "Er is iets misgegaan bij het wijzigen van het mailingnummer<br/>" . mysqli_error( $conn ) );
                        alert( "Er is iets misgegaan bij het wijzigen van het mailingnummer<br/>" . mysqli_error( $conn ) );
                        exit;
                    }
                    $logger->debug( "Auto increment mailingnummer is gewijzigd" );
                }

                $statusRegel = "Nieuwe waarden zijn opgeslagen.";
                $terug =  $history->get( );
                $logger->debug( "History get: " . $terug );
//                alertAndGo( "Nieuwe waarden zijn opgeslagen.", $terug );
header("Refresh:0");
                mysqli_close( $conn );
            }
        }
    }
    catch ( Exception $e )
    {
        $statusRegel = "Opslaan is mislukt.";
        $signalError = true;
        $logger->errordump($e);
        $con->rollback();
    }
}

// Smarty assign
$smarty->assign( 'evenementStart', $evenementStart );
$smarty->assign( 'evenementNummer', $evenementStart + 1 );
$smarty->assign( 'evenementErr', $evenementErr );
$smarty->assign( 'inschrijvingStart', $inschrijvingStart );
$smarty->assign( 'inschrijvingNummer', $inschrijvingStart + 1 );
$smarty->assign( 'inschrijvingErr', $inschrijvingErr );
$smarty->assign( 'mailingStart', $mailingStart );
$smarty->assign( 'mailingNummer', $mailingStart + 1 );
$smarty->assign( 'mailingErr', $mailingErr );

$smarty->assign( 'doctitle', $doctitle );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'nummering_aanpassen.tpl' );
