<?php
/**
 * System      ERAS
 * Module      Utilities
 * Doel        Hulproutines en klassen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       18-09-2019
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
require_once 'database_config.php';
require_once DEBUG_CONFIG_FILENAME;

use \fb_model\fb_model\Contactlog;
use \fb_model\fb_model\SystemQuery;
use \Propel\Runtime\Propel;

class SetVariable
{
    private $name = null;
    private $errorName = null;
    private $postName = null;
    private $required = false;
    private $validator = null;
    private $format = null;
    private $defaultValue = null;
    private $hasDefault = false;
    private $isEmpty = false;
    private $failMessage = null;
    private $emptyMessage = null;
    private $errorSet = false;
    private $htmlCleaning = true;
    private $errorNumber = 0;
    private $logger = null;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }

    public static function make()
    {
        $setVar = new SetVariable();
        return $setVar;
    }

    public function name( &$variable, $scope = false )
    {
        $this->name = &$variable;
        $this->postName = variableName( $variable, $scope );
        return $this;
    }

    public function nameval( $variable )
    {
        $this->name = $variable;
        $this->postName = $variable;
        return $this;
    }

    public function onerror( &$errvar )
    {
        $this->errorName = &$errvar;
        $this->errorSet = true;
        return $this;
    }

    public function required( $req = true )
    {
        $this->required = $req;
        return $this;
    }

    public function validator( $valid )
    {
        $this->validator = $valid;
        return $this;
    }

    public function defaultvalue( $def )
    {
        $this->defaultValue = $def;
        $this->hasDefault = true;
        return $this;
    }

    public function formatter( $anon )
    {
        $this->format = $anon;
        return $this;
    }

    public function noHtmlCleaning()
    {
        $this->htmlCleaning = false;
        return $this;
    }

    public function errormessage( $msg )
    {
        $this->failMessage = $msg;
        return $this;
    }

    public function emptymessage( $msg )
    {
        $this->emptyMessage = $msg;
        return $this;
    }

    private function reset()
    {
        //$this->name = NULL;
        //$this->errorName = NULL;
        $this->postName = null;
        $this->required = false;
        $this->hasDefault = false;
        $this->isEmpty = false;
        $this->defaultValue = null;
        $this->validator = null;
        $this->format = null;
        $this->failMessage = null;
        $this->emptyMessage = null;
        $this->errorSet = false;
        $this->htmlCleaning = true;
    }

    private function setError( $message )
    {
        if ( $this->errorSet )
        {
            $this->errorName = $message;
        }
    }

    public function go()
    {
        if ( $this->errorNumber == 0 )
        {
            $this->errorNumber = 1;
        }
        else
        {
            $this->errorNumber *= 2;
        }

        if ( !isset( $_POST[$this->postName] ) )
        {
            if ( !$this->hasDefault )
            {
                $this->logger->debug( 'Variabele ' . $this->postName . ' is niet aanwezig in POST.' );

                if ( $this->required == true )
                {
                    //throw new Exception( );
                    if ( $this->emptyMessage != null )
                    {
                        $this->setError( $this->emptyMessage );
                    }
                    else
                    {
                        $this->setError( "'" . $this->postName . "' is niet opgegeven." );
                    }
                    $this->reset();
                    return $this->errorNumber;
                }
                else
                {
                    $this->reset();
                    return 0;
                }
            }
            else
            {
                $this->logger->debug( 'Variabele ' . $this->postName . ' is niet aanwezig in POST. Gebruik opgegeven defaultwaarde.' );
                $this->isEmpty = true;
            }
        }
        elseif ( empty( $_POST[$this->postName] ) && $_POST[$this->postName] != '0' )
        {
            if ( !$this->hasDefault )
            {
                if ( $this->required == true )
                {
                    $this->logger->debug( 'Variabele ' . $this->postName . ' is leeg en zou gevuld moeten zijn.' );
                    if ( $this->emptyMessage != null )
                    {
                        $this->setError( $this->emptyMessage );
                    }
                    else
                    {
                        $this->setError( "'" . $this->postName . "' is niet ingevuld." );
                    }
                    $this->reset();
                    return $this->errorNumber;
                }
                else
                {
                    $this->logger->debug( 'Variabele ' . $this->postName . ' is leeg maar is niet verplicht.' );
                    $this->reset();
                    return 0;
                }
            }
            else
            {
                $this->logger->debug( 'Variabele ' . $this->postName . ' is leeg. Gebruik opgegeven defaultwaarde.' );
                $this->isEmpty = true;
            }
        }
        else
        {
            if ( is_array( $_POST[$this->postName] ) )
            {
                // Variable is an array. No further validity checks possible.
                return 0;
            }
        }

        if ( $this->isEmpty && $this->hasDefault )
        {
            $this->name = $this->defaultValue;
        }
        else
        {
            if ( $this->htmlCleaning )
            {
                $this->name = cleanInput( $_POST[$this->postName] );
            }
            else
            {
                $this->name = $_POST[$this->postName];
            }
        }

        // remove leading and trailing blanks
        $this->name = trim( $this->name );

        if ( $this->format != null )
        {
            $this->name = ( $this->format )( $this->name );
        }

        if ( $this->validator != null )
        {
            if ( $this->validator->validate( $this->name ) )
            {
                $this->logger->debug( 'Variabele ' . $this->postName . ' validate OK.' );
                $this->setError( "" );
                $this->reset();
                return 0;
            }
            else
            {
                $this->logger->debug( 'Variabele ' . $this->postName . ' validate niet OK.' );
                if ( $this->failMessage != null )
                {
                    $this->setError( $this->failMessage );
                }
                else
                {
                    $this->setError( "'" . $this->postName . "' voldoet niet aan de eisen" );
                }

                $this->reset();
                return $this->errorNumber;
            };
        }

        $this->reset();

    }
}

function urlExists( $url )
{
    $file_headers = @get_headers($url);
    if( $file_headers && strpos( $file_headers[0], '200') ) 
    {
        return true;
    }
    else 
    {
        return false;
    }
}

function baseUrlExists( $url )
{
    $file_headers = @get_headers($url . "/app");
    if( $file_headers && strpos( $file_headers[0], '200') ) 
    {
        return true;
    }
    else 
    {
        return false;
    }
}

function dirIsWritable( $directory, $create = true )
{
    // Als de directory niet bestaat, probeer hem dan aan te maken.
    if ( $create )
    {
        $dirExists     = is_dir($directory) || (mkdir($directory, 0774, true) && is_dir($directory));
    }
    else
    {
        $dirExists     = is_dir($directory);
    }
    $dirWritable = false;
    if ($dirExists && is_writable($directory)) 
    {
        $tempFile = $directory . '/dummy.txt';
        $res = file_put_contents($tempFile, 'test');
        $dirWritable = $res !== false;
        @unlink($tempFile);
    }
    return $dirWritable;
}

class Logger
{
    private $logLevel = LOGLEVEL_ERROR;
    private $extraText = "";
    private $logfilename = "";

    public function __construct( $text = "" )
    {
        $ini = parse_ini_file( CONFIG_FILENAME, true );
        $this->logfilename = $ini['settings']['log_directory'] . '/' . LOGFILE_NAME;

        if ( $text == "" )
        {
            $this->extraText = "";
        }
        else
        {
            $this->extraText = " " . $text . ", ";
        }
    }

    public function level( $level )
    {
        $this->logLevel = $level;
    }

    public function verbose( $regel )
    {
        if ( $this->logLevel <= LOGLEVEL_VERBOSE )
        {
            $logName = $this->getLogName();
            $logMsg = date( "d-m-Y H:i:s" ) . " VRBOSE " . $logName . $this->extraText . $regel . PHP_EOL;
            file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
        }
    }

    public function dump( &$vardump )
    {
        // Only dump in debug mode
        if ( $this->logLevel <= LOGLEVEL_DUMP )
        {
            $logName = $this->getLogName();
            $logMsg = date( "d-m-Y H:i:s" ) . " DUMP  " . $logName . $this->extraText . " $" . variableName( $vardump ) . PHP_EOL . var_export( $vardump, true ) . PHP_EOL;
            file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
        }
    }

    public function debug( $regel )
    {
        if ( $this->logLevel <= LOGLEVEL_DEBUG )
        {
            $logName = $this->getLogName();
            //$logMsg = date( "d-m-Y H:i:s" ) . " DEBUG " . $logName . $this->extraText . $regel . PHP_EOL;
            $logMsg = date( "d-m-Y H:i:s" ) . " DEBUG " . sprintf( " % 4.1fMb ", round( memory_get_usage() / 1048576.0, 1 ) ) . $logName . $regel . PHP_EOL;
            file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
        }
    }

    public function info( $regel )
    {
        if ( $this->logLevel <= LOGLEVEL_INFO )
        {
            $logName = $this->getLogName();
            $logMsg = date( "d-m-Y H:i:s" ) . " INFO  " . $logName . $this->extraText . $regel . PHP_EOL;
            file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
        }
    }

    public function warning( $regel )
    {
        if ( $this->logLevel <= LOGLEVEL_WARNING )
        {
            $logName = $this->getLogName();
            $logMsg = date( "d-m-Y H:i:s" ) . " WARNG " . $logName . $this->extraText . $regel . PHP_EOL;
            file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
        }
    }

    public function error( $regel )
    {
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " ERROR " . $logName . $this->extraText . $regel . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function security( $regel )
    {
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " SECUR " . $logName . $this->extraText . $regel . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function errordump( &$vardump )
    {
        // Always dump in case of error
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " EDUMP " . $logName . $this->extraText . " $" . variableName( $vardump ) . PHP_EOL . var_export( $vardump, true ) . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function setFilename( $filename )
    {
        $this->logfilename = $filename;
    }

    public function getFilename()
    {
        return $this->logfilename;
    }

    private function getLogName()
    {
        return pathinfo( debug_backtrace()[1]['file'] )['basename'] . " " . debug_backtrace()[1]['line'] . ': ';
    }

    public function isDebug()
    {
        if ( $this->logLevel <= LOGLEVEL_DEBUG )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

class Sessie
{
    public function __construct()
    {
        if ( session_status() === PHP_SESSION_NONE )
        {
            $this->startEnIniSessie();
        }

        if ( isset( $_SESSION['session_time'] ) &&
            ( time() - $_SESSION['session_time'] > SESSIE_GELDIGHEID_SECONDEN ) )
        {
            echo "Sessie is verlopen.<br/>";
            $autorisatie = new Autorisatie();
            $isKlant = $autorisatie->check( AUTORISATIE_STATUS_KLANT, true );

            session_destroy();
            $this->startEnIniSessie();
            if ( $isKlant )
            {
                //alertAndGo( "Uw sessie is verlopen. Graag opnieuw aanmelden.", "registreer.php" );
                header( "Location:registreer.php" );
            }
            else
            {
                //alert( "Uw sessie is verlopen. Graag opnieuw aanmelden." );
                header( "Location:login.php" );
            }
        }

        //    session_regenerate_id(true);
        $_SESSION['session_time'] = time();
    }

    private function startEnIniSessie()
    {
        ini_set( 'session.use_strict_mode', 1 );
        ini_set( 'session.use_only_cookies', 1 );
        ini_set( 'session.use_trans_sid', 0 );
        // Volgende twee zorgt ervoor dat de 'terug' toets blijft werken
        //        ini_set( 'session.cache_limiter', 'public' );
        //        session_cache_limiter( false );
        session_start();
    }
}

class History
{
    private $logger = null;
    private $history = array();

    public function __construct()
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );

        if ( session_status() === PHP_SESSION_NONE )
        {
            $this->startEnIniSessie();
        }

        if ( isset( $_SESSION['history'] ) )
        {
            $this->history =  $_SESSION['history'];
        }

    }

    private function startEnIniSessie()
    {
        ini_set( 'session.use_strict_mode', 1 );
        ini_set( 'session.use_only_cookies', 1 );
        ini_set( 'session.use_trans_sid', 0 );
        // Volgende twee zorgt ervoor dat de 'terug' toets blijft werken
        //        ini_set( 'session.cache_limiter', 'public' );
        //        session_cache_limiter( false );
        session_start();
    }

    public function reset()
    {
        unset( $_SESSION['history'] );
        $this->history = array();
    }

    public function set( $argument = "" )
    {
        $huidige = strtok( $_SERVER["REQUEST_URI"], '?');

        $huidige = $huidige . $argument;

        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $this->logger->debug( "Set history: " . $huidige . ", vanuit " . $caller['file'] . ", regel " . $caller['line']);

        if ( sizeof($this->history) == 0 || $this->history[ sizeof( $this->history ) - 1  ] != $huidige )
        {
            $this->history[ sizeof( $this->history ) ] = $huidige;
            $_SESSION['history'] = $this->history;
            $this->logger->dump( $_SESSION['history'] );
        }
    }

    public function get( )
    {
        $nieuwe = "";
        $current = $_SERVER["REQUEST_URI"];
        $this->logger->debug( "Current: " . $current );
        do
        {
            $nieuwe = array_pop( $this->history );
            $this->logger->debug( "Pop: " . $current );
        }
        while ( $nieuwe == $current );

        $_SESSION['history'] = $this->history;
        $this->logger->dump( $_SESSION['history'] );
        $this->logger->debug( "Naar history: " . $nieuwe );
        return $nieuwe;
    }
}

class Autorisatie
{
    private $logger = null;
    private $isLoggedIn = false;
    private $userid = "";
    private $gebruikerid = "";
    private $routeIfNotAuth = "Refresh:0";
    private $locationIfNotAuth = "";
    private $rol = AUTORISATIE_STATUS_GEEN;
    private $comesFrom = "";
    private $omgeving = "";

    public function __construct()
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
        $this->comesFrom = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        try
        {
            $systeem = new Sysdb();
            $this->omgeving = $systeem->getNaam();
        }
        catch( Exception $ex )
        {
            // database bestaat nog niet of is niet toegankelijk.
            $this->omgeving = "TEMPORARY";
        }

        if ( session_status() == PHP_SESSION_NONE )
        {
            $this->logger->info( "**** SESSIE is niet gestart in " . $this->comesFrom . " ****" );
            $sessie = new Sessie();
        }

        $_SESSION["referer"] = $this->comesFrom;
        $this->logger->debug( $this->comesFrom );
        if ( isset( $_SESSION["auth-" . $this->omgeving] ) )
        {
            $auth = array();
            $auth = $_SESSION["auth-" . $this->omgeving];
            $this->isLoggedIn = $auth['isLoggedIn'];
            $this->rol = $auth['rol'];
            $this->gebruikerid = $auth["gebruikerid"];
            $this->userid = $auth['userid'];
        }
        $this->logger->debug( "Constructor Autorisatie gereed" );
        $this->logger->verbose( $_SESSION );
    }

    public function validate( $gevraagdeRol )
    {
        //        if ( !AUTORISATIE )
        //        {
        //            $this->logger->error( "**** Autorisatie controle is uitgeschakeld ****" );
        //            return TRUE;
        //        }

        $this->logger->debug( "Valideer gevraagde rol: " . $gevraagdeRol );

        if ( $this->isLoggedIn || $gevraagdeRol == 0 )
        {
            if ( $this->rol >= $gevraagdeRol )
            {
                $this->logger->debug( "Gevraagde rol (" . rolNaam( $gevraagdeRol ) . ") is akkoord. Huidige rol is " . rolNaam( $this->rol ) );
                //return TRUE;
            }
            else
            {
                $this->logger->security( "User " . $this->userid . " niet toegestaan. Rol is " . rolNaam( $this->rol ) . ", gevraagde rol is " . rolNaam( $gevraagdeRol ) . ", Adres:" . $_SERVER['REMOTE_ADDR'] );
                $_SESSION['HTTP_REFERER'] = $this->comesFrom;
                alertAndGo( 'U bent ingelogd, maar u heeft geen toestemming om deze functie te gebruiken. Voor deze functie moet u de rol -' . rolNaam( $gevraagdeRol ) . '- hebben.', $this->locationIfNotAuth );
                //header( $this->routeIfNotAuth );
                exit;
            }
        }
        else
        {
            $this->logger->security( "User anoniem niet toegestaan " . $_SERVER['REMOTE_ADDR'] );
            $_SESSION['HTTP_REFERER'] = $this->comesFrom;
            alertAndGo( "U bent niet ingelogd. Om deze functie te kunnen gebruiken moet u ingelogd zijn.", $this->locationIfNotAuth );
            //$_SESSION["referer"] = $this->comesFrom;
            // header( $this->routeIfNotAuth );
            exit;
        }
    }

    public function check( $gevraagdeRol, $equal = false )
    {
        if ( $equal )
        {
            if ( $this->rol == $gevraagdeRol )
            {
                $this->logger->debug( "Checking user " . $this->userid . ". Gevraagde rol (" . $gevraagdeRol . ") is gelijk aan huidige." );
                return true;
            }
            else
            {
                $this->logger->info( "Checking user " . $this->userid . ". Gevraagde rol (" . $gevraagdeRol . ") is niet gelijk aan huidige." );
                return false;
            }
        }
        else
        {
            if ( $this->rol >= $gevraagdeRol )
            {
                $this->logger->debug( "Checking user " . $this->userid . ". Gevraagde rol (" . $gevraagdeRol . ") is akkoord. Huidige rol is " . $this->rol );
                return true;
            }
            else
            {
                $this->logger->security( "Checking user " . $this->userid . ". Gevraagde toestemming niet toegestaan. Huidige rol is " . rolNaam( $this->rol ) . ", gevraagde rol is " . rolNaam( $gevraagdeRol ) . ", Adres:" . $_SERVER['REMOTE_ADDR'] );
                return false;
            }
        }
    }

    public function setNotAuth( $location )
    {
        if ( $location != null )
        {
            if ( strpos( strtoupper( $location ), 'REFRESH:' ) !== false || strpos( strtoupper( $location ), 'LOCATION:' ) !== false )
            {
                $this->routeIfNotAuth = $location;
                if ( strpos( strtoupper( $location ), 'REFRESH:' ) !== false )
                {
                    $this->locationIfNotAuth = "window.location.href";
                }
                else
                {
                    $this->locationIfNotAuth = str_replace( 'LOCATION:', '', strtoupper( $location ) );
                }
            }
            else
            {
                $this->routeIfNotAuth = "Location:" . $location;
                $this->locationIfNotAuth = $location;
            }

            $this->logger->debug( "Route if not authorised: " . $this->routeIfNotAuth );
//            $history = new History();
//            $history->set();
        }
    }

    public function getUserId()
    {
        if ( $this->isLoggedIn )
        {
            return $this->userid;
        }
        else
        {
            return null;
        }
    }

    public function getGebruikerId()
    {
        if ( $this->isLoggedIn )
        {
            return $this->gebruikerid;
        }
        else
        {
            return null;
        }
    }

    public function setUserId( $userid )
    {
        $auth = array();
        $auth = $_SESSION["auth-" . $this->omgeving];
        unset( $_SESSION["auth-" . $this->omgeving] );
        $auth['userid'] = $userid;
        $_SESSION["auth-" . $this->omgeving] = $auth;
        $this->userid = $userid;
    }

    public function getRol()
    {
        if ( $this->isLoggedIn )
        {
            return $this->rol;
        }
        else
        {
            return null;
        }
    }

    public function setRol( $rol )
    {
        $auth = array();
        $auth = $_SESSION["auth-" . $this->omgeving];
        unset( $_SESSION["auth-" . $this->omgeving] );
        $auth['rol'] = $rol;
        $_SESSION["auth-" . $this->omgeving] = $auth;
        $this->rol = $rol;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logOut()
    {
        $this->isLoggedIn = false;
        $this->rol = AUTORISATIE_STATUS_GEEN;
        $userid = $this->userid;
        $this->userid = "";
        unset( $_SESSION["auth-" . $this->omgeving] );
        $this->logger->security( "User " . $userid . " met succes uitgelogd." );
    }
}

class Sysdb
{
    private $naam = "";
    private $version_major = 0;
    private $version_minor = 0;
    private $otap = OTAP_ONTWIKKEL;
    private $debug = 0;
    private $organisatie_naam = "<Mijn Organisatie>";
    private $organisatie_mail = "postmaster@localhost";
    private $deploy_dir = '/mnt/data/deploy';

    public function __construct( $reset = false )
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );

        if ( session_status() == PHP_SESSION_NONE )
        {
            //$this->logger->error( "**** SESSIE is niet gestart in " . $this->comesFrom . " ****" );
            $sessie = new Sessie();
        }

        $con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
        if ( null === $con->query( "SET SESSION sql_mode='ALLOW_INVALID_DATES';" ) )
        {
            $this->logger->debug( "Accepteren invalid dates is mislukt." );
            throw new \RuntimeException( 'Failed to set MySQL global and session sql_mode' );
        }

        $sys = array();
        if ( !isset( $_SESSION["sysdb"] ) || $reset )
        {
            if ( $reset )
            {
                $this->logger->debug( "Reset opgegeven, systeemgegevens laden uit database" );
            }
            else
            {
                $this->logger->debug( "SYSDB sessievariabele niet gezet of debug, systeemgegevens laden uit database" );
            }
            try
            {
                $systeem = SystemQuery::create()->findOne();
                $sys['naam'] = $systeem->getNaam();
                $sys['version_major'] = $systeem->getVersionMajor();
                $sys['version_minor'] = $systeem->getVersionMinor();
                $sys['otap'] = $systeem->getOtap();
                $sys['debug'] = $systeem->getDebug();
                $sys['deploy_dir'] = $systeem->getDeployDirectory();
                $sys['db_version_major'] = $systeem->getDbVersionMajor();
                $sys['db_version_minor'] = $systeem->getDbVersionMinor();

                if ( $systeem->getDbVersionMajor() != DB_VERSION_MAJOR || $systeem->getDbVersionMinor() != DB_VERSION_MINOR )
                {
                    throw new Exception( "Onjuiste database versie. Verwacht " . DB_VERSION_MAJOR . "." . DB_VERSION_MINOR . ", gevonden " . $systeem->getDbVersionMajor() . "." . $systeem->getDbVersionMinor() . ". Systeem is gestopt." );
                }

                $ini = parse_ini_file( CONFIG_FILENAME, true );
                $sys['organisatie_naam'] = $ini['organisatie']['organisatienaam'];
                $sys['organisatie_mail'] = $ini['organisatie']['email'];

                $_SESSION["sysdb"] = $sys;
            }
            catch ( Exception $ex )
            {
                $this->logger->errordump( $ex );
                echo $ex->getMessage();
                alert( $ex->getMessage() );
                exit;
            }
        }

        $sys = $_SESSION["sysdb"];
        $this->naam = $sys['naam'];
        $this->version_major = $sys['version_major'];
        $this->version_minor = $sys['version_minor'];
        $this->otap = $sys['otap'];
        $this->debug = $sys['debug'];
        $this->organisatie_naam = $sys['organisatie_naam'];
        $this->organisatie_mail = $sys['organisatie_mail'];
        $this->deploy_dir = $sys['deploy_dir'];

        $this->logger->debug( "Constructor System gereed" );
        $this->logger->verbose( $_SESSION );
    }

    public function getNaam()
    {
        return $this->naam;
    }

    public function getVersionMajor()
    {
        return $this->version_major;
    }

    public function getVersionMinor()
    {
        return $this->version_minor;
    }

    public function getOtap()
    {
        return $this->otap;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function getDeployDirectory()
    {
        return $this->deploy_dir;
    }

    public function getOrganisatieNaam()
    {
        return $this->organisatie_naam;
    }

    public function getOrganisatieMail()
    {
        return $this->organisatie_mail;
    }
}

class Klantcontact
{
    private $persoonId = 0;
    private $userName = "";
    private $isValid = false;

    public function setPersoonId( $persoonId )
    {
        $this->persoonId = $persoonId;
        if ( $this->userName != "" )
        {
            $this->isValid = true;
        }
        else
        {
            $this->isValid = false;
        }
    }

    public function setUserName( $userName )
    {
        $this->userName = $userName;
        if ( $this->persoonId != 0 )
        {
            $this->isValid = true;
        }
        else
        {
            $this->isValid = false;
        }
    }

    public function write( $tekst )
    {
        if ( $this->isValid )
        {
            $contactLog = new Contactlog();
            $contactLog->setPersoonId( $this->persoonId );
            $contactLog->setTekst( $tekst );
            $contactLog->setGemaaktDoor( $this->userName );
            $contactLog->setGewijzigdDoor( $this->userName );
            $contactLog->save();
        }
    }
}

class Routing
{
    private $next = "";
    private $parms;

    public function __construct()
    {
        $this->parms = array();
        unset( $_SESSION["routing"] );
    }

    public function setNext( $next )
    {
        $this->next = $next;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setParameter( $key, $value )
    {
        $this->parms[$key] = $value;
    }

    public function getParameterArray()
    {
        return $this->parms;
    }

    public function getParameters()
    {
        $parameters = "";
        $first = true;
        foreach ( $this->parms as $key => $value )
        {
            if ( $first )
            {
                $parameters = '?';
                $parameters += $key . '=' . $value;
                $first = false;
            }
            else
            {
                $parameters = '&';
                $parameters += $key . '=' . $value;
            }

        }
        return $parameters;
    }

    public function go( $next = null )
    {
        if ( $next != null )
        {
            $this->next = $next;
        }

        $_SESSION["routing"] = $this;

        foreach ( $this->parms as $key => $value )
        {
            $_GET[$key] = $value;
        }
        header( "Location:router.php" );
        exit( 0 );
    }
}

function writeIniFile( $file, $array = [] )
{
    /**https://stackoverflow.com/Questions/5695145/how-to-read-and-write-to-an-ini-file-with-php
     * Write an ini configuration file
     *
     * @param string $file
     * @param array  $array
     * @return bool
     */
    // check first argument is string
    if ( !is_string( $file ) )
    {
        throw new \InvalidArgumentException( 'Function argument 1 must be a string.' );
    }

    // check second argument is array
    if ( !is_array( $array ) )
    {
        throw new \InvalidArgumentException( 'Function argument 2 must be an array.' );
    }

    // process array
    $data = array();
    foreach ( $array as $key => $val )
    {
        if ( is_array( $val ) )
        {
            $data[] = "[$key]";
            foreach ( $val as $skey => $sval )
            {
                if ( is_array( $sval ) )
                {
                    foreach ( $sval as $_skey => $_sval )
                    {
                        if ( is_numeric( $_skey ) )
                        {
                            $data[] = $skey . '[] = ' . ( is_numeric( $_sval ) ? $_sval : ( ctype_upper( $_sval ) ? $_sval : '"' . $_sval . '"' ) );
                        }
                        else
                        {
                            $data[] = $skey . '[' . $_skey . '] = ' . ( is_numeric( $_sval ) ? $_sval : ( ctype_upper( $_sval ) ? $_sval : '"' . $_sval . '"' ) );
                        }
                    }
                }
                else
                {
                    $data[] = $skey . ' = ' . ( is_numeric( $sval ) ? $sval : ( ctype_upper( $sval ) ? $sval : '"' . $sval . '"' ) );
                }
            }
        }
        else
        {
            $data[] = $key . ' = ' . ( is_numeric( $val ) ? $val : ( ctype_upper( $val ) ? $val : '"' . $val . '"' ) );
        }
        // empty line
        $data[] = null;
    }

    // open file pointer, init flock options
    $fp = fopen( $file, 'w' );
    $retries = 0;
    $max_retries = 100;

    if ( !$fp )
    {
        return false;
    }

    // loop until get lock, or reach max retries
    do
    {
        if ( $retries > 0 )
        {
            usleep( rand( 1, 5000 ) );
        }
        $retries += 1;
    } while ( !flock( $fp, LOCK_EX ) && $retries <= $max_retries );

    // couldn't get the lock
    if ( $retries == $max_retries )
    {
        return false;
    }

    // got lock, write data
    fwrite( $fp, implode( PHP_EOL, $data ) . PHP_EOL );

    // release lock
    flock( $fp, LOCK_UN );
    fclose( $fp );

    return true;
}

