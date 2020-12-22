<?php
/**
 * System      ERAS
 * Module      debug
 * Doel        Logleven instellingen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       15-10-2020
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


require_once 'constanten.php';
require_once 'utilities.php';
require_once DEBUG_CONFIG_FILENAME;

use Respect\Validation\Validator as v;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Instellingen";

$sessie = new Sessie();
$history = new History();

$loggerNiveau = "";
$loggerNiveauErr = "";
$loggerLevels = array();

$statusRegel = "";
$signalError = false;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ADMINISTRATOR );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $history->set();

    $loggerNiveau = LOGLEVEL;

    vulLoggerLevels();

}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    $validateOk = 0;

    vulLoggerLevels();

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }
    else if ( isset( $_POST['verwijder'] ) )
    {
        $ini = parse_ini_file( CONFIG_FILENAME, true );
        $logfile = $ini['settings']['log_directory'] . '/' . LOGFILE_NAME;
        unlink( $logfile );
        $logger->security( "Logfile is leeg gemaakt door " . $autorisatie->getUserId() );
    }
    else
    {
        try
        {
            $setVar = new SetVariable();
            $validateOk += $setVar->name( $loggerNiveau )
                ->onerror( $loggerNiveauErr )
                ->required( true )
                ->go();
    
            if ( $validateOk == 0 )
            {
                // Schrijf hele inhoud van het configuratiebestand
                $fp = fopen( DEBUG_CONFIG_FILENAME, 'w' );
                if ( $fp == null )
                {
                    throw new Exception( "Kan bestand " . DEBUG_CONFIG_FILENAME . " niet openen." );
                }
    
                fprintf( $fp, '<?php' . "\n" );
                fprintf( $fp, '// Deze file wordt overschreven!' . "\n" );
                fprintf( $fp, 'define("LOGLEVEL", LOGLEVEL_' . logLevelNaam( $loggerNiveau ) . ");\n" );
                fclose( $fp );
                $signalError = false;
                $statusRegel = "Wijzigingen zijn opgeslagen";
                $logger->security( "Loglevel op " . logLevelNaam( $loggerNiveau ) . " gezet door " . $autorisatie->getUserId() );
            }
            else
            {
                $logger->warning( "Fout bij controle invoer, " . $validateOk );
                $signalError = true;
                $statusRegel = "Herstel a.u.b. de fout en probeer het opnieuw";
            }
        }
        catch ( Exception $ex )
        {
            $logger->error( "Unhandled exception in SetVariable" );
            $logger->errordump( $ex );
            $signalError = true;
            $statusRegel = "Er is een exceptie opgetreden. Zie errorlog";
    }
    }
}

// Deel 3

$ini = parse_ini_file( CONFIG_FILENAME, true );
$logfile = $ini['settings']['log_directory'] . '/' . LOGFILE_NAME;
$filesize = round( filesize( $logfile ) / 1000, 0);

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'loggerNiveau', $loggerNiveau );
$smarty->assign( 'loggerNiveauErr', $loggerNiveauErr );
$smarty->assign( 'loggerLevels', $loggerLevels );
$smarty->assign( 'logfile', $logfile );
$smarty->assign( 'filesize', $filesize );
$smarty->assign( 'autorisatie', $autorisatie->getRol() );
$smarty->assign( 'ADMIN', AUTORISATIE_STATUS_ADMINISTRATOR );
$smarty->assign( 'ROOT', AUTORISATIE_STATUS_ROOT );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'logging.tpl' );

function vulLoggerLevels()
{
    GLOBAL $loggerLevels;
    $loggerLevels[LOGLEVEL_ERROR] = logLevelNaam( LOGLEVEL_ERROR );
    $loggerLevels[LOGLEVEL_WARNING] = logLevelNaam( LOGLEVEL_WARNING );
    $loggerLevels[LOGLEVEL_INFO] = logLevelNaam( LOGLEVEL_INFO );
    $loggerLevels[LOGLEVEL_DEBUG] = logLevelNaam( LOGLEVEL_DEBUG );
    $loggerLevels[LOGLEVEL_DUMP] = logLevelNaam( LOGLEVEL_DUMP );
    $loggerLevels[LOGLEVEL_VERBOSE] = logLevelNaam( LOGLEVEL_VERBOSE );
}