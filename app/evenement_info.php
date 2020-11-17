<?php
/**
 * System      Inschrijvingen
 * Module      Inschrijving info
 * Doel        Opvragen informatie over evenement
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       05-05-2020
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

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/
use Respect\Validation\Validator as v;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Informatie over evenement";

// define variables and set to empty values
$evt = $voornaam = $tussenvoegsel = $achternaam = $straat = $huisnummer = $toevoeging = $postcode = $woonplaats = $email = "";
$evtErr = $voornaamErr = $tussenvoegselErr = $achternaamErr = $straatErr = $huisnummerErr = $toevoegingErr = $postcodeErr = $woonplaatsErr = $emailErr = "";
$evenementnaam = "";

$validatiemelding = "";
$persoon = $id = $evt = $iid = null;
$readonly = null;
$sessieVariabelen = array();
$wijzigen = false;

$validateOk = 0;
$evenementnaam = "";

$logger->debug( $doctitle );

//$autorisatie = new Autorisatie();

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    $logger->debug( "Opvragen informatie over evenement" );
    if ( isset( $_GET['evtn'] ) )
    {
        $evenementnaam = $_GET['evtn'];
        $logger->debug( "Naam: " . $evenementnaam );
    }
    else
    {
        $logger->info( "Geen evt in url. Terug naar evenementenlijst" );
        alert( 'Geen evenementnaam opgegeven' );
        header( "Location:evenement_kiezen.php" );
        exit();
    }
}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    try
    {
        $toegestaneTekens = "áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ '";

        $setVar = new SetVariable();
        if ( isset($_SESSION['evenement_naam']) )
        {
            $evenementnaam = $_SESSION['evenement_naam'];
        }

        $validateOk += $setVar->name( $voornaam )
            ->onerror( $voornaamErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 64 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $tussenvoegsel )
            ->onerror( $tussenvoegselErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 24 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $achternaam )
            ->onerror( $achternaamErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $straat )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 255 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $huisnummer )
            ->onerror( $huisnummerErr )
            ->validator( v::number()->between( 1, 99999 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $huisnummer_toevoeging )
            ->onerror( $huisnummer_toevoegingErr )
            ->validator( v::alwaysValid()->length( 0, 24 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $postcode )
            ->onerror( $postcodeErr )
            ->formatter( 'postcode' )
            ->errormessage( "Postcodeformaat NL, BE, DE of GB" )
//            ->validator( v::alnum()->length( 1, 10 ) )
            ->validator( v::oneOf( v::postalCode( 'NL' ), v::postalCode( 'BE' ), v::postalCode( 'DE' ), v::postalCode( 'GB' ) ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $woonplaats )
            ->onerror( $woonplaatsErr )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ \'()' )->length( 1, 255 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $landnaam )
            ->onerror( $landnaamErr )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ \'' )->length( 1, 255 ) )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $email )
            ->onerror( $emailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
        //->validator( v::email()->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $telefoonnummer )
            ->onerror( $telefoonnummerErr )
            ->validator( v::phone() )
            ->required( false )
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
        try
        {
            //ToDo: Wat nu te doen met het verzoek om informatie?
            // Gegevens zijn binnen maar hoe verder?
        
            // Verzend naar infomail adres in database
            $systeem = new Sysdb();
            $mailadres = $systeem->getOrganisatieMail();
        
            $message = "Informatie aanvraag voor evenement " . $evenementnaam;
            $message .= "\nDoor: " . $voornaam . " " . $tussenvoegsel . " " . $achternaam;
            $message .= "\nAdres: " . $straat . " " . $huisnummer . "\n";
            $message .= "         " . $postcode . " " . $woonplaats . "\n";
            $message .= "eMail    " . $email . "\n";

            $logger->debug( "Mail: " . $message );

            $email = new PHPMailer();

            $logger->debug( 'Mailer geconstruct');

            $email->setFrom( $mailadres, $systeem->getOrganisatieNaam() ); //Name is optional
            $email->Subject   = "Informatie aanvraag voor evenement " . $evenementnaam;
            $email->Body      = $message;
            $email->addAddress( $mailadres );

            $logger->debug( 'Header gevuld');

//            $file_to_attach = 'PATH_OF_YOUR_FILE_HERE';

//            $email->AddAttachment( $file_to_attach , 'NameOfFile.pdf' );

            if (!$email->send()) 
            {
                //The reason for failing to send will be in $mail->ErrorInfo
                //but you shouldn't display errors to users - process the error, log it on your server.
                alert( "Sorry, het verzenden van uw verzoek is mislukt. Probeeer het later nog eens." );
                $logger->error( 'Probleem bij verzenden mail.' . $email->ErrorInfo );
            }
            else 
            {
                alert( "Uw verzoek is verzonden. U ontvangt zo snel mogelijk de gevraagde informatie." );
                $logger->debug( 'Informatieverzoek is verzonden naar ' . $mailadres );
            }

            exit();
        }
        catch ( \Exception $e )
        {
            $logger->error( 'Probleem met opslaan gegevens contactpersoon, foutcode ' . $e->getPrevious()->errorInfo[1] );
            $logger->error( $e->getPrevious()->errorInfo[2] );
            $logger->dump( $e );
            $validatiemelding = 'Probleem met opslaan gegevens, foutcode ' . $e->getPrevious()->errorInfo[1];
        }
    }
    else
    {
        $logger->debug( "Niets gedaan want validateOk is niet 0; $validateOk=" . $validateOk );
        echo 'Wilt u alstublieft de gevraagde gegevens invullen?';
    }
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenementnaam', $evenementnaam );
$smarty->assign( 'voornaam', $voornaam );
$smarty->assign( 'tussenvoegsel', $tussenvoegsel );
$smarty->assign( 'achternaam', $achternaam );
$smarty->assign( 'straat', $straat );
$smarty->assign( 'huisnummer', $huisnummer );
$smarty->assign( 'toevoeging', $toevoeging );
$smarty->assign( 'postcode', $postcode );
$smarty->assign( 'woonplaats', $woonplaats );
$smarty->assign( 'email', $email );
$smarty->assign( 'voornaamErr', $voornaamErr );
$smarty->assign( 'tussenvoegselErr', $tussenvoegselErr );
$smarty->assign( 'achternaamErr', $achternaamErr );
$smarty->assign( 'straatErr', $straatErr );
$smarty->assign( 'huisnummerErr', $huisnummerErr );
$smarty->assign( 'toevoegingErr', $toevoegingErr );
$smarty->assign( 'postcodeErr', $postcodeErr );
$smarty->assign( 'woonplaatsErr', $woonplaatsErr );
$smarty->assign( 'emailErr', $emailErr );

$smarty->display( 'evenement_info.tpl' );
