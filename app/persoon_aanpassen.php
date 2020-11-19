<?php
/**
 * System      ERAS
 * Module      Persoon aanpassen
 * Doel        Persoonsgegevens wijzigen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       13-01-2020
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
require_once 'persoonsgegevens_class.php';

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use Propel\Runtime\Propel;

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Persoonsgegevens aanpassen";

// define variables and set to empty values
require_once 'persoon_define_variables.inc';

$validatiemelding = "";
$all = 0;
$evt = "";
$persoon = $id = null;
$readonly = null;
$sessieVariabelen = array();
$wijzigen = false;

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;

$logger->debug( $doctitle );

$statusRegel = "";
$signalError = false;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "registreer.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

$persoonsGegevens = new Persoonsgegevens( $autorisatie->getUserId() );
$extraContact = 0;

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?id= parameter,
// Voorbeeld: http://www.mijnsite.com/persoon?id=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van persoon 234.
// Wordt de ?id= parameter niet opgegeven dan gaat het om een nieuwe persoon en wordt
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $sessieVariabelen = $_SESSION['inschrijving'];
        $evt = $sessieVariabelen["evenement_id"];

        //ToDo: Deze was afgesterd. Waarom weet ik niet
        $extraContact = $sessieVariabelen['extra_contact'];
    }
    else
    {
        if ( !isset( $_GET['evt'] ) && !isset( $_GET['prs'] ) )
        {
            $logger->debug( "Geen evt of prs in url. Terug naar evenementenlijst" );
            alert( 'Persoon opvoeren moet via "Evenement kiezen -> inschrijving opvoeren"' );
            header( "Location:evenement_kiezen.php" );
            exit();
        }

        if ( isset( $_GET['evt'] ) )
        {
            $evt = $_GET['evt'];
        }
    }

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];
    }

    if ( isset( $_GET['prs'] ) )
    {
        $id = $_GET['prs'];

        if ( $id != null )
        {

            if ( isset( $_GET['all'] ) )
            {
                $extraContact = $extraContact | VOLLEDIGHEID_GESLACHT | VOLLEDIGHEID_LANDNAAM | VOLLEDIGHEID_TELEFOON | VOLLEDIGHEID_MAIL | VOLLEDIGHEID_GEBOORTEDATUM;
                $all = 1;
            }

            $persoonsGegevens->load( $id );
            $wijzigen = true;
        }
    }
    else
    {
        $logger->debug( "Geen prs in url. Terug naar evenementenlijst" );
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

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $all )
            ->go();
        $validateOk += $setVar->name( $required )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['id'] ) )
    {
        $id = $_POST['id'];
        $persoonsGegevens->load( $id );
        $wijzigen = true;
    }

//ToDo: Hoe werkt dit eigenlijk? Landnaam is aanwezig bij GET maar verdwijnt bij POST
//      Wat staat er in extra_contact? Wat doet $all?
    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $sessieVariabelen = $_SESSION['inschrijving'];
        $evt = $sessieVariabelen["evenement_id"];
        if ( array_key_exists('extra_contact', $sessieVariabelen ) )
        {
            $extraContact = $sessieVariabelen['extra_contact'];
        }
    }
    else
    {
        if ( !$all )
        {
            // Geen inschrijvingsdata? Verwijs naar keuzepagina
            $logger->error( "Geen inschrijvingsdata gevonden. Flow error." );
            echo ( "Onjuiste volgorde van inschrijven." );
            return;
        }
    }

    $req = false;
    if ( $required == "true" )
    {
        $req = true;
    }

    // Validatie persoonsgegevens

    if ( $all )
    {
        $persoonsGegevens->setAll( "1" );
        $persoonsGegevens->setExtraGegevens( 0 );
        $extraContact = $extraContact | VOLLEDIGHEID_GESLACHT | VOLLEDIGHEID_LANDNAAM | VOLLEDIGHEID_TELEFOON | VOLLEDIGHEID_MAIL | VOLLEDIGHEID_GEBOORTEDATUM;
    }
    else
    {
        $persoonsGegevens->setExtraGegevens( $extraContact );
    }

    if ( isset( $_POST['opslaan'] ) )
    {
        $persoonsGegevens->validate( $_POST );
        $validateOk += $persoonsGegevens->getValidateOk();

        if ( $validateOk == 0 )
        {
            $logger->debug( "Validatie ok" );
            $con->beginTransaction();
            try
            {
                $persoonsGegevens->save();

                $naam = $persoonsGegevens->getVoornaam() . " " . $persoonsGegevens->getTussenvoegsel() . " " . $persoonsGegevens->getAchternaam();
                $logger->debug( 'Bestaand evenement, ga naar inschrijving_opties' );
                $sessieVariabelen["contactpersoon_id"] = $persoonsGegevens->getId();
                $sessieVariabelen["contactpersoon_naam"] = $naam;
                $sessieVariabelen["contactpersoon_email"] = $persoonsGegevens->getEmail();
                $sessieVariabelen["evenement_id"] = $evt;
//ToDo: Waar diende dit voor?                $sessieVariabelen["is_deelnemer"] = $deelnemer;   
                $_SESSION['inschrijving'] = $sessieVariabelen;

                $con->commit();
                $logger->debug( "Commit van bovenstaande." );

                $statusRegel = "Persoonsgegevens aangepast.";
            }
            catch ( \Exception $e )
            {
                $con->rollback();
                $logger->error( 'Probleem met opslaan persoonsgegevens, foutcode ' . $e->getPrevious()->errorInfo[1] );
                $logger->error( $e->getPrevious()->errorInfo[2] );
                $logger->dump( $e );
                $validatiemelding = 'Probleem met opslaan gegevens, foutcode ' . $e->getPrevious()->errorInfo[1];
                $statusRegel = "Fout bij opslaan persoonsgegevens.";
                $signalError = true;
                alert( "Er is een foutsituatie ontstaan bij het opslaan. Gegevens zijn niet gewijzigd." );
            }
        }
        else
        {
            $logger->error( 'Validatie persoonsgegevens niet ok, foutcode ' . $validateOk );
            alert( "Er is iets misgegaan bij het opslaan. Validatiecode=" . $validateOk );
        }
    }
    //exit;
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

// Deze zijn voor persoon_template
if ( $id == null )
{
    $id_visibility = "hide";
}
else
{
    $id_visibility = "show";
}

require_once 'persoon_template.php';

$smarty->assign( 'id', $id );
$smarty->assign( 'all', $all );
$smarty->assign( 'wijzigen', $wijzigen );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );
$smarty->assign( 'readonly_email', "readonly" );

$smarty->display( 'persoon_aanpassen.tpl' );
