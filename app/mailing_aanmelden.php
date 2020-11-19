<?php
/**
 * System      ERAS
 * Module      Mailing aanmelden
 * Doel        Aanmelden voor de mailinglist voor een evenement
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       06-10-2020
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

    use Respect\Validation\Validator as v;
    use \fb_model\fb_model\Mailinglist;
    use \fb_model\fb_model\MailinglistQuery;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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

    $logger = new Logger();
    $logger->level( LOGLEVEL );

    $doctitle = "Belangstelling";

// define variables and set to empty values
    $bevestig = "";
    $naam = "";
    $naamErr = "";
    $email = "";
    $emailErr = "";
    $evenementnaam = "";
    $evenementid = "";

    $logger->debug( $doctitle );

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
            $logger->info( "Geen evtNaam in url. Terug naar evenementenlijst" );
            alert( 'Geen evenementnaam opgegeven' );
            header( "Location:evenement_kiezen.php" );
            exit();
        }
        if ( isset( $_GET['evti'] ) )
        {
            $evenementid = $_GET['evti'];
            $logger->debug( "ID: " . $evenementid );
        }
        else
        {
            $logger->info( "Geen evtID in url. Terug naar evenementenlijst" );
            alert( 'Geen evenementid opgegeven' );
            header( "Location:evenement_kiezen.php" );
            exit();
        }
    }

// DEEL 2
    // De POST method wordt getriggered door het drukken op de 'registreer' knop.
    // Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
    // Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
    if ( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $logger->dump( $_POST );
        $validateOk = 0;

        if ( isset( $_POST["registreer"] ) )
        {
            try
            {
                $toegestaneTekens = "áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ '";

                $setVar = new SetVariable();

                $validateOk += $setVar->name( $evenementnaam )
                    ->validator( v::alwaysValid() )
                    ->required( true )
                    ->go();
                $logger->debug( $evenementnaam );
                $validateOk += $setVar->name( $evenementid )
                    ->validator( v::alwaysValid() )
                    ->required( true )
                    ->go();
                $validateOk += $setVar->name( $naam )
                    ->onerror( $naamErr )
                    ->validator( v::alpha( $toegestaneTekens )->length( 1, 64 ) )
                    ->required( true )
                    ->go();
                $validateOk += $setVar->name( $email )
                    ->onerror( $emailErr )
                    ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
                    ->required( true )
                    ->go();
            }
            catch ( Exception $ex )
            {
                $logger->error( "Unhandled exception in SetVariable" );
                $logger->errordump( $ex );
                $validateOk = 999;
            }

            $geregistreerd = false;
            if ( $validateOk == 0 )
            {
                try
                {
                    // Check of deze al ingeschreven is
                    $mailing = MailinglistQuery::create()
                                ->filterByEmail( $email )
                                ->filterByEvenementId( $evenementid )
                                ->findOne();
                    if ( $mailing != null )
                    {
                        $logger->dump( $mailing );
                        $emailErr = "U bent al ingeschreven op deze mailinglist.";
                    }
                    else
                    {
                        require_once 'code_generator_class.php';
                        $codeGen = new CodeBeheer();
                        $codeGen->setLengte(8);
                        $code = $codeGen->genereer(false);
                
                        // Opvoeren in database
                        $mailing = new Mailinglist();

                        $mailing->setEmail( $email );
                        $mailing->setEvenementId( $evenementid );
                        $mailing->setNaam( $naam );
                        $mailing->setCode( $code );
                        $mailing->save();
                        $geregistreerd = true;
                        $mailingTekst = "L.S.<br/><br/>Uw aanmelding voor de nieuwsbrief voor evenement " . $evenementnaam . " is vastgelegd.<br/>Mocht dit op een misverstand berusten dan kunt u zich via de onderstaande link weer afmelden.<br/><br/>";

                        // Bevestiging
                        // Magic om de huidige URL te vinden
                        $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
                        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";
                        $logger->debug( "Onze URL: " . $url );
                        $unsubscribeLink = $url . '/mailing_afmelden.php?mail=' . $email . "&code=" . $code;

                        $ini = parse_ini_file( CONFIG_FILENAME, true );
                        $adresRegel = '<div style="font-size:0.8em;">' . $ini['pdf_factuur']['adresregel'] . '</div>';
                    
                        $mailingTekst .= '<br/><br/><a href="' . $unsubscribeLink . '">afmelden bij deze nieuwsbrief</a><br/>' . $adresRegel;
                        
                        $mailer = new PHPMailer( true );
                        $logger->debug( 'Mailer geconstruct' );
            
                        $mailer->setFrom( $ini['organisatie']['email'], $ini['organisatie']['organisatienaam'] ); //Name is optional
                        $mailer->Subject = "Informatie over " . $evenementnaam;
                        $mailer->Body = $mailingTekst;
                        $mailer->IsHTML( true );
                        $mailer->addAddress( $email );

                        if ( !$mailer->send() )
                        {
                            $bevestig = "Bedankt voor uw belangstelling. Uw verzoek is geregistreerd.";
                            $logger->error( 'Probleem bij verzenden mail.' . $mailer->ErrorInfo );
                            $logger->debug( $message );
                        }
                        else
                        {
                            $bevestig = "Bedankt voor uw belangstelling. Uw verzoek is geregistreerd.<br/>Er is een bevestiging naar uw mailadres verzonden.";
                            $logger->debug( 'De mail is verzonden naar de geadresseerden.' );
//                            alertAndGo( "Mailing is verzonden.", "mailing_verzenden.php");
                        }
            
                        $logger->debug( 'Informatieverzoek is geregistreerd' );

                    }

                }
                catch ( \Exception $e )
                {
                    $logger->errordump( $e );
                    if ( $geregistreerd )
                    {
                        $bevestig = "Bedankt voor uw belangsteling. Uw verzoek is geregistreerd.";
                    }
                    else
                    {
                        $bevestig = "Sorry, het verzenden van uw bevestiging is mislukt. Probeeer het later nog eens.";
                    }
                    $logger->error( 'Probleem bij aanmelden nieuwsbrief.' . $email );
                }
            }
        }
    }

// DEEL 3
    // Dit deel wordt altijd aangeroepen. De eerste keer met
    // - lege variabelen, of
    // - in geval van een wijziging, de gegevens van de te wijzigen persoon.
    // Dit deel vult de waarden in voor de HTML template en start deze op.

    $smarty->assign( 'doctitle', $doctitle );
    $smarty->assign( 'evenementnaam', $evenementnaam );
    $smarty->assign( 'evenementid', $evenementid );
    $smarty->assign( 'bevestig', $bevestig );
    $smarty->assign( 'naam', $naam );
    $smarty->assign( 'naamErr', $naamErr );
    $smarty->assign( 'email', $email );
    $smarty->assign( 'emailErr', $emailErr );

    $smarty->display( 'mailing_aanmelden.tpl' );
