<?php
/**
 * System      Inschrijvingen
 * Module      install
 * Doel        Installatie en configuratie
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-10-2020
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


//echo $_SERVER['REQUEST_URI']."<br/>";
//echo $_SERVER['HTTP_HOST']."<br/>";

require_once 'utilities.php';

use Respect\Validation\Validator as v;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$doctitle = "Instellingen";

$hostname = "";
$dbname = "";
$userid = "";
$password = "";
$createdb = "eras";
$createhost = "";
$createhostErr = "";
$createErr = "";
$rootuser = "";
$rootpassword = "";
$erasuser = "erasuser";
$eraspassword = "";
$hostnameErr = "";
$dbnameErr = "";
$useridErr = "";
$passwordErr = "";
$rootuserErr = "";
$rootpasswordErr = "";
$erasuserErr = "";
$eraspasswordErr = "";
$rootchanged = "0";
$settingschanged = "0";
$userschanged = "0";

$sqlfile = '../eras_init.sql';

$schermdeel = "1";

error_reporting(E_ERROR | E_PARSE);

$history = new History();
$sessie = new Sessie();

$logger = new Logger();
$logger->level( LOGLEVEL_DUMP );

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    $history->set( "?scherm=3" );
    if ( isset( $_GET["scherm"] ) )
    {
        $schermdeel = $_GET["scherm"];
    }
}

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    
    $logger->dump( $_POST );

    if ( isset( $_POST["aanmaken"] ))
    {
        $logger->info( "Database aanmaken" );
        try
        {
            $schermdeel = "1";

            $validateOk = 0;
            $logger->info( "Test input" );

            $setVar = new SetVariable();
            $validateOk += $setVar->name( $createhost )
                ->onerror( $createhostErr )
                ->errormessage("Max. lengte is 255 posities")
                ->emptymessage("Vul het adres (URL) van uw provider in")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $createdb )
                ->onerror( $createdbErr )
                ->errormessage("Max. lengte is 255 posities")
                ->emptymessage("Vul de naam van de database in")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $rootuser )
                ->onerror( $rootuserErr )
                ->errormessage("Max. lengte is 255 posities")
                ->emptymessage("Vul het userid (bv. root) in dat de database kan maken")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $rootpassword )
                ->onerror( $rootpasswordErr )
                ->errormessage("Max. lengte is 255 posities")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $erasuser )
                ->onerror( $erasuserErr )
                ->errormessage("Max. lengte is 255 posities")
                ->emptymessage("Vul het userid in waaronder de database benaderd moet kunnen worden")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $eraspassword )
                ->onerror( $eraspasswordErr )
                ->errormessage("Max. lengte is 255 posities")
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( false )
                ->go();

            $logger->info( "Input getest" );

            if ( !file_exists( $sqlfile ) )
            {
                $createErr = "Kan " . $sqlfile ." niet laden";
                $validateOk += 99;
            }

            if ( $validateOk == 0 )
            {
                $logger->info( "Input ok" );
                $conn = mysqli_connect( $createhost, $rootuser, $rootpassword );

                if(mysqli_connect_errno()) 
                {
                    $createhostErr ="Connectie met deze database is mislukt voor dit userid/password: " . mysqli_connect_error() . " - " . mysqli_connect_errno();
                }
                else
                {
                    $logger->info( "Connected" );
    
                    $result = mysqli_query($conn, 'CREATE DATABASE testDB');
                    if (!$result)
                    {
                        $createhostErr ="U heeft geen CREATE privilege in deze omgeving. De ERAS database kan niet aangemaakt worden.";
                        $logger->error( "Create error" );                        
                    }
                    else
                    {
                        if ( !mysqli_query($conn, 'DROP DATABASE testDB') )
                        {
                            $logger->error( "Drop testdatabase error: " . mysqli_error($conn) );                        
                        }
                        else if( !mysqli_query($conn, 'CREATE DATABASE ' . $createdb . ' DEFAULT CHARACTER SET utf8mb4;') )
                        {
                            $createErr = "Create database " . $createdb . " is mislukt: " . mysqli_error($conn);
                            $logger->error( "Create database " . $createdb . " is mislukt: " . mysqli_error($conn) );                        
                        }
                        else if ( !mysqli_query($conn, "GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,INDEX,ALTER,CREATE TEMPORARY TABLES ON " . $createdb . ".* TO " . $erasuser . "@" . $createhost . " IDENTIFIED BY '" . $eraspassword . "';") ) 
                        {
                            $createErr = "GRANT toegang is mislukt: " . mysqli_error($conn);
                            $logger->error( "GRANT toegang is mislukt: " . mysqli_error($conn) );                        
                        }
                        else
                        {
                            $logger->info( "Database " . $createdb . " is aangemaakt" );                        
                            $sql = file_get_contents( $sqlfile );
            
                            /* execute multi query */
                            $result = mysqli_multi_query($conn, $sql);
                            if( $result )
                            {
                                $logger->info( "Database geladen." );
                                $schermdeel = "3";
                            }
                            else
                            {
                                $logger->error( "Laden database is mislukt: " . mysqli_error($conn) );
                                $createErr = "Laden database is mislukt: " . mysqli_error($conn);
                            }
                        }
                    }
                }
            }
            else
            {
                $logger->error( "Input niet ok: " .$validateOk );
            }
        }
        catch(Exception $ex)
        {
            $hostnameErr = "Er is een exceptie opgetreden: " . $ex->getMessage();
            $logger->error( "Exceptie " . $ex->getMessage() );
        }
    }
    else if ( isset( $_POST["laden"] ) )
    {
        $schermdeel = "2";
        try
        {
            $validateOk = 0;

            $setVar = new SetVariable();
            $validateOk += $setVar->name( $hostname )
                ->onerror( $hostnameErr )
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $dbname )
                ->onerror( $dbnameErr )
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $userid )
                ->onerror( $useridErr )
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $password )
                ->onerror( $passwordErr )
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( false )
                ->go();

            if ( !file_exists( $sqlfile ) )
            {
                $createErr = "Kan " . $sqlfile . " niet laden";
                $validateOk += 99;
            }

            if ( $validateOk == 0 )
            {
                $logger->info( "Input ok" );
                $conn = mysqli_connect( $hostname, $userid, $password, $dbname );

                if(mysqli_connect_errno()) 
                {
                    $createhostErr ="Connectie met deze database is mislukt voor dit userid/password: " . mysqli_connect_errno();
                }
                else
                {
                    $logger->info( "Connected" );
    
                    $sql = file_get_contents( $sqlfile );
    
                    /* execute multi query */
                    $result = mysqli_multi_query($conn, $sql);
                    if( $result )
                    {
                        $logger->info( "Database geladen." );
                        alert("De database is met succes aangemaakt en geladen.");
                        $schermdeel = 3;
                    }
                    else
                    {
                        $logger->error( "Laden database is mislukt: " . mysqli_error($conn) );
                    }
                }
            }
            else
            {
                $logger->error( "Input niet ok: " .$validateOk );
            }
        }
        catch(Exception $ex)
        {
            $hostnameErr = "Er is een exceptie opgetreden: " . $ex->getMessage();
            $logger->error( "Exceptie " . $ex->getMessage() );
        }
    }
    else if ( isset( $_POST["rootpw"] ) )
    {
        $logger->dump( $_SESSION );
        $comesFrom = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $logger->debug( $comesFrom );
        
        $comesFrom = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?scherm=3";
        $logger->debug( $comesFrom );

        $_SESSION['referer'] = $comesFrom;

        header( "Location: login.php?uid=root" );
        exit;
    }
    else if ( isset( $_POST["instellingen"] ) )
    {
        $logger->dump( $_SESSION );
        $comesFrom = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $logger->debug( $comesFrom );
        
        $comesFrom = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?scherm=3";
        $logger->debug( $comesFrom );

        $_SESSION['referer'] = $comesFrom;

        $_SESSION['settings'] = '1';
        header( "Location: settings.php" );
        exit;
    }
    else if ( isset( $_POST["gebruikers"] ) )
    {
        $logger->dump( $_SESSION );
        $comesFrom = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $logger->debug( $comesFrom );
        
        $comesFrom = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?scherm=3";
        $logger->debug( $comesFrom );

        $_SESSION['referer'] = $comesFrom;

        $_SESSION['gebruikers'] = '1';
        header( "Location: gebruiker_opvoeren.php" );
        exit;
    }
    else if ( isset( $_POST["klaar"] ) )
    {
        $logger->dump( $_SESSION );
        $comesFrom = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $logger->debug( $comesFrom );
        
        $comesFrom = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?scherm=3";
        $logger->debug( $comesFrom );

        session_destroy();

        header( "Location: index.php" );
        exit;
    }

} // POST