function tijdVerschil( $datum1, $datum2 )
{
    $datetime1 = strtotime( $datum1 );
    $datetime2 = strtotime( $datum2 );

    $secs = $datetime2 - $datetime1; // == <seconds between the two times>
    return $secs;
}

function datumVerschil( $datum1, $datum2 )
{
    $datetime1 = strtotime( $datum1 );
    $datetime2 = strtotime( $datum2 );

    $secs = $datetime2 - $datetime1; // == <seconds between the two times>
    $days = $secs / 86400;
    return $days;
}

function isNLPostcode( $postcode )
{
    $patroon = '/^[1-9][0-9]{3}[\s]?[A-Za-z]{2}$/i';
    if ( preg_match( $patroon, $postcode ) )
    {
        return true;
    }
    return false;
}

function printField( $codeIn )
{
    echo "<br/>" . $codeIn . "<br/>";
}

// Formatters
function stripHtml( $codeIn )
{
    $code = preg_replace( '/[^A-Za-z0-9 <>&]/', '', $codeIn );

    return $code;
}

function postcode( $codeIn )
{
    $code = strtoupper( $codeIn );
    if ( isNLPostcode( $code ) )
    {
        // Nederlandse postcodes zonder spatie opslaan
        $code = str_replace( ' ', '', $code );
    }
    return $code;
}

