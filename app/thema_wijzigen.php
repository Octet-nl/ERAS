<?php
/**
 * System      ERAS
 * Module      thema
 * Doel        Iies een kleurthema
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       05-07-2020
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

$doctitle = "Thema";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$deployDirectory = "";
$omgeving = "";

$statusRegel = "";
$signalError = false;

$taglijst[""] = "";
$taglijst["blue"] = "blue";
$taglijst["lblue"] = "lblue";
$taglijst["teal"] = "teal";
$taglijst["classic"] = "classic";
$taglijst["b/w"] = "b/w";
$taglijst["dark"] = "dark";

$fontlijst[""] = "";
$fontlijst["default"] = "default";
$fontlijst["sans-serif"] = "sans-serif";
$fontlijst["amaranth"] = "amaranth";
$fontlijst["jura"] = "jura";

$font = "";
$thema = "";
$font_klant = "";
$thema_klant = "";

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ROOT );

function copyDir( $dirName )
{
   // Move all images files
   $files = glob( "res/icons/" . $dirName . "/*.*" );
   foreach($files as $file)
   {
        $newName = str_replace("res/icons/" . $dirName . "/", "res/icons/", $file);
                copy($file, $newName);
   }
}


if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $history->set();
    if ( isset( $_SESSION['thema'] ) )
    {
      $thema = $_SESSION['thema'];
      $logger->debug( "Thema is " .$thema );
    }
    if ( isset( $_SESSION['font'] ) )
    {
      $font = $_SESSION['font'];
      $logger->debug( "Font is " .$font );
    }
    if ( isset( $_SESSION['thema_klant'] ) )
    {
      $thema_klant = $_SESSION['thema_klant'];
      $logger->debug( "Thema klant is " .$thema_klant );
    }
    if ( isset( $_SESSION['font_klant'] ) )
    {
      $font_klant = $_SESSION['font_klant'];
      $logger->debug( "Font klant is " .$font_klant );
    }
}

// Na drukken op de "thema" knop
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
        if ( isset( $_POST['keuze_thema'] ) )
        {
            $thema = $_POST['thema'];

            $logger->debug( "Thema is " .$thema );

            if ( $thema == 'dark' )
            {
                copy( "css/colors-dark.css", "css/colors.css" );
                copyDir( "dark" );
            }
            else if ( $thema == 'classic' )
            {
                copy( "css/colors-classic.css", "css/colors.css" );
                copyDir( "classic" );
            }
            else if ( $thema == 'teal' )
            {
                copy( "css/colors-teal.css", "css/colors.css" );
                copyDir( "teal" );
            }
            else if ( $thema == 'lblue' )
            {
                copy( "css/colors-lblue.css", "css/colors.css" );
                copyDir( "lblue" );
            }
            else if ( $thema == 'b/w' )
            {
                copy( "css/colors-bw.css", "css/colors.css" );
                copyDir( "bw" );
            }
            else
            {
                copy( "css/colors-blue.css", "css/colors.css" );
                copyDir( "blue" );
            }
            $_SESSION['thema'] = $thema;
        }

        if ( isset( $_POST['keuze_font'] ) )
        {
            $font = $_POST['font'];

            $logger->debug( "Font is " .$font );

            if ( $font == 'default' )
            {
                copy( "css/font-default.css", "css/font.css" );
            }
            else if ( $font == 'sans-serif' )
            {
                copy( "css/font-sansserif.css", "css/font.css" );
            }
            else if ( $font == 'amaranth' )
            {
                copy( "css/font-amaranth.css", "css/font.css" );
            }
            else if ( $font == 'jura' )
            {
                copy( "css/font-jura.css", "css/font.css" );
            }
            else
            {
                copy( "css/font-default.css", "css/font.css" );
            }
            $_SESSION['font'] = $font;
        }

        if ( isset( $_POST['keuze_thema_klant'] ) )
        {
            $thema_klant = $_POST['thema_klant'];

            $logger->debug( "Thema klant is " .$thema );

            if ( $thema_klant == 'dark' )
            {
                copy( "css/colors-dark.css", "css/colors-klant.css" );
            }
            else if ( $thema_klant == 'classic' )
            {
                copy( "css/colors-classic.css", "css/colors-klant.css" );
            }
            else if ( $thema_klant == 'teal' )
            {
                copy( "css/colors-teal.css", "css/colors-klant.css" );
            }
            else if ( $thema_klant == 'lblue' )
            {
                copy( "css/colors-lblue.css", "css/colors-klant.css" );
            }
            else if ( $thema_klant == 'b/w' )
            {
                copy( "css/colors-bw.css", "css/colors-klant.css" );
            }
            else
            {
                copy( "css/colors-blue.css", "css/colors-klant.css" );
            }
            $_SESSION['thema_klant'] = $thema_klant;
        }

        if ( isset( $_POST['keuze_font_klant'] ) )
        {
            $font_klant = $_POST['font_klant'];

            $logger->debug( "Font klant is " .$font_klant );

            if ( $font_klant == 'default' )
            {
                copy( "css/font-default.css", "css/font-klant.css" );
            }
            else if ( $font_klant == 'sans-serif' )
            {
                copy( "css/font-sansserif.css", "css/font-klant.css" );
            }
            else if ( $font_klant == 'amaranth' )
            {
                copy( "css/font-amaranth.css", "css/font-klant.css" );
            }
            else if ( $font_klant == 'jura' )
            {
                copy( "css/font-jura.css", "css/font-klant.css" );
            }
            else
            {
                copy( "css/font-default.css", "css/font-klant.css" );
            }
            $_SESSION['font_klant'] = $font_klant;
        }

        header( "refresh:0" );
        exit;
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception bij kopieeren van colors.css" );
        $logger->errordump( $ex );
        $statusRegel = "Fout bij kopieren van colors.css";
        $signalError = true;
    }
}

// Deel 3
$smarty->assign( 'doctitle', $doctitle );

$smarty->assign( 'taglijst', $taglijst );
$smarty->assign( 'thema', $thema );
$smarty->assign( 'thema_klant', $thema_klant );

$smarty->assign( 'fontlijst', $fontlijst );
$smarty->assign( 'font', $font );
$smarty->assign( 'font_klant', $font_klant );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'thema_wijzigen.tpl' );
