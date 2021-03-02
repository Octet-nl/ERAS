<?php
/**
 * System      ERAS
 * Module      Factuur verzenden
 * Doel        Verzend factuur met externe factuurnummering
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       16-02-2021
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

use \fb_model\fb_model\FactuurNummerQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\PersoonQuery;
use \fb_model\fb_model\MailinglistQuery;
use PHPMailer\PHPMailer\PHPMailer;

require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

require_once 'fpdf/fpdf2.php';
require_once 'factuur_pdf_class.php';

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Factuur verzenden";

// define variables and set to empty values
$bevestig = "";
$serialnaam = "";
$evenementId = "";
$emailadres = "";
$code = "";
$evt = "";
$aantal = 0;
$batchSize = 10;
$factuur_lijst = array();

$ini = parse_ini_file( CONFIG_FILENAME, true );
$facturenDirectory = $ini['settings']['facturen_directory'] . '/';

$statusRegel = "";
$signalError = false;

$history = new History();

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );

    $history->set();

    $logger->debug( "Aanmaken factuur" );

    $ini = parse_ini_file( CONFIG_FILENAME, true );

    // Vullen facturenlijst
    $facturen = FactuurNummerQuery::create()
        ->findByVerzonden("0");

    foreach ( $facturen as $factuur )
    {
        $fct_lijst = array();

        $serialnaam = $facturenDirectory . $factuur->getInschrijvingId() . sprintf("-%04d", $factuur->getId() ) . ".ser";
        if ( file_exists( $serialnaam ) )
        {
            $logger->debug( "Serialized bestand gevonden " . $serialnaam );
            $fct_lijst["Err"] = "";
        }
        else
        {
            $fct_lijst["Err"] = "Tijdelijk bestand " . $serialnaam . " niet gevonden";
            $serialnaam = "";
        }

        $inschrijving = InschrijvingQuery::create()->findPk( $factuur->getInschrijvingId() );
        if ( $inschrijving != null )
        {
            $persoon = PersoonQuery::create()->findPk( $inschrijving->getContactPersoonId() );
            if ( $persoon == null )
            {
                $logger->error( "Persoon niet gevonden. Id=" . $inschrijving->getContactPersoonId() );
            }
            else
            {
                $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
                if ( $evenement == null )
                {
                    $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
                }
                else
                {
                    $fct_lijst["id"] = $factuur->getId();
                    $fct_lijst["bedrag"] = $inschrijving->getTotaalbedrag();
                    $fct_lijst["inschrijving"] = $inschrijving->getId();
                    $fct_lijst["naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
                    $fct_lijst["evenement"] = $evenement->getNaam();
                    $fct_lijst["email"] = $persoon->getEmail();
                    $fct_lijst["serialnaam"] = $serialnaam;
                    array_push( $factuur_lijst, $fct_lijst );
                }
            }
        }        
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        $terug = $history->get();
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    $validateOk = 0;
    $setVar = new SetVariable();
    $validateOk += $setVar->name( $emailadres )
        ->required()
        ->go();
    $validateOk += $setVar->name( $serialnaam )
        ->required()
        ->go();
    $validateOk += $setVar->name( $evenement )
        ->required()
        ->go();
    $validateOk += $setVar->name( $factuurnummer )
        ->required()
        ->go();
    $validateOk += $setVar->name( $factuurid )
        ->required()
        ->go();

    if ( $validateOk == 0 )
    {
        if( isset( $_POST['verzend'] ) )
        {
            try
            {
                $serial = file_get_contents( $serialnaam );
                $pdf = unserialize( $serial );
                $pdf->addFactuurnr( $factuurnummer, date( "d-m-Y" ) );
                
                $factuurnaam = $facturenDirectory . $factuurnummer . ".pdf";

                $pdf->Output( "F", $factuurnaam );

                $email = new PHPMailer( true );

                $logger->debug( 'Mailer geconstruct' );

                $logger->debug( 'Ini gevonden' );

                $ini = parse_ini_file( CONFIG_FILENAME, true );
                $adresRegel = '<div>' . $ini['organisatie']['adresregel'] . '</div>';
            
                $mailingTekst = '<br/><br/><div align="center" style="font-size:1.0em;">Hierbij ontvangt u de factuur voor uw inschrijving</div>';
                
                $logger->debug( 'Mail naar ' . $emailadres );

                $email->setFrom( $ini['organisatie']['email'], $ini['organisatie']['organisatienaam'] ); //Name is optional
                $email->Subject = "Uw factuur voor " . $evenement;
                $email->Body = $mailingTekst;
                $email->IsHTML( true );
                $email->addAddress( $emailadres );
                $email->addAttachment( $factuurnaam );
                $logger->debug( 'Header gevuld' );

                if ( !$email->send() )
                {
                    //The reason for failing to send will be in $mail->ErrorInfo
                    //but you shouldn't display errors to users - process the error, log it on your server.
                    $statusRegel = "Door een technisch probleem kunnen wij de mailing nu niet verzenden. Zie errorlog.<br/>";
                    $signalError = true;
                    $logger->error( 'Probleem bij verzenden mail.' . $email->ErrorInfo );
                    $logger->debug( $message );
                }
                else
                {
                    // Database bijwerken
                    $factuur = FactuurNummerQuery::create()->findPk( $factuurid );
                    $factuur->setFactuurnummer( $factuurnummer );
                    $factuur->setVerzonden("1");                    
                    $factuur->save();

                    unlink( $serialnaam );
                    $statusRegel = "De mail is verzonden naar " . $emailadres;
                    $logger->debug( 'De mail is verzonden naar ' . $emailadres );
                    alertAndGo( "Mailing is verzonden.", "factuur_verzenden.php");
                }


            }
            catch ( Exception $ex )
            {
                $statusRegel = "Door een technisch probleem kunnen wij de mailing nu niet verzenden. Zie errorlog.<br/>";
                $signalError = true;
                $logger->error( "Unhandled exception bij verzenden mail" );
                $logger->errordump( $ex );
                $validateOk = 999;
            }
        }
    }
    else
    {
        $statusRegel = "Er is iets fout gegaan in de verwerking";
        $logger->error( "Fout bij verwerking, validateOk = " . $validateOk );
        $signalError = true;
    }
}
// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

$ini = parse_ini_file( CONFIG_FILENAME, true );
$imageDirectory = $ini['settings']['image_directory'] . '/';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'imageDirectory', $imageDirectory );
$smarty->assign( 'factuur_lijst', $factuur_lijst );
$smarty->assign( 'evenementId', $evenementId );
$smarty->assign( 'aantal', $aantal );
$smarty->assign( 'batchSize', $batchSize );
$smarty->assign( 'bevestig', $bevestig );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'factuur_verzenden.tpl' );