function prijs( $codeIn )
{
    if ( $codeIn == '0' )
    {
        return '0.00';
    }
    $code = str_replace( ',', '.', $codeIn );
    if ( strpos( $code, '.' ) === false )
    {
        $code = $code . ".00";
    }
    return $code;
}

function stripTekens( $data )
{
    $data = preg_replace( "/[^A-Za-z0-9 ]/", '', $data );
    return $data;
}

function stripQuotes( $data )
{
    $data = str_replace( '"', '', $data );
    return $data;
}

function trimDir( $dirName )
{
    $dirName = rtrim($dirName, '/\\');
    return $dirName;
}
// /Formatters

function rondNul( $bedrag )
{
    if ( abs($bedrag) < 0.00001 )
    {
        return "0.00";
    }
    else
    {
        return $bedrag;
    }
}

function geld( $bedrag )
{
    return "€ " . number_format( $bedrag, 2, ",", "." );
}

function geldAnsi( $bedrag )
{
    return chr( 128 ) . " " . number_format( $bedrag, 2, ",", "." );
}

function cleanInput( $data )
{
    if ( is_array( $data ) )
    {
        return $data;
    }
    $data = trim( $data );
    $data = stripslashes( $data );
    $data = htmlspecialchars( $data );
    return $data;
}

