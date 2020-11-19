<?php
/**
 * System      ERAS
 * Module      Mail wijzigen
 * Doel        Wijzigen email adres van contactpersoon
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       28-10-2020
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

$sessie = new Sessie();

$doctitle = "E-mail wijzigen";
$logger = new Logger();
$logger->level( LOGLEVEL );

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use fb_model\fb_model\Base\PersoonQuery;
use Respect\Validation\Validator as v;
use Propel\Runtime\Propel;
use \fb_model\fb_model\GebruikerQuery;
use fb_model\fb_model\Contactlog;

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );

// Defineer variabelen voor email wijzigen
$email = $emailErr = $password = $passwordErr = "";
$newEmail = $newEmailErr = $repeatNewEmail = $repeatNewEmailErr = "";
$previous = "";

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    if ( $previous == "" )
    {
        $previous = "javascript:history.go(-1)";
        if ( isset( $_SESSION['referer'] ) )
        {
            $previous = $_SESSION['referer'];
            $logger->debug( "referer=" . $previous );
        }
        $logger->debug( "Previous=" . $previous );
    }
    else
    {
        $logger->debug( "Previous was al gevuld met " . $previous );
    }

    if ( isset( $_SESSION['wijzig_email'] ))
    {
        $email = $_SESSION['wijzig_email'];
        unset ($_SESSION['wijzig_email']);
    }

} // GET

// DEEL 2
// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    // Geen $_POST dumpen, hier staat het wachtwoord in klare tekst in!
     $logger->dump( $_POST );

    if ( isset( $_POST['terug'] ) )
    {
        alertAndGo( "Uw mailadres is niet gewijzigd.", "registreer.php" );
        exit;
    }

    $validateOk = 0;
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $wijzigWachtwoord )
            ->go();
        $validateOk += $setVar->name( $previous )
            ->go();
        $validateOk += $setVar->name( $email )
            ->onerror( $emailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $newEmail )
            ->onerror( $newEmailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $repeatNewEmail )
            ->onerror( $repeatNewEmailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $password )
            ->onerror( $passwordErr )
            ->noHtmlCleaning()
            ->validator( v::alwaysValid()->length( 1, 255 ) )
            ->required( true )
            ->go();

        if ( $newEmail != $repeatNewEmail )
        {
            $repeatNewEmailErr = "Mailadres en bevestig mailadres komen niet overeen.";
            $validateOk += 900;
        }

        $test = GebruikerQuery::create()->filterByUserId( $newEmail )->findOne();
        if ( $test != null )
        {
            $newEmailErr = "Dit mailadres bestaat al. Kies een ander mailadres";
            $validateOk += 900;
        }

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
            // Afremmen wachtwoord raden
            sleep(1);
            $allOk = false;
            $gebruiker = GebruikerQuery::create()->filterByUserId( $email )->findOne();
            if ( $gebruiker != null )
            {
                if ( password_verify( $password, $gebruiker->getWachtwoord() ) )
                {
                    $con->beginTransaction();
                    try
                    {
                        // Mailadres en wachtwoord kloppen
                        $logger->debug("Mailadres en wachtwoord kloppen");

                        // Wijzig mailadres (=userid) in de gebruikertabel
                        $gebruiker->setUserId( $newEmail );
                        $gebruiker->save();

                        $persoonId = $gebruiker->getPersoonId();
                        if ( $persoonId != null )
                        {
                            $logger->debug("PersoonID is niet null");
                            // En wijzig dit in de persoontabel
                            $persoon = PersoonQuery::create()->findPk( $persoonId );
                            if ( $persoon == null )
                            {
                                $logger->info( "Persoon " . $persoonId . " wordt wel genoemd in de gebruikertabel (user: " . $email .") maar is niet gevonden in de persoontabel");
                            }
                            else
                            {
                                $logger->debug("Persoon gevonden in persoontabel");
                                $persoon->setEmail( $newEmail );
                                $persoon->save();

                                $logger->debug("Persoon opgeslagen met nieuw mailadres");

                                $contactlog = new Contactlog;
                                $contactlog->setPersoonId( $persoonId );
                                $contactlog->setTekst( "Email adres van gebruiker ID " . $gebruiker->getId() . " is gewijzigd van " . $email . " naar " . $newEmail . ". Door gebruiker zelf"); 
                                $contactlog->setGemaaktDoor( $gebruiker->getUserId() );
                                $contactlog->save();
                            }

                        }
                        $con->commit();
                        alertAndGo( "Uw mailadres is met succes gewijzigd in " . $newEmail, "registreer.php" );
                    }
                    catch( Exception $ex )
                    {
                        $logger->error( "Exception bij wijzigen mailadres" );
                        $logger->errordump( $ex );
                        $con->rollback();
                    }

                }
                else
                {
                    $logger->security( "Mailadres " . $email . " onjuist wachtwoord." );
                    $passwordErr = "Mailadres of wachtwoord is niet correct";
                }
            }
            else
            {
                $logger->info( "Email adres " . $email . " bestaat niet." );
                $passwordErr = "Mailadres of wachtwoord is niet correct";
            }
        }
        catch ( \Exception $e )
        {
            $logger->security( 'Probleem met inloggen' );
            $logger->errordump( $e );
            $validatiemelding = 'Probleem met inloggen.';
            alert( 'Probleem met inloggen. ' . $e->getMessage() );
        }

    }
    else
    {
        $logger->info( "Validatie " . $email . " niet akkoord, validateOk=" . $validateOk );
    }

} // POST

// DEEL 3
$logger->debug( "Previous=" . $previous );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'previous', $previous );
$smarty->assign( 'email', $email );
$smarty->assign( 'emailErr', $emailErr );
$smarty->assign( 'password', $password );
$smarty->assign( 'passwordErr', $passwordErr );
$smarty->assign( 'newEmail', $newEmail );
$smarty->assign( 'newEmailErr', $newEmailErr );
$smarty->assign( 'repeatNewEmail', $repeatNewEmail );
$smarty->assign( 'repeatNewEmailErr', $repeatNewEmailErr );

$smarty->display( 'email_wijzigen.tpl' );
