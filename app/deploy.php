<?php
/**
 * System      Inschrijvingen
 * Module      deployment
 * Doel        Update van huidig systeem vanuit GIT door ROOT user
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       01-05-2020
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

$sessie = new Sessie();

$doctitle = "Upgrade ERAS";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenementen_lijst = array();

$doctitle = "GitHub deployment";
$deployDirectory = "";
$omgeving = "";

$statusRegel = "";
$signalError = false;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ROOT );

$taglijst = array();

function exec_array( $command )
{
  $returnvar = 0;
  $out = null;
  exec($command, $out, $returnvar);
  if ( $returnvar != 0 )
  {
     echo "Fout bij uitvoeren van '" . $command . "'. Returnwaarde = " . $returnvar . " <br>";
	 return null;
  }
  else
  {  
	$mystring = "";
    foreach($out as $key => $value)
    {
       $mystring .= $value;
    }
    $myarray = json_decode( $mystring, true );
    return $myarray;
  }	  
}

function exec_wait( $command )
{
  GLOBAL $logger;
  $returnvar = 0;
  exec($command,$out, $returnvar);
  if ( $returnvar != 0 )
  {
     $logger->error( "Fout bij uitvoeren van '" . $command . "', returnwaarde = " . $returnvar);
     return $returnvar;
  }
  return 0;
}

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    $tglijst = exec_array( 'curl -k -L https://api.github.com/repos/Octet-nl/ERAS/tags' );

    $logger->dump( $tglijst );

    if ( $tglijst == null )
    {
        $logger->info( "Geen evt in url. Terug naar evenementenlijst" );
        alertAndGo( 'Kan lijst met tags niet ophalen. Terug naar hoofdmenu', "index.php" );
        exit();
    }
    if ( $tglijst[0]["name"] == null )
    {
        $logger->error( "Geen name in taglijst:" );
        $logger->errordump( $myarray );
        alertAndGo( 'Kan lijst met tags niet ophalen. Terug naar hoofdmenu', "index.php" );
        exit();
    }

    foreach ( $tglijst as $tag )
    {
        $taglijst[ $tag["name"] ] = $tag["name"];
    }
    $taglijst[ "master" ] = "master";

    $logger->debug( "Lijst met tags gevuld" );

    $systeem = new Sysdb( true );

    $logger->debug( "systeemklasse geconstruct" );

    $omgeving = $systeem->getNaam();
    $deployDirectory = $systeem->getDeployDirectory();
    $logger->debug( "Omgeving " . $omgeving . ", Deploy directory " . $deployDirectory );

    if ( !dirIsWritable( "./" ) )
    {
        $logger->error( "Kan directory ./ niet schrijven" );
        alertAndGo( "Kan directory ./ niet schrijven, terug naar hoofdmenu", "index.php" );
        exit();
    }
}

// Deel 2
// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    if ( isset( $_POST['annuleren'] ) )
    {
        header( "Location:index.php" );
        exit;
    }

    $validateOk = 0; 
    try
    {
        $setVar = new SetVariable();
        $tag = "0.1";
        $validateOk += $setVar->name( $tag )
         ->required( true )
         ->go();
        $validateOk += $setVar->name( $omgeving )
         ->required( true )
         ->go();
        $validateOk += $setVar->name( $deployDirectory )
         ->required( true )
         ->go();
         
        }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( $validateOk == 0 )
    {
        $systeem = new Sysdb();

        $omgeving = $systeem->getNaam();

        header( "Location:getgit.php?env=" . $omgeving . "&tag=" . $tag . "&dir=".$deployDirectory );
        exit();
        
    }
    else
    {
        $logger->error( "Fout bij validatie. Code=" . $validateOk );
        $statusRegel = "Fout bij controle. Code=" . $validateOk;
        $signalError = true;
    }
}

// Deel 3
$smarty->assign( 'doctitle', $doctitle );

$smarty->assign( 'taglijst', $taglijst );
$smarty->assign( 'omgeving', $omgeving );
$smarty->assign( 'deployDirectory', $deployDirectory );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'deploy.tpl' );
