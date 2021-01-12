<?php
/**
 * System      ERAS
 * Module      Persoon
 * Doel        Persoonsgegevens registreren of wijzigen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       11-09-2019
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
require_once 'persoonsgegevens_class.php';

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\Contactlog;

use fb_model\fb_model\GebruikerQuery;
use fb_model\fb_model\Inschrijving;
use Propel\Runtime\Propel;

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$doctitle = "Gegevens Contactpersoon";

// define variables and set to empty values
require_once 'persoon_define_variables.inc';

$validatiemelding = "";
$persoon = $id = $evt = $iid = null;
$readonly = null;
$sessieVariabelen = array();
$wijzigen = false;

// Deze is voor koppeling gebruiker aan persoon.
$gebruiker_email = null;

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;

$logger->debug( $doctitle );

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "registreer.php" );
$autorisatie->validate( AUTORISATIE_STATUS_GEEN );

$persoonsGegevens = new Persoonsgegevens( $autorisatie->getUserId() );
$extraContact = 0;
$aantalDeelnemers = 0;

if ( isset( $_SESSION['inschrijving'] ) )
{
    $sessieVariabelen = $_SESSION['inschrijving'];

    $evt = $sessieVariabelen["evenement_id"];
    $extraContact = $sessieVariabelen['extra_contact'];

    $wijzigen = getInschrijvingVar( $wijzigen );
    $aantalDeelnemers = getInschrijvingVar( $aantal_deelnemers );
}
else
{
    // Geen inschrijvingsdata? Verwijs naar keuzepagina
    $logger->error( "Geen inschrijvingsdata gevonden. Flow error." );
    alert( "Onjuiste volgorde van inschrijven." );
    header( "Location:inschrijving_overzicht.php" );
    exit();
}

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( getGetVar( $nolog ) == null )
    {
        $autorisatie->setNotAuth( "registreer.php" );
        $autorisatie->validate( AUTORISATIE_STATUS_KLANT );
    }
    else
    {
        $autorisatie->setNotAuth( "registreer.php" );
        $autorisatie->validate( AUTORISATIE_STATUS_GEEN );
    }

    getGetVar( $email );
    if ( $email != null )
    {
        $gebruiker_email = $email;
        $logger->debug( "Email adres in URL: " . $gebruiker_email );
    }

    getGetVar( $prs );

    if ( $prs != null )
    {
        $logger->debug( "Persoon ID in URL: " . $prs );
        $persoonsGegevens->load( $prs );
        // Als $wijzigen TRUE is, dan wordt de vorderingbalk niet getoond,
        // alleen de contactpersoongegevens verschijnen dan
        if ( $aantalDeelnemers == 0 )
        {
            $wijzigen = false;
        }
    }
    else
    {
        if ( $autorisatie->getUserId() != "" )
        {
            $persoonsGegevens->setEmail( $autorisatie->getUserId() );
            $logger->debug( "Inschrijver met account: " . $autorisatie->getUserId() );
        }
        else
        {
            // Inschrijver zonder account
            $logger->debug( "Inschrijver zonder account: " . $gebruiker_email );
            $persoonsGegevens->setEmail( $gebruiker_email );
        }
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

    if ( isset( $_POST['id'] ) )
    {
        $id = $_POST['id'];
        if ( $id > 0 )
        {
            $persoonsGegevens->load( $id );
            $wijzigen = true;
        }
        else
        {
            $persoonsGegevens->new();
        }
    }

    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $sessieVariabelen = $_SESSION['inschrijving'];
        if ( isset( $sessieVariabelen["inschrijving_id"] ) )
        {
            $iid = $sessieVariabelen["inschrijving_id"];
        }
    }
    else
    {
        $iid = 0;
    }

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $evt )
            ->go();
        $validateOk += $setVar->name( $required )
            ->go();
        $validateOk += $setVar->name( $deelnemer )
            ->go();
        $validateOk += $setVar->name( $gebruiker_email )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    $sessieVariabelen["is_deelnemer"] = $deelnemer;

    $req = false;
    if ( $required == "true" )
    {
        $req = true;
    }

    // Validatie persoonsgegevens
    $persoonsGegevens->setExtraGegevens( $extraContact );
    $persoonsGegevens->validate( $_POST );
    $validateOk += $persoonsGegevens->getValidateOk();

    if ( $validateOk == 0 )
    {
        $logger->debug( "Validatie ok" );
        $con->beginTransaction();
        try
        {
            if ( $persoonsGegevens->getEmail() == "" )
            {
                if ( $autorisatie->isLoggedIn() )
                {
                    $persoonsGegevens->setEmail( $autorisatie->getUserId() );
                }
            }

            $persoonsGegevens->save();

            $gebruiker = GebruikerQuery::create()->findPk( $gebruiker_email );
            if ( $gebruiker != null && $gebruiker->getIsActief() == "1" )
            {
                $gebruiker->setPersoonId( $persoonsGegevens->getId() );
                $gebruiker->setGewijzigdDoor( $autorisatie->getUserId() );
                $gebruiker->save();
            }

            $logger->debug( "Momenteel bekend userid: " . $autorisatie->getUserId() );
            $email = "";
            if ( $persoonsGegevens->getEmail() != "" )
            {
                $logger->debug( "Email bekend voor persoon, gebruik als userid: " . $persoonsGegevens->getEmail() );
                $email = $persoonsGegevens->getEmail();
            }
            else
            {
                $logger->debug( "Geen Email bekend voor persoon, gebruik achternaam als userid: " . $persoonsGegevens->getAchternaam() );
                //ToDo: Dit klopte niet dacht ik?
                //$email = $persoonsGegevens->getEmail( $persoonsGegevens->getAchternaam() );
                $email = $persoonsGegevens->getAchternaam();
            }
            $autorisatie->setUserId( $email );

//            $autorisatie->setRol( AUTORISATIE_STATUS_KLANT );

            $gebruiker = GebruikerQuery::create()->filterByUserId( $autorisatie->getUserId() )->filterByIsActief( "1" )->findOne();
            if ( $gebruiker == null )
            {
                $logger->warning( "Gebruiker " . $autorisatie->getUserId() . " is niet gevonden." );
            }
            else
            {
                $gebruiker->setPersoonId( $persoonsGegevens->getId() );
                $gebruiker->setGewijzigdDoor( $autorisatie->getUserId() );
                $gebruiker->save();
                $logger->debug( "Gebruiker " . $autorisatie->getUserId() . " is gevonden." );
            }

            // Koppelen persoonsgegevens aan userid

            if ( $iid > 0 )
            {
                $inschrijving = InschrijvingQuery::create()->findPk( $iid );
                if ( $inschrijving == null )
                {
                    $logger->error( "Fout bij opvragen inschrijving id=" . $iid );
                    echo "Fout bij opvragen inschrijving id=" . $iid;
                    exit;
                }
            }
            else
            {
                $inschrijving = new Inschrijving();
                $inschrijving->setGemaaktDoor( $email );
            }

            $email = $persoonsGegevens->getEmail();

            $inschrijving->setEvenementId( $evt );
            $inschrijving->setContactPersoonId( $persoonsGegevens->getId() );
            $inschrijving->setDatumInschrijving( date( "d-m-Y H:i:s" ) );
            $inschrijving->setStatus( INSCHRIJVING_STATUS_OPEN );
            $inschrijving->setAnnuleringsverzekeringAfgesloten( vanJaNee( "nee" ) );
            $inschrijving->setGewijzigdDoor( $email );
            $inschrijving->save();

            $contactlog = new Contactlog;
            $contactlog->setPersoonId( $persoonsGegevens->getId() );
            $contactlog->setTekst( "Als contactpersoon ingeschreven voor inschrijving ID " . $inschrijving->getId() );
            $contactlog->setGemaaktDoor( $email );
            $contactlog->save();

            $logger->debug( "Inschrijving opgevoerd met id " . $inschrijving->getId() );

            if ( $evt == null )
            {
                $logger->debug( 'Geen evenement, gegevens van persoon ' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );
                alert( 'Gegevens van persoon ' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );
                header( "Refresh:0" );
                exit();
            }

            $naam = $persoonsGegevens->getVoornaam() . " " . $persoonsGegevens->getTussenvoegsel() . " " . $persoonsGegevens->getAchternaam();
            $logger->debug( 'Bestaand evenement, ga naar inschrijving_opties' );
            $sessieVariabelen["inschrijving_id"] = $inschrijving->getId();
            $sessieVariabelen["contactpersoon_id"] = $persoonsGegevens->getId();
            $sessieVariabelen["contactpersoon_naam"] = $naam;
            $sessieVariabelen["contactpersoon_email"] = $persoonsGegevens->getEmail();
            $sessieVariabelen["evenement_id"] = $evt;
            $sessieVariabelen["is_deelnemer"] = $deelnemer;
            $_SESSION['inschrijving'] = $sessieVariabelen;

            $con->commit();
            $logger->debug( "Commit van bovenstaande." );

            // Inschrijving in evenement, start nu opties
            // Volgende deelnemer.
            $logger->debug( "Is deelnemer: " . $deelnemer );

            if ( $deelnemer == OPTIE_KEUZE_JA )
            {
                $logger->debug( "Deelnemergegevens invoeren voor contactpersoon." );
                //header( "Location:inschrijving_deelnemer.php?evt=" . $evt . "&prs=" . $persoon->getId() );
                header( "Location:inschrijving_deelnemer.php?evt=" . $evt );
                exit();
            }
            else
            {
                header( "Location:inschrijving_overzicht.php" );
                exit();
            }
            exit();
        }
        catch ( \Exception $e )
        {
            $con->rollback();
            if ( $e->getPrevious() != null )
            {
                $logger->error( 'Probleem met opslaan gegevens contactpersoon, foutcode ' . $e->getPrevious()->errorInfo[1] );
                $logger->error( $e->getPrevious()->errorInfo[2] );
                $validatiemelding = 'Probleem met opslaan gegevens, foutcode ' . $e->getPrevious()->errorInfo[1];
            }
            else
            {
                $validatiemelding = 'Probleem met opslaan gegevens, ' . $e->getMessage();
            }
            $logger->dump( $e );
        }
    }
    else
    {
        $logger->error( 'Validatie contactpersoongegevens niet ok: ' . $validateOk );
        $validatiemelding = 'Validatie contactpersoongegevens niet ok: ' . $validateOk;
        //alert( 'Validatie contactpersoongegevens niet ok: ' . $validateOk );
    }
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.
if ( $id == null )
{
    $id_visibility = "hide";
}
else
{
    $id_visibility = "show";
}

$jachecked = '';
$neechecked = 'checked = "checked"';

if ( isset( $sessieVariabelen["is_deelnemer"] ) )
{
    if ( $sessieVariabelen["is_deelnemer"] == 'ja' )
    {
        $jachecked = 'checked = "checked"';
        $neechecked = '';
    }
}

require_once 'persoon_template.php';

$smarty->assign( 'jachecked', $jachecked );
$smarty->assign( 'neechecked', $neechecked );
$smarty->assign( 'wijzigen', $wijzigen );
$smarty->assign( 'all', '0' );

// Deze is voor koppeling gebruiker aan persoon.
$smarty->assign( 'gebruiker_email', $gebruiker_email );
$smarty->assign( 'readonly_email', "readonly" );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_contactpersoon.tpl' );