function cleanOptieNaam( $tekst )
{
    $naam = str_replace( " ", "_", $tekst );
    $naam = str_replace( ".", "_", $naam );
    return $naam;
}

function getGetVar( &$variable, $scope = false )
{
    $name = &$variable;
    $getName = variableName( $variable, $scope );

    if ( !isset( $_GET[$getName] ) )
    {
        $name = null;
        return null;
    }
    else
    {
        $name = $_GET[$getName];
        return $_GET[$getName];
    }
}

function getGetVarEx( &$variable, $scope = false )
{
    $name = &$variable;
    $getName = variableName( $variable, $scope );

    if ( !isset( $_GET[$getName] ) )
    {
        $name = null;
        throw new Exception( 'GET-variabele ' . $getName . ' is niet gezet.' );
    }
    else
    {
        $name = $_GET[$getName];
        return $_GET[$getName];
    }
}

function getInschrijvingVar( &$variable )
{
    $waarde = &$variable;
    $getName = variableName( $variable, false );

    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $inschrijving = $_SESSION['inschrijving'];
        if ( !empty( $inschrijving[$getName] ) )
        {
            return $inschrijving[$getName];
        }
        else
        {
            return $waarde;
        }
    }
}

function annuleringsverzekeringNaam( $code )
{
    switch ( $code )
    {
        case ANNULERINGSVERZEKERING_GEEN:
            return "geen";
        case ANNULERINGSVERZEKERING_GEWOON:
            return "gewoon";
        case ANNULERINGSVERZEKERING_ALLRISK:
            return "all-risk";
        default:
            return "???";
    }
}

