<?php
/**
 * System      Inschrijvingen
 * Module      GetGit
 * Doel        Ophalen en deployment van de applicatie uit GIT
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       06-05-2020
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

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

if ( session_status() == PHP_SESSION_NONE )
{
    session_start();
}

$logger = new Logger();
$logger->level( 0 );
$logger->info( "***** Starten deployment " );

if ( PHP_OS != "Linux" )
{
    echo "Deze functie werkt alleen onder Linux. Huidig systeem is " . PHP_OS;
    exit;
}

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    if ( isset( $_GET["env"] ) && isset( $_GET["tag"] ) && isset( $_GET["dir"] ) )
    {
        if ( $_GET["env"] != null && $_GET["tag"] != null && $_GET["dir"] != null )
        {

            $omgeving = $_GET["env"];
            $tag = $_GET["tag"];
            $deployDirectory = $_GET["dir"];
            $rc = 0;

            $logger->info( "********************************************" );
            $logger->info( "** Deployment naar " . $deployDirectory . " gestart" );
            $logger->info( "********************************************" );

            $logger->info( "Omgeving " . $omgeving . ", tag " . $tag . " deploy directory " . $deployDirectory );

            try
            {
                ///////////////////////////////////////////////////////////////////
                //  Download van de gewenste tag uit GitHub.
                ///////////////////////////////////////////////////////////////////
                $rc = 0;
                $logger->info( "Download archive" );
                $command = 'curl -k -L https://github.com/Octet-nl/ERAS/archive/' . $tag . '.tar.gz --output ../' . $tag . '.tar.gz';
                $logger->info( $command );
                $rc = execWait( $command );
                if ( $rc != 0 )
                {
                    $logger->error( "Fout bij download archive, rc=" . $rc );
                    throw new Exception( 'Fout bij download archive.' );
                }
                else
                {
                    $logger->info( "Archive gedownload" );
                }

                ///////////////////////////////////////////////////////////////////
                //  Verwijderen bestaande directories
                ///////////////////////////////////////////////////////////////////
                $command = "rm -rf ../fb_model";
                $logger->info( $command );
                $rc = execWait( $command );
                $command = "rm -rf ../app";
                $logger->info( $command );
                $rc += execWait( $command );
                $command = "rm -rf ../vendor";
                $logger->info( $command );
                $rc += execWait( $command );

                if ( $rc != 0 )
                {
                    $logger->error( "Fout bij verwijderen huidige versie, rc=" . $rc );
//                $logger->error( "Ga toch door" );
                    throw new Exception( 'Fout bij verwijderen huidige versie.' );
                }
                else
                {
                    $logger->info( "Huidige versie is verwijderd" );
                }

                ///////////////////////////////////////////////////////////////////
                //  Gedownload archief untarren naar de deployment directory
                ///////////////////////////////////////////////////////////////////
                $command = "mkdir -p ../untar && tar -xvf ../" . $tag . ".tar.gz -C ../untar/ --strip-components=1";
                $logger->info( $command );
                $rc = execWait( $command );
                if ( $rc != 0 )
                {
                    throw new Exception( 'Fout bij uitpakken archive naar hop., rc=' . $rc );
                    $logger->error( "Fout bij uitpakken archive naar hop" );
                }
                else
                {
                    $logger->info( "Archive uitgepakt" );
                }

                ///////////////////////////////////////////////////////////////////
                //  Gedownloade versies naar live omgeving
                ///////////////////////////////////////////////////////////////////
                $command = "mv ../untar/fb_model ../fb_model";
                $logger->info( $command );
                $rc = execWait( $command );
                $command = "mv ../untar/app ../app";
                $logger->info( $command );
                $rc += execWait( $command );
                $command = "mv ../untar/vendor ../vendor";
                $logger->info( $command );
                $rc += execWait( $command );
                $command = "cp ../untar/* ../";
                $logger->info( $command );
                // cp keert terug met returncode 1, dat is ok
                execWait( $command );

                if ( $rc != 0 )
                {
                    $logger->error( "Fout bij plaatsen nieuwe versie, rc=" . $rc );
                    throw new Exception( 'Fout bij plaatsen nieuwe versie.' );
                }
                else
                {
                    $logger->info( "Nieuwe versie is geplaatst" );
                }
                ///////////////////////////////////////////////////////////////////
                //  Verwijderen gedownload archief
                ///////////////////////////////////////////////////////////////////
                $command = "rm ../" . $tag . ".tar.gz";
                $logger->info( $command );
                $rc = execWait( $command );
                $command = "rm -rf ../untar";
                $logger->info( $command );
                $rc += execWait( $command );
                if ( $rc != 0 )
                {
                    $logger->error( "Fout bij verwijderen archive, rc=" . $rc );
                    throw new Exception( 'Fout bij verwijderen archive.' );
                }
                else
                {
                    $logger->info( "Archive is verwijderd" );
                }

                ///////////////////////////////////////////////////////////////////
                //  version.tpl file aanmaken
                ///////////////////////////////////////////////////////////////////
                if ( $tag == "master" )
                {
                    $tag = $tag . " " . date('Y-m-d\TH:i:s');
                }
                file_put_contents( "../version.tpl", "<h4>ERAS versie: " . $tag . "<h4>" );

                ///////////////////////////////////////////////////////////////////
                //  version.tpl naar de smarty template directory
                ///////////////////////////////////////////////////////////////////
                $command = "mv ../version.tpl ../app/smarty/templates/version.tpl";
                $logger->info( $command );
                $rc = execWait( $command );
                if ( $rc != 0 )
                {
                    $logger->error( "Fout bij kopieren version.tpl, rc=" . $rc );
                    throw new Exception( 'Fout bij kopieren version.tpl' );
                }
                else
                {
                    $logger->info( "Version.tpl is gekopieerd" );
                }

                // Verwijder huidige sessie, die is niet meer goed.
                //session_destroy();

                $_SESSION['isUpdate'] = $tag;

                ///////////////////////////////////////////////////////////////////
                //  En naar het hoofdmenu van de zojuist geinstalleerde versie
                ///////////////////////////////////////////////////////////////////
                header( "location:../app/index.php" );
                exit;
            }
            catch ( Exception $ex )
            {
                $logger->error( "Er is iets misgegaan bij de deployment: " . $ex->getMessage() );
                echo "Er is iets misgegaan bij de deployment: " . $ex->getMessage();
            }
        }
    }
}

exit;

function execWait( $command )
{
    $returnvar = 0;
    exec( $command, $out, $returnvar );
    if ( $returnvar != 0 )
    {
        echo "Fout bij uitvoeren van '" . $command . ", returnwaarde = " . $returnvar . " <br>";
    }
    else
    {
        foreach ( $out as $key => $value )
        {
//       echo $key." ".$value."<br>";
        }
    }
    return $returnvar;
}

class Logger
{
    private $logLevel = 0;
    private $extraText = "";
    private $logfilename = "";

    public function __construct( $text = "" )
    {
        $this->logfilename = "../log/deploy.log";

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

    public function dump( &$vardump )
    {
        // Only dump in debug mode
        if ( $this->logLevel > 0 )
        {
            return;
        }
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " DUMP  " . $logName . $this->extraText . " $" . variableName( $vardump ) . PHP_EOL . var_export( $vardump, true ) . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function debug( $regel )
    {
        if ( $this->logLevel > 1 )
        {
            return;
        }
        //$logName = pathinfo(debug_backtrace()[0]['file'])['basename'] . " line " . debug_backtrace()[0]['line'] . ': ';
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " DEBUG " . $logName . $this->extraText . $regel . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function info( $regel )
    {
        if ( $this->logLevel > 2 )
        {
            return;
        }
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " INFO  " . $logName . $this->extraText . $regel . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
    }

    public function warning( $regel )
    {
        if ( $this->logLevel > 3 )
        {
            return;
        }
        $logName = $this->getLogName();
        $logMsg = date( "d-m-Y H:i:s" ) . " WARNG " . $logName . $this->extraText . $regel . PHP_EOL;
        file_put_contents( $this->logfilename, $logMsg, FILE_APPEND | LOCK_EX );
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
        $this->logfilename = realpath( $filename );
    }

    public function getFilename()
    {
        return $this->logfilename;
    }

    private function getLogName()
    {
        return pathinfo( debug_backtrace()[1]['file'] )['basename'] . " " . debug_backtrace()[1]['line'] . ': ';
    }
}
