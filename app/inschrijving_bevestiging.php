<?php
/**
 * System      ERAS
 * Module      Inschrijving bevestiging
 * Doel        Gedetailleerde bevestigings PDF voor de inschrijving
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       20-05-2020
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

require_once 'fpdf/fpdf2.php';

require_once 'factuur_pdf_class.php';
require_once 'inschrijving_bevestiging_class.php';

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

use fb_model\fb_model\FactuurNummer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$logger = new Logger();
$logger->level( LOGLEVEL );

$optie_lijst = array();
$annuleringsverzekering_lijst = array();
$evenement_lijst = array();

$annuleringsverzekering_lijst["geen"] = 0;
$annuleringsverzekering_lijst["gewoon"] = 0;
$annuleringsverzekering_lijst["allrisk"] = 0;

$definitieveInschrijvingen = 0;
$geannuleerdeInschrijvingen = 0;
$openInschrijvingen = 0;
$aantal_deelnemers = 0;
$aantal_beschikbaar = 0;

$teBetalen = 0;
$alBetaald = 0;
$nogTeBetalen = 0;
$korting = 0;

$evenementNaam = "";
$evenementId = 0;

$ini = parse_ini_file( CONFIG_FILENAME, true );
$facturenDirectory = $ini['settings']['facturen_directory'] . '/';

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    $factuurData = array();
    $messageBody = "";
    $maakBevestiging = new InschrijvingBevestiging;

    if ( isset( $_GET['iid'] ) )
    {
        $inschrijfnummer = $_GET['iid'];
        $maakBevestiging->setInschrijfnummer( $inschrijfnummer );
        if ( $maakBevestiging->go() )
        {
            $logger->debug( "Bevestiging aangemaakt, inschrijfnummer " . $inschrijfnummer );
            $messageBody = $maakBevestiging->getMessageBody();
            $factuurData = $maakBevestiging->getFactuurData();
        }
        else
        {
            $logger->debug( "Bevestiging aanmaken mislukt, inschrijfnummer " . $inschrijfnummer . "  " . $maakBevestiging->getErrorTekst() );
            alertAndGo( $maakBevestiging->getErrorTekst(), "evenement_kiezen.php" );
            echo "Bevestiging aanmaken mislukt, inschrijfnummer " . $inschrijfnummer;
            exit;
        }
    }
    else
    {
        $logger->error( 'Geen inschrijfnummer opgegeven. Gebruik: inschrijving_bevestiging.php?iid=Inschrijfnummer' );
        // Terug naar de evenementlijst
        alertAndGo( 'Geen inschrijfnummer bekend.', "evenement_kiezen.php" );
    }

    $logger->debug( $messageBody );

    $logger->debug( "Aanmaken factuur" );

    $ini = parse_ini_file( CONFIG_FILENAME, true );

    if ( $ini['pdf_factuur']['aanmaken']  == OPTIE_KEUZE_JA )
    {
        /////////////////////////////////////////
        //  Aanmaken factuur
        /////////////////////////////////////////
        $pdf = new Factuur();
        $pdf->setIni( $ini );
        $pdf->setDocumentTitle( $ini['pdf_factuur']['titel'] );
        $pdf->setLogo( $ini['pdf_factuur']['logo'] );
        $pdf->setFooter( $ini['pdf_factuur']['footer'] );
        $pdf->setAddress( $ini['pdf_factuur']['adresregel'] );
        $pdf->SetFillColor( 214, 214, 214 );
        $pdf->AddPage();

        $factuur = new FactuurNummer();
        $factuur->setInschrijvingId( $inschrijfnummer );
        $factuur->setGemaaktDoor( $autorisatie->getUserId() );
        $factuur->setGewijzigdDoor( $autorisatie->getUserId() );
        $factuur->save();

        $pdf->addFrom( $ini['pdf_factuur']['notatype'], "Van:\n" .
            "eMail:\n" .
            "Bank:\n" .
            "Ten name van:\n" .
            "Wegens:\n" .
            "Factuurnummer:\n" .
            "Datum: \n",
            $ini['organisatie']['organisatienaam'] . "\n" .
            $ini['organisatie']['email'] . "\n" .
            "(IBAN) " . $ini['bank']['IBAN'] . " / (BIC) " . $ini['bank']['BIC'] . "\n" .
            $ini['bank']['ten_name_van'] . "\n" .
            $inschrijfnummer . " " . $maakBevestiging->getEvenementnaam() . "\n" .
            $inschrijfnummer . sprintf("-%04d", $factuur->getId() ) . "\n" .
            date( "d-m-Y" ) . "\n"
        );
        $pdf->addTo( $maakBevestiging->getContactNaam() . "\n" . $maakBevestiging->getContactAdres() . "\n" . $maakBevestiging->getContactWoonplaats() );
        $pdf->addOrderDetail( $maakBevestiging->getEvenementnaam(),
            $maakBevestiging->getEvenementDatum(),
            $inschrijfnummer,
            $maakBevestiging->getAantalDeelnemers(),
            $maakBevestiging->getEvenementPrijs(),
            $maakBevestiging->getAantalDeelnemers() * $maakBevestiging->getEvenementPrijs() );

        $pdf->populateTable( $maakBevestiging->getFactuurData(), $maakBevestiging->getAantalDeelnemers(), $maakBevestiging->getEvenementPrijs() );
        if ( !is_dir( $facturenDirectory ) )
        {
            mkdir( $facturenDirectory );
        }
        $pdf->Output( "F", $facturenDirectory . $inschrijfnummer . sprintf("-%04d", $factuur->getId() ) . ".pdf" );

        $logger->debug( "Factuur aangemaakt" );
    }
    else
    {
        $logger->debug( 'Factuur niet aangemaakt i.v.m. setting' );
    }

    /////////////////////////////////////////
    //  Factuur verzenden per email
    /////////////////////////////////////////

    $systeem = new Sysdb();
    $mailadres = $systeem->getOrganisatieMail();

    $bevestig = "Bedankt voor uw inschrijving. ";
    $disclaimer = "";
    if ( $maakBevestiging->getContactEmail() != "" )
    {
        $mailadres = $maakBevestiging->getContactEmail();
        $message = $disclaimer;

        $message .= "Geachte " . $maakBevestiging->getContactAanschrijving();
        $message .= "<br/><br/>Bedankt voor uw inschrijving voor evenement " . $maakBevestiging->getEvenementNaam();
        $message .= "<br/><br/>In deze mail willen wij nog even alles samenvatten.";
        $message .= "<br/><br/>" . $messageBody . "<br/><br/>";
        $message .= "<br/><br/>Met vriendelijke groet,<br/><br/>";
        $message .= "<br/><br/>" . $ini['organisatie']['organisatienaam'] . "<br/><br/>";

        if ( $ini['pdf_factuur']['verzenden'] == OPTIE_KEUZE_JA )
        {
            $message .= "Bijlage: factuur";
        }

        $message .= "<br/<br/>" . $maakBevestiging->getOndersteRegels();

        $logger->debug( "Mail: " . $message );

        try
        {
            $email = new PHPMailer( true );

            $logger->debug( 'Mailer geconstruct' );

            $email->setFrom( $ini['organisatie']['email'], $systeem->getOrganisatieNaam() ); //Name is optional
            $email->Subject = "Bevestiging inschrijving evenement " . $evenementNaam;
            $email->Body = $message;
            $email->IsHTML( true );
            $email->addAddress( $mailadres );

            $logger->debug( 'Header gevuld' );

            if ( $ini['pdf_factuur']['verzenden'] == OPTIE_KEUZE_JA )
            {
                $file_to_attach = $facturenDirectory . $inschrijfnummer . sprintf("-%04d", $factuur->getId() ) . ".pdf";
                $email->AddAttachment( $file_to_attach, "Factuur " . $inschrijfnummer );
            }
            else
            {
                $logger->debug( 'Factuur niet verzonden i.v.m. setting' );
            }

            if ( !$email->send() )
            {
                //The reason for failing to send will be in $mail->ErrorInfo
                //but you shouldn't display errors to users - process the error, log it on your server.
                $bevestig .= "Uw bevestiging is aangemaakt, maar door een technisch probleem kunnen wij deze nu niet verzenden. Neem a.u.b. contact met ons op.<br/>";
                saveBevestiging( $inschrijfnummer, $message );
                $logger->error( 'Probleem bij verzenden mail.' . $email->ErrorInfo );
                $logger->debug( $message );
            }
            else
            {
                $bevestig .= "Uw bevestiging is verzonden naar uw email adres (" . $mailadres . ").";
                $logger->debug( 'Bevestiging is verzonden naar ' . $mailadres );
            }
        }
        catch ( Exception $e )
        {
            $bevestig .= "Uw bevestiging is aangemaakt, maar door een technisch probleem kunnen wij deze nu niet verzenden. Neem hiervoor a.u.b. contact met ons op.";
            saveBevestiging( $inschrijfnummer, $message );
            $logger->error( "bevestiging is aangemaakt, verzenden geeft exceptie:" );
            $logger->error( $e->getMessage() );
            $logger->debug( $message );
            //        alertAndGo( $bevestig, "evenement_kiezen.php" );
            //        exit();
        }
    }
    else
    {
        $bevestig .= "Uw bevestiging is aangemaakt, maar omdat wij geen mailadres van u hebben kunnen wij deze niet verzenden. Neem a.u.b. contact met ons op.";
        saveBevestiging( $inschrijfnummer, $message );
        $disclaimer = "<br/>*****************************<br/>**** Deze bevestiging is aangemaakt, maar omdat wij geen mailadres van de klant hebben kan deze niet verstuurd worden.<br/>*****************************<br/><br/>";
    }

    if ( $maakBevestiging->getBetaalwijze() == BETAALWIJZE_IDEAL )
    {
        if ( $autorisatie->getRol() == AUTORISATIE_STATUS_KLANT )
        {
            if ( $maakBevestiging->getNogTeBetalenBedrag() > 1.50 )
            {
                $logger->debug( 'Betaalwijze iDeal, naar afronding.' );
                alertAndGo( $bevestig . ' U wordt nu doorgezet naar iDeal',
                    "idealbetaling.php?totaalbedrag=" . $maakBevestiging->getNogTeBetalenBedrag() .
                    "&evenementnaam=" . $maakBevestiging->getEvenementNaam() .
                    "&inschrijfnummer=" . $inschrijfnummer );
                exit;
            }
            else
            {
                $logger->debug( 'Betaalwijze iDeal, maar bedrag minder dan 1,50 (' . $maakBevestiging->getNogTeBetalenBedrag() . ')' );
                if ( $maakBevestiging->getNogTeBetalenBedrag() > 0.0000001 )
                {
                    $bevestig .= 'Het resterende bedrag is te laag om met iDeal te betalen';
                }
                alertAndGo( $bevestig . "", $ini['organisatie']['website'] );
                exit;
            }
        }
        else
        {
            $logger->debug( 'Betaalwijze iDeal, maar medewerker, dus terug naar startscherm.' );
            alertAndGo( $bevestig . 'Als medewerker kunt u niet met iDeal betalen. U wordt nu doorgezet naar het startscherm',
                "index.php" );
            exit;
        }
    }
    else
    {
        $logger->debug( 'Betaalwijze ' . betaalwijzeNaam( $maakBevestiging->getBetaalwijze() ) );

        $ini = parse_ini_file( CONFIG_FILENAME, true );
        alertAndGo( $bevestig, $ini['organisatie']['website'] );
        exit;
    }
    // Inschrijving gereed

}

function saveBevestiging( $inschrijfnummer, $message )
{
    GLOBAL $facturenDirectory;

    $fp = fopen( $facturenDirectory . $inschrijfnummer . "_bevestiging_" . date('m-d-Y_His') . " .html", 'w' );
    if ( $fp == null )
    {
        throw new Exception( "Kan bestand " . $facturenDirectory . $inschrijfnummer . ".html" . " niet openen." );
    }
    fprintf( $fp, "<html><head><style>table{margin-left: 5em;font-family: sans-serif;font-size: 0.85em;width: 60%%;border-collapse: collapse;}
        th {padding: 0.44em 0.3em 0.44em 0.3em;background-color: lightgray;border-radius: 0.20em;color: black;}
        td {border-left: 1px solid;border-right: 1px solid;border-bottom: 1px solid;padding: 0.3em 0.3em 0.3em 0.3em;}
        .cen {text-align: center;}
        .rig {text-align: right;}
        .cap {border: 0.0625em solid;padding: 0.44em 0.3em 0.44em 0.3em;border-radius: 0.20em;}
     </style></head><body>" . $message . "</body></html>" );
}