function betaalwijzeNaam( $code )
{
    switch ( $code )
    {
        case BETAALWIJZE_IDEAL:
            return "iDeal";
        case BETAALWIJZE_CONTANT:
            return "contant";
        case BETAALWIJZE_INCASSO:
            return "incasso";
        case BETAALWIJZE_CREDITCARD:
            return "creditcard";
        case BETAALWIJZE_VOUCHER:
            return "voucher";
        case BETAALWIJZE_OVERSCHRIJVING:
            return "overschrijving";
        default:
            return "???";
    }
}

function evenementStatusNaam( $code )
{
    switch ( $code )
    {
        case EVENEMENT_STATUS_OPEN:
            return "open";
        case EVENEMENT_STATUS_VOL:
            return "vol";
        case EVENEMENT_STATUS_WACHT:
            return "wacht";
        case EVENEMENT_STATUS_GESLOTEN:
            return "gesloten";
        case EVENEMENT_STATUS_GEANNULEERD:
            return "geannuleerd";
        default:
            return "???";
    }
}

function inschrijvingStatusNaam( $code )
{
    switch ( $code )
    {
        case INSCHRIJVING_STATUS_OPEN:
            return "open";
        case INSCHRIJVING_STATUS_GEANNULEERD:
            return "geannuleerd";
        case INSCHRIJVING_STATUS_DEFINITIEF:
            return "definitief";
        default:
            return "???";
    }
}