$logger->debug( "Voor autorisatie" );
$autorisatie = new Autorisatie();
if ( $autorisatie->check( AUTORISATIE_STATUS_ROOT ) )
{
    $rootchanged = "1";
}
$logger->debug( "Voor settings" );
if ( isset( $_SESSION['settings']) )
{
    $settingschanged = "1";
}
$logger->debug( "Voor gebruikers" );
if ( isset( $_SESSION['gebruikers']) )
{
    $userschanged = "1";
}
$smarty->assign( "hostname", $hostname );
$smarty->assign( "dbname", $dbname );
$smarty->assign( "userid", $userid );
$smarty->assign( "useridErr", $useridErr );
$smarty->assign( "password", $password );
$smarty->assign( "passwordErr", $passwordErr );
$smarty->assign( "erasuser", $erasuser );
$smarty->assign( "erasuserErr", $erasuserErr );
$smarty->assign( "eraspassword", $eraspassword );
$smarty->assign( "eraspasswordErr", $eraspasswordErr );
$smarty->assign( "createhost", $createhost );
$smarty->assign( "createhostErr", $createhostErr );
$smarty->assign( "createdb", $createdb );
$smarty->assign( "createdbErr", $createdbErr );
$smarty->assign( "createErr", $createErr );
$smarty->assign( "rootuser", $rootuser );
$smarty->assign( "rootuserErr", $rootuserErr );
$smarty->assign( "rootpassword", $rootpassword );
$smarty->assign( "rootpasswordErr", $rootpasswordErr);
$smarty->assign( "rootchanged", $rootchanged );
$smarty->assign( "settingschanged", $settingschanged );
$smarty->assign( "userschanged", $userschanged );
$smarty->assign( "hostnameErr", $hostnameErr );
$smarty->assign( "dbnameErr", $dbnameErr );
$smarty->assign( "schermdeel", $schermdeel );
$smarty->display( 'install.tpl' );
