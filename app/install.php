<?php
/**
 * System      ERAS
 * Module      install
 * Doel        Installatie en configuratie
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       22-10-2020
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
$poortnummer = "3306";
$userid = "";
$password = "";
$createdb = "eras";
$createdbErr = "";
$createhost = "";
$createhostErr = "";
$createport = "3306";
$createportErr = "";
$createErr = "";
$rootuser = "";
$rootpassword = "";
$erasuser = "erasuser";
$eraspassword = "";
$hostnameErr = "";
$dbnameErr = "";
$poortnummerErr = "";
$useridErr = "";
$passwordErr = "";
$rootuserErr = "";
$rootpasswordErr = "";
$erasuserErr = "";
$eraspasswordErr = "";
$rootchanged = "0";
$settingschanged = "0";
$userschanged = "0";
$installDelete = "0";

$presentie = array();
$isOk = true;

$sqlfile = '../eras_init.sql';

$schermdeel = "0";

error_reporting(E_ERROR | E_PARSE);

$history = new History();
$sessie = new Sessie();

$logger = new Logger();
$logger->level( LOGLEVEL );

function dir_writable( $directory )
{
    // Als de directory niet bestaat, probeer hem dan aan te maken.
    $dirExists     = is_dir($directory) || (mkdir($directory, 0774, true) && is_dir($directory));
    $dirIsWritable = false;
    if ($dirExists && is_writable($directory)) 
    {
        $tempFile = $directory . '/dummy.txt';
        $res = file_put_contents($tempFile, 'test');
        $dirIsWritable = $res !== false;
        @unlink($tempFile);
    }
    return $dirIsWritable;
}

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    $presentie = array();

    // Check PHP version
    $tekst = "PHP is minstens versie 7.3";
    if ( version_compare( phpversion(), '7.3', '<') ) 
    {
        $phpPresent = false;
        array_push( $presentie, array($tekst . "<br/>" . phpversion(), "0") );
    }
    else
    {
        $phpPresent = true;
        array_push( $presentie, array($tekst, "1") );
    }
    
    $tekst = "MySQL interface aanwezig";
    try
    {
        if ( mysqli_init( ) != null )
        {
            $mysqlPresent = true;
            array_push( $presentie, array($tekst, "1") );
        }
        else
        {
            array_push( $presentie, array($tekst, "0") );
        }
    }
    catch( Exception $ex )
    {
        $mysqlPresent = false;
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan CONFIG directory schrijven";
    if ( dir_writable( CONFIG_DIRNAME ) ) 
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Initialisatie config_ini.php";
    if ( !file_exists( CONFIG_FILENAME ) )
    {
        copy( CONFIG_DIRNAME."/config_ini_dist.php", CONFIG_FILENAME );
    }
    if ( file_exists( CONFIG_FILENAME ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $ini = parse_ini_file( CONFIG_FILENAME, true );

    $tekst = "Kan LOG directory schrijven";
    if ( dir_writable( $ini['settings']['log_directory'] ) ) 
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan TEMP directory schrijven";
    if ( dir_writable( $ini['settings']['temp_directory'] ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan IMAGE directory schrijven";
    if ( dir_writable( $ini['settings']['image_directory'] ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan FACTUREN directory schrijven";
    if ( dir_writable( $ini['settings']['facturen_directory'] ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan CSS directory schrijven";
    if ( dir_writable( "css" ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan TEMPLATE directory schrijven";
    if ( dir_writable("smarty/templates_c" ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan ICONS directory schrijven";
    if ( dir_writable("res/icons" ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $tekst = "Kan CACHE directory schrijven";
    if ( dir_writable( "smarty/cache" ) )
    {
        array_push( $presentie, array($tekst, "1") );
    }
    else
    {
        array_push( $presentie, array($tekst, "0") );
    }

    $logger->dump( $presentie );
//    exit;

    $isOk = true;
    for( $i = 0; $i < count( $presentie); $i++ )
    {
        if ( $presentie[$i][1] == 0 )
        {
            $isOk = false;
            $createErr = "<br/>Niet alle controles zijn succesvol. Installatie kan niet verder.<br/>";
            break;
        }
    }

    $history->set( "?scherm=3" );
    if ( isset( $_GET["scherm"] ) )
    {
        $schermdeel = $_GET["scherm"];
    }
}

if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    if ( isset( $_POST["verder"] ))
    {
        $schermdeel = "1";
    }
    else if ( isset( $_POST["aanmaken"] ))
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
            $validateOk += $setVar->name( $createport )
                ->onerror( $createportErr )
                ->errormessage("Poortnummer ligt tussen 100 en 65535, default is 3306")
                ->emptymessage("Vul het poortnummer in, default is 3306")
                ->defaultvalue( "3306" )
                ->validator( v::numericVal()->min(100)->max( 65535 ) )
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
                ->noHtmlCleaning()
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
                ->noHtmlCleaning()
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
                $conn = mysqli_connect( $createhost, $rootuser, $rootpassword, "", $createport );

                if(mysqli_connect_errno()) 
                {
                    $createhostErr ="Connectie met deze host is mislukt voor dit userid/password: " . mysqli_connect_error() . " - " . mysqli_connect_errno();
                    $logger->error( $createhostErr );
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

                            if( $sql === FALSE )
                            {
                                $createErr = "Kan SQL bestand " . $sqlfile . " niet lezen.";
                            }
                            else
                            {
                                /* execute multi query */
                                $result = mysqli_multi_query($conn, $sql);
                                if( $result )
                                {
                                    $logger->info( "Database geladen." );
                                    
                                    $fp = fopen( DATABASE_CONFIG_FILENAME, 'w' );
                                    fprintf( $fp, '<?php' . "\n" );
                                    fprintf( $fp, '#' . "\n" );
                                    fprintf( $fp, 'define("DB_VERSION_MAJOR", 0);' . "\n" );
                                    fprintf( $fp, 'define("DB_VERSION_MINOR", 91);' . "\n" );
                                    fprintf( $fp, '#' . "\n" );
                                    fprintf( $fp, 'define("DB_HOST", "%s");' . "\n", $createhost );
                                    fprintf( $fp, 'define("DB_NAME", "%s");' . "\n", $createdb );
                                    fprintf( $fp, 'define("DB_PORT", "%s");' . "\n", $createport );
                                    fprintf( $fp, 'define("DB_USER", "%s");' . "\n", $erasuser );
                                    fprintf( $fp, 'define("DB_PASSWORD", "%s");' . "\n", $eraspassword  );
                                    fclose( $fp );

                                    alert("De database is met succes aangemaakt en geladen.");

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
            $validateOk += $setVar->name( $poortnummer )
                ->onerror( $poortnummerErr )
                ->validator( v::numericVal()->min(100)->max( 65535 ) )
                ->required( true ) 
                ->go();
            $validateOk += $setVar->name( $userid )
                ->onerror( $useridErr )
                ->validator( v::alwaysValid()->length( 1, 255 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $password )
                ->onerror( $passwordErr )
                ->noHtmlCleaning()
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
                ini_set('display_errors',1);
                error_reporting(E_ALL);

                $logger->info( "Input ok" );
                $conn = mysqli_connect( $hostname, $userid, $password, $dbname, $poortnummer );

                if(mysqli_connect_errno()) 
                {
                    if ( mysqli_connect_errno() == 2002 )
                    {
                        $poortnummerErr ="Connectie met deze database is mislukt op dit adres/poortnummer: " . mysqli_connect_error() . " - " . mysqli_connect_errno();
                    }
                    else if ( mysqli_connect_errno() == 1045 )
                    {
                        $passwordErr = "Connectie met deze database is mislukt voor dit userid/password: " . mysqli_connect_error() . " - " . mysqli_connect_errno();
                    }
                    else
                    {
                        $createErr = "Connectie met database is mislukt: errno="  . mysqli_connect_error() . " - " . mysqli_connect_errno();
                    }
                }
                else
                {
                    $logger->info( "Connected" );

                    $logger->debug( "Aantal tabellen: " . mysqli_num_rows( mysqli_query( $conn,"SHOW TABLES LIKE 'fb_system'") )  );

                    if( mysqli_num_rows( mysqli_query( $conn,"SHOW TABLES LIKE 'fb_%'") ) ) 
                    {
                        $createErr = "Deze database is niet leeg. We hebben een lege database nodig.";
                    } 
                    else 
                    {
                        $sql = file_get_contents( $sqlfile );
    
                        if( $sql === FALSE )
                        {
                            $createErr = "Kan SQL bestand " . $sqlfile . " niet lezen.";
                        }
                        else
                        {
                            /* execute multi query */
                            $result = mysqli_multi_query($conn, $sql);
                            if( $result )
                            {
                                $fp = fopen( DATABASE_CONFIG_FILENAME, 'w' );
                                fprintf( $fp, '<?php' . "\n" );
                                fprintf( $fp, '#' . "\n" );
                                fprintf( $fp, 'define("DB_VERSION_MAJOR", 0);' . "\n" );
                                fprintf( $fp, 'define("DB_VERSION_MINOR", 91);' . "\n" );
                                fprintf( $fp, '#' . "\n" );
                                fprintf( $fp, 'define("DB_HOST", "%s");' . "\n", $hostname );
                                fprintf( $fp, 'define("DB_NAME", "%s");' . "\n", $dbname );
                                fprintf( $fp, 'define("DB_PORT", "%s");' . "\n", $poortnummer );
                                fprintf( $fp, 'define("DB_USER", "%s");' . "\n", $userid );
                                fprintf( $fp, 'define("DB_PASSWORD", "%s");' . "\n", $password  );
                                fclose( $fp );

                                $logger->info( "Database geladen." );
                                alert("De database is met succes geladen.");
                                $schermdeel = 3;
                            }
                            else
                            {
                                $createErr = "Laden database is mislukt: " . mysqli_error($conn);
                                $logger->error( "Laden database is mislukt: " . mysqli_error($conn) );
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

        unlink( "install.php" );
        session_destroy();

        if ( file_exists( "install.php" ) )
        {
            alertAndGo("Verwijderen install.php is mislukt. U kunt dit alsnog zelf doen.", "index.php");
            exit;
        }

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
if ( file_exists( "install.php" ) )
{
    $installDelete = "0";
}
else
{
    $installDelete = "1";
}
$smarty->assign( "hostname", $hostname );
$smarty->assign( "dbname", $dbname );
$smarty->assign( "poortnummer", $poortnummer );
$smarty->assign( "poortnummerErr", $poortnummerErr );
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
$smarty->assign( "createport", $createport );
$smarty->assign( "createportErr", $createportErr );
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
$smarty->assign( "installDelete", $installDelete );
$smarty->assign( "schermdeel", $schermdeel );
$smarty->assign( "presentie", $presentie );
$smarty->assign( "isOk", $isOk );

$smarty->display( 'install.tpl' );