function logLevelNaam( $code )
{
    switch ( $code )
    {
        case LOGLEVEL_VERBOSE:
            return "VERBOSE";
        case LOGLEVEL_DUMP:
            return "DUMP";
        case LOGLEVEL_DEBUG:
            return "DEBUG";
        case LOGLEVEL_INFO:
            return "INFO";
        case LOGLEVEL_WARNING:
            return "WARNING";
        case LOGLEVEL_ERROR:
            return "ERROR";
        default:
            return "???";
    }
}

function optieTypeNaam( $code )
{
    switch ( $code )
    {
        case OPTIETYPE_GETAL:
            return "Getal";
        case OPTIETYPE_KOPTEKST:
            return "Koptekst";
        case OPTIETYPE_AANTAL:
            return "Aantal";
        case OPTIETYPE_TEKSTVAK:
            return "Tekstvak";
        case OPTIETYPE_TEKSTREGEL:
            return "Tekstregel";
        case OPTIETYPE_KEUZE_RADIO:
            return "Radiobutton";
        case OPTIETYPE_VASTE_TEKST:
            return "Vaste tekst";
        case OPTIETYPE_KEUZE_JA_NEE:
            return "Ja/Nee";
        case OPTIETYPE_KEUZE_MEERDERE:
            return "Meerdere keuzes";
        case OPTIETYPE_AKKOORD:
            return "Instemming";
        case OPTIETYPE_VOORWAARDE:
            return "Voorwaarde";
            default:
            return "???";
    }
}

function otapNaam( $code )
{
    switch ( $code )
    {
        case OTAP_TEST:
            return "test";
        case OTAP_ONTWIKKEL:
            return "ontwikkel";
        case OTAP_ACCEPTATIE:
            return "acceptatie";
        case OTAP_PRODUCTIE:
            return "productie";
        default:
            return "???";
    }
}

function rolNaam( $code )
{
    switch ( $code )
    {
        case AUTORISATIE_STATUS_GEEN:
            return "geen";
        case AUTORISATIE_STATUS_KLANT:
            return "klant";
        case AUTORISATIE_STATUS_MEDEWERKER:
            return "medewerker";
        case AUTORISATIE_STATUS_SUPERVISOR:
            return "supervisor";
        case AUTORISATIE_STATUS_ADMINISTRATOR:
            return "administrator";
        case AUTORISATIE_STATUS_ROOT:
            return "root";
        default:
            return "???";
    }
}

function voucherNaam( $code )
{
    switch ( $code )
    {
        case VOUCHERTYPE_VOUCHER:
            return "voucher";
        case VOUCHERTYPE_KORTING:
            return "kortingsbon";
        default:
            return "???";
    }
}


function variableName( &$var, $scope = false, $prefix = 'UNIQUE', $suffix = 'VARIABLE' )
{
    if ( $scope )
    {
        $vals = $scope;
    }
    else
    {
        $vals = $GLOBALS;
    }
    //var_dump ($GLOBALS );
    $old = $var;
    $var = $new = $prefix . rand() . $suffix;
    $vname = false;
    foreach ( $vals as $key => $val )
    {
        if ( $val === $new )
        {
            $vname = $key;
        }

    }
    $var = $old;
    return $vname;
}

function alert( $msg )
{
    if ( LOGLEVEL > LOGLEVEL_DEBUG && TOON_ALERTS )
    {
        $msg = str_replace('"', "-", $msg);
        $msg = str_replace("'", "-", $msg);
        
        echo "<script type='text/javascript'>alert('" . $msg . "');</script>";
    }
}

function alertAndGo( $msg, $location )
{
    $tekst = '<script type="text/javascript">';
    
    $msg = str_replace('"', "-", $msg);
    $msg = str_replace("'", "-", $msg);
    $msg = str_replace("\n", "", $msg);
    
    if ( LOGLEVEL > LOGLEVEL_DEBUG && TOON_ALERTS )
    {
        $tekst .= 'alert("' . $msg . '");';
    }
    $tekst .= 'window.location = "' . $location . '";</script>;';

    echo $tekst;
}

function naarJaNee( $var )
{
    if ( $var == null || $var == '0' )
    {
        return ( OPTIE_KEUZE_NEE );
    }
    else
    {
        return ( OPTIE_KEUZE_JA );
    }
}

function vanJaNee( $var )
{
    if ( $var == null || $var == OPTIE_KEUZE_NEE )
    {
        return ( '0' );
    }
    else
    {
        return ( '1' );
    }
}
