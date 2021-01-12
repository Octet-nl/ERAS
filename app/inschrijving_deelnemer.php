<?php
/**
 * System      ERAS
 * Module      Inschrijving deelnemers
 * Doel        Persoonsgegevens voor inschrijving registreren
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       11-08-2019
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

use fb_model\fb_model\Base\GebruikerQuery;
use fb_model\fb_model\Base\PersoonQuery;
use fb_model\fb_model\Deelnemer;
use fb_model\fb_model\DeelnemerHeeftOptie;
use fb_model\fb_model\DeelnemerHeeftOptieQuery;
use fb_model\fb_model\DeelnemerQuery;
use Propel\Runtime\Propel;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\KeuzesQuery;
use \fb_model\fb_model\OptieQuery;

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$statusRegel = "";
$signalError = false;

$doctitle = "Inschrijving deelnemer";

// define screen variables and set to empty values
require_once 'persoon_define_variables.inc';

$contactPersoonId = null;
$persoon = null;
$extraTekst = "";
$sessieVariabelen = null;
$contactIsDeelnemer = false;
$aantal_beschikbaar = 0;
$aantal_deelnemers = 1;
$aantal_deelnemersErr = "";
$persoonId = 0;
$status = 0;
$evt = 0;
$inschrijvingnummer = 0;
$validatiemelding = "";
$optieArray = array();
$readonlyEmail = "";

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;
$deelnemerOpties = array();
$wijzigingDefinitieveInschrijving = false;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "registreer.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

$persoonsGegevens = new Persoonsgegevens( $autorisatie->getUserId() );
$extraContact = 0;

$autorisatie = new Autorisatie();
//$autorisatie->setNotAuth( "inschrijving_overzicht.php" );
//$autorisatie->validate( AUTORISATIE_STATUS_KLANT );
// Klant wordt hier pas geautoriseerd, dus bovenstaande heeft nog geen zin.

if ( isset( $_SESSION['inschrijving'] ) )
{
    $sessieVariabelen = $_SESSION['inschrijving'];
}
else
{
    // Geen inschrijvingsdata? Verwijs naar keuzepagina
    //$routing = new Routing();
    //$routing->go();
    header( "Location:inschrijving_overzicht.php" );
    exit();
}

// DEEL 1
// De GET method wordt alleen getriggerd als dit script voor het eerst wordt aangeroepen.
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( $sessieVariabelen != null )
    {
        $evt = $sessieVariabelen["evenement_id"];
        $inschrijvingnummer = $sessieVariabelen["inschrijving_id"];

        $contactIsDeelnemer = vanJaNee( $sessieVariabelen["is_deelnemer"] );

        $extraContact = $sessieVariabelen['extra_deelnemer'];

        if ( $autorisatie->getRol() <= AUTORISATIE_STATUS_KLANT )
        {
            if (  ( $sessieVariabelen['inschrijving_status'] == INSCHRIJVING_STATUS_DEFINITIEF ) )
            {
                $wijzigingDefinitieveInschrijving = true;
                $logger->debug( "Wijziging definitieve inschrijving door klant" );
            }
            $logger->debug( "Wijziging maar geen definitieve inschrijving" );
        }
        else
        {
            $wijzigingDefinitieveInschrijving = false;
            $logger->debug( "Geen wijziging inschrijving door klant" );
        }
    
        $deelnemerId = null;
        $deelnemer = null;
        if ( isset( $_GET['mut'] ) )
        {
            $deelnemerId = $_GET['mut'];

            // Kijk of deze deelnemer als gebruiker (contactpersoon) geregistreerd staat
            $deelnemer = DeelnemerQuery::create()->findPK( $deelnemerId );
            if ( $deelnemer != null )
            {
                $persoonId = $deelnemer->getPersoonId();
                $persoon = PersoonQuery::create()->findPk( $persoonId );
                $gebruiker = GebruikerQuery::create()->filterByUserId( $persoon->getEmail() )->filterByPersoonId( $persoonId )->filterByIsActief("1")->findOne( );
                if ( $gebruiker != null )
                {
                    $logger->debug( "PersoonId " . $persoonId . ", email " . $persoon->getEmail() . " is contactpersoon");
                    $readonlyEmail = "readonly";
                }
            }
        }

        // Test persoonId
        if ( $contactIsDeelnemer || $deelnemerId != null )
        {
            if ( $contactIsDeelnemer )
            {
                $extraTekst = "(Uzelf)";
                $readonlyEmail = "readonly";
            }
            else
            {
                $extraTekst = "(Inschrijfnummer " . $deelnemerId . ")";
            }

            if ( $contactIsDeelnemer )
            {
                $persoonId = $sessieVariabelen["contactpersoon_id"];
                $persoon = $persoonsGegevens->load( $persoonId );
                $logger->debug( "Contact is deelnemer. Persoonsgegevens geladen voor persoon " . $persoonId );
            }
            else // Wijzigen bestaande deelnemer
            {
//                $deelnemer = DeelnemerQuery::create()->findPK( $deelnemerId );
                if ( $deelnemer != null )
                {
                    $persoonId = $deelnemer->getPersoonId();
                    $persoon = $persoonsGegevens->load( $persoonId );
                    $logger->debug( "Bestaande deelnemer. Persoonsgegevens geladen voor persoon " . $persoonId );

                    require_once "opties_huidig.php";
                    $deelnemerOpties = deelnemerOpties( $deelnemerId );
                }
                else
                {
                    echo "Deelnemer " . $deelnemerId . " is niet gevonden.";
                    $logger->error( "DeelnemerId " . $deelnemerId . " is niet gevonden." );
                    exit;
                }
            }

            if ( $persoon == null )
            {
                echo "Persoon " . $persoonId . " is niet gevonden.";
                $logger->error( "DeelnemerId " . $deelnemerId . ", PersoonId " . $persoonId . " is niet gevonden." );
                exit;
            }
        }
        else
        {
            $logger->debug( " Contact is geen deelnemer of deelnemerId == null. Nieuw persoon geladen." );
        }

    }
    else
    {
        if ( isset( $_GET['evt'] ) )
        {
            $evt = $_GET['evt'];
        }
        else
        {
            echo "Geen sessiedata en geen evenement ID opgegeven";
            $logger->info( "Geen sessiedata en geen evenement ID opgegeven" );
            return;
        }
    }

    if ( is_numeric( $evt ) )
    {
        $logger->debug( "Evenement " . $evt );
        $evenement = EvenementQuery::create()->findPK( $evt );
        if ( $evenement != null )
        {
            $status = $evenement->getStatus();
            if ( $status != EVENEMENT_STATUS_OPEN )
            {
                $statusNaam = KeuzesQuery::create()->filterByCode( $status )->findOne()->getNaam();
                $logger->warning( "Dit evenement is niet geopend voor inschrijvingen. Status is: " . $statusNaam );
                alert( "Dit evenement is niet geopend voor inschrijvingen. Status is: " . $statusNaam );
                return;
            }
        }
        else
        {
            $logger->info( "Evenement " . $evt . " is niet gevonden." );
            echo "Evenement " . $evt . " is niet gevonden.";
            //return;
        }

        // Haal alle deelnemeropties voor dit evenement.
        $opties = OptieQuery::create()
            ->filterByPerDeelnemer( '1' )
            ->useEvenementHeeftOptieQuery()
            ->filterByEvenementId( $evt )
            ->orderByVolgorde()
            ->endUse()
            ->orderByGroep()
            ->find();

        //     $current = array();
        //     $current = DeelnemerHeeftOptieQuery::create()->filterByDeelnemerId( "1" )->find();

        $logger->debug( "Genereer dynamisch HTML" );
        require_once "opties_naar_html_class.php";
        $optiesNaarHtml = new optiesNaarHtml();
        $optiesNaarHtml->setEvenementId( $evt );
        $optiesNaarHtml->setAutorisatieRol( $autorisatie->getRol() );
        $optiesNaarHtml->setWijzigenDefinitieveInschrijving( $wijzigingDefinitieveInschrijving );
        $optiesNaarHtml->setKopregel( "Opties voor deze deelnemer" );

        if ( $deelnemerId != null )
        {
            $logger->debug( "d.m.v. deelnemerOpties:" );
            $logger->dump( $deelnemerOpties );
            $optiesNaarHtml->setCurrent( $deelnemerOpties );
        }
        else
        {
            $logger->debug( "Deelnemer ID is null" );
        }
        
        //$optiesNaarHtml->enableInternGebruik( true );
        $optiesNaarHtml->genereerHtml( $opties );
        $dynamicHtml = $optiesNaarHtml->getHtml();
        $optieArray = $optiesNaarHtml->getOptieArray();
        $logger->dump( $optieArray );
    }
    else
    {
        echo "Geen evenement opgegeven";
        $logger->info( "Geen evenement opgegeven" );
        return;
    }
}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert niets, de invoer is gevuld met zinvolle default waarden.
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    $optieArray = array();
    if ( isset( $_SESSION['opties'] ) )
    {
        $logger->info( "Opties aanwezig in SESSION" );
        $optieArray = $_SESSION['opties'];
        $logger->dump( $optieArray );
    }

    $extraContact = $sessieVariabelen['extra_deelnemer'];
    $inschrijvingnummer = $sessieVariabelen["inschrijving_id"];
    
    try
    {
        $setVar = new SetVariable();
        // POST variabelen zonder validatie
        $setVar->name( $evt )->go();
        $setVar->name( $deelnemerId )->go();
        $setVar->name( $totaalprijs )->go();
        $setVar->name( $readonlyEmail )->go();
        $setVar->name( $wijzigingDefinitieveInschrijving )->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST["annuleren"] ) )
    {
        header( "location:inschrijving_overzicht.php?evt=" . $evt . "&prs=" . $deelnemerId );
        exit;
    }

    $logger->debug( "Geen DynamicHTML aanwezig in SESSION, genereer" );
    $opties = OptieQuery::create()
        ->filterByPerDeelnemer( '1' )
        ->useEvenementHeeftOptieQuery()
        ->filterByEvenementId( $evt )
        ->orderByVolgorde()
        ->endUse()
        ->orderByGroep()
        ->find();

    $logger->debug( "Genereer dynamisch HTML d.m.v. POST." );

    require "opties_naar_html_class.php";
    $optiesNaarHtml = new optiesNaarHtml();
    $optiesNaarHtml->setEvenementId( $evt );
    $optiesNaarHtml->setAutorisatieRol( $autorisatie->getRol() );
    $optiesNaarHtml->setKopregel( "Opties voor deze deelnemer" );
    $optiesNaarHtml->setWijzigenDefinitieveInschrijving( $wijzigingDefinitieveInschrijving );
    $optiesNaarHtml->setCurrent( $_POST );
    $dynHtml = $optiesNaarHtml->genereerHtml( $opties );
    $dynamicHtml = $optiesNaarHtml->getHtml();
    $optieArray = $optiesNaarHtml->getOptieArray();

    $validateOk = 0;

    // Validatie persoonsgegevens
    $contactPersoonId = $sessieVariabelen["contactpersoon_id"];

    if ( vanJaNee( $sessieVariabelen["is_deelnemer"] ) )
    {
        $persoon = $persoonsGegevens->load( $contactPersoonId );
        if ( $persoon == null )
        {
            alert( "Contactpersoon " . $contactPersoonId . " is niet gevonden." );
            $logger->error( "Contactpersoon, Id=" . $contactPersoonId . ", is niet gevonden." );
            return;
        }
        if ( $deelnemerId != null )
        {
            $deelnemer = DeelnemerQuery::create()->findPK( $deelnemerId );
        }
        else
        {
            $deelnemer = DeelnemerQuery::create()->filterByInschrijvingId($sessieVariabelen["inschrijving_id"])->findOneByPersoonId( $contactPersoonId );
        }
    }
    else
    {
        if ( $deelnemerId != null )
        {
            $deelnemer = DeelnemerQuery::create()->findPK( $deelnemerId );
            $persoonId = $deelnemer->getPersoonId();
            $persoon = $persoonsGegevens->load( $persoonId );
            if ( $persoon == null )
            {
                alert( "Persoon " . $persoonId . " is niet gevonden." );
                $logger->error( "Deelnemer/persoon , Id=" . $persoonId . ", is niet gevonden." );
                return;
            }
            else
            {
                $logger->debug( "Bestaand contactpersoon, id=" . $persoonId );
                $persoonsGegevens->setCreator( $email );
            }
        }
        else
        {
            $persoonsGegevens->setCreator( $email );
            $persoonsGegevens->new();
            $logger->debug( "Deelnemer ID is null, nieuw persoon toegevoegd" );
        }
    }

    $persoonsGegevens->setExtraGegevens( $extraContact );
    // Volgende vult het persoonsgegevens object met de data uit de POST
    $persoonsGegevens->validate( $_POST );
    $validateOk += $persoonsGegevens->getValidateOk();

    if ( $validateOk == 0 )
    {
        $logger->debug( "Persoonsgegevens gevalideerd, alles OK" );

        $con->beginTransaction();

        try
        {
            ////////////////////////////////////////////
            // Persoon en deelnemergegevens vastleggen
            ////////////////////////////////////////////

            $persoonsGegevens->save();

            if ( !$wijzigingDefinitieveInschrijving )
            {
                if ( $deelnemerId == null )
                {
                    $deelnemer = new Deelnemer();
                    $deelnemer->setGemaaktDoor( $email );
                }
                $deelnemer->setGewijzigdDoor( $email );
                $deelnemer->setPersoonId( $persoonsGegevens->getId() );
                $deelnemer->setInschrijvingId( $sessieVariabelen["inschrijving_id"] );
                $deelnemer->setTotaalbedrag( $totaalprijs );
                $deelnemer->setStatus( "DEELNEMER_STATUS_ACTIEF" );
                $logger->debug( "Deelnemer vastleggen, PersoonID: " . $persoonsGegevens->getId() . ", InschrijvingsID: " . $sessieVariabelen["inschrijving_id"] . ", Totaalprijs: " . $totaalprijs );
                $deelnemer->save();

                $logger->debug( "Evenement " . $evt );

                if ( $evt == null )
                {
                    $logger->debug( 'Gegevens van persoon ' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );
                    alert( 'Gegevens van persoon ' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );
                    header( "Refresh:0" );
                    exit();
                }
                else
                {
                    $logger->debug( 'Gegevens van persoon ' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );
                    $sessieVariabelen["is_deelnemer"] = OPTIE_KEUZE_NEE;
                    $_SESSION['inschrijving'] = $sessieVariabelen;
                }

                //////////////////////////////////////////
                // Opties vastleggen
                //////////////////////////////////////////

                // Verwijderen van alle deelnemer-opties
                $opties = DeelnemerHeeftOptieQuery::create()->filterByDeelnemerId( $deelnemerId )->find();
                //$opties->delete();
                foreach ( $opties as $optie )
                {
                    $logger->debug( "Verwijderen inschrijvingsoptie ID=" . $optie->getId() );
                    $optie->delete();
                }

                // Deze is niet vaak nodig maar geeft een hoop uitvoer
                $logger->dump( $optieArray );

                // En nu alle geselecteerde opties weer opvoeren.
                //foreach ( $_POST as $key => $value )
                {
                    $logger->verbose( 'POST, key: ' . $key . ', value: ' . $value );
                    $value = cleanInput( $_POST[$key] );

                    foreach ( $optieArray as $optienaam )
                    {
                        $oGroep = "";
                        $naam = cleanOptieNaam( $optienaam["naam"] );
                        $key = "";
                        if ( array_key_exists( $naam, $_POST ) )
                        {
                            $key = $naam;
                            $value = $_POST[$naam];
                        }
                        else
                        {
                            continue;
                        }

                        if ( array_key_exists( "groep", $optienaam ) )
                        {
                            $oGroep = cleanOptieNaam( $optienaam["groep"] );
                        }
                        if ( $oGroep == $key || cleanOptieNaam( $optienaam["naam"] ) == $key )
                        {
                            $logger->verbose( 'Optie "' . $key .'", value "' . $value . '" match' );
                            if ( $optienaam["type"] == OPTIETYPE_KEUZE_RADIO || $optienaam["type"] == OPTIETYPE_KEUZE_MEERDERE )
                            {
                                if ( $optienaam["id"] == $value )
                                {
                                    $logger->verbose( 'Vastleggen optie (radio/meerdere) ID: ' . $optienaam["id"] . ' key: ' . $key . ' value: ' . $value );
                                    $logger->verbose( 'OptieID: ' . $optienaam["id"] . ' DeelnemerID: ' . $deelnemer->getId() . ' Waarde: ' . $value . ' Prijs: ' . $optienaam["prijs"] );
                                    deelnemerOptieToevoegen( $optienaam["id"], $deelnemer->getId(), $value, $optienaam["prijs"], $email );
                                }
                            }
                            else
                            {
                                // Bij een Ja/Nee optie wordt bij keuze NEE de prijs op 0.00 gezet.
                                $prijs = $optienaam["prijs"];
                                if ( $optienaam["type"] == OPTIETYPE_KEUZE_JA_NEE )
                                {
                                    if ( $value == OPTIE_KEUZE_NEE )
                                    {
                                        $prijs = "0.00";
                                    }
                                }

                                // bij aantal moet de prijs vermenigvuldigd met het aantal
                                if ( $optienaam["type"] == OPTIETYPE_AANTAL )
                                {
                                    $prijs = $prijs * $value;
                                }

                                if ( $optienaam["type"] == OPTIETYPE_AKKOORD)
                                {
                                    $logger->verbose( 'Vastleggen optie (akkoord) ID: ' . $optienaam["id"] . ' key: ' . $key . ' value: ' . $value );
                                }
                                else
                                {
                                    $logger->verbose( 'Vastleggen optie (ja/nee of aantal): ' . $optienaam["id"] . ' key: ' . $key . ' value: ' . $value );
                                }
                                $logger->verbose( 'OptieID: ' . $optienaam["id"] . ' DeelnemerID: ' . $deelnemer->getId() . ' Waarde: ' . $value . ' Prijs: ' . $prijs );
                                deelnemerOptieToevoegen( $optienaam["id"], $deelnemer->getId(), $value, $prijs, $email );
                                $prijs = 0;
    
                            }
                        }
                    }
                }
            }
            else
            {
                //ToDo: Bij definitieve inschrijving kunnen sommige zaken nog wel gewijzigd worden 
                // Bijvoorbeeld EHBO diploma en opmerkingen. 
                // Dan moeten dus niet alle opties eerst gewist worden, maar moeten ze per stuk indien van toepassing worden aangepast.
                $logger->debug( "Wijziging definitieve inschrijving. Gewijzigde gegevens niet vastgelegd, PersoonID: " . $persoonsGegevens->getId() . ", InschrijvingsID: " . $sessieVariabelen["inschrijving_id"] . ", Totaalprijs: " . $totaalprijs );
            }

//            $con->rollback();
            $con->commit();

            $logger->debug( 'Deelnemergegevens voor persoonID=' . $persoonsGegevens->getId() . ' zijn opgeslagen.' );

            //ToDo: Moet dit of kan dit blijven bestaan (voor terug-knop bijvoorbeeld):
            unset( $_SESSION['dynamicHtml'] );

            $status = 0;

            // Volgende deelnemer.
            header( "Location:inschrijving_overzicht.php?evt=" . $evt . "&prs=" . $contactPersoonId );
        }
        catch ( \Exception $e )
        {
            $con->rollback();
            $logger->errordump( $e );
            $logger->error( 'Probleem met opslaan gegevens, foutcode ' . $e->getPrevious()->errorInfo[1] );
            $logger->error( "deelnemer PersoonId " . $persoonsGegevens->getId() . ", deelnemer InschrijvingId " . $sessieVariabelen["inschrijving_id"] );
            $logger->error( $e->getPrevious()->errorInfo[2] );
            alert( 'Probleem met opslaan gegevens, details:\n' . $e->getMessage() );
        }
    }
    else
    {
        $logger->error( "Validatie persoonsgegevens niet ok (" . $validateOk . "), verder geen verwerking." );
    }

}

function deelnemerOptieToevoegen( $optieId, $deelnemerId, $waarde, $prijs, $email )
{
    global $logger;

    $logger->debug( "Optie vastleggen, OptieID " . $optieId . ", DeelnemerID " . $deelnemerId . ", Waarde " . $waarde );
    $deelnemerOptie = new deelnemerHeeftOptie();
    $deelnemerOptie->setOptieId( $optieId );
    $deelnemerOptie->setDeelnemerId( $deelnemerId );
    $deelnemerOptie->setWaarde( $waarde );
    $deelnemerOptie->setPrijs( $prijs );
    $deelnemerOptie->setGemaaktDoor( $email );
    $deelnemerOptie->setGewijzigdDoor( $email );
    $deelnemerOptie->save();
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

$logger->debug( "Optiearray en dynamichtml NIET naar SESSION" );

// Variabelen zijn nodig voor persoon_template
$readonly = true;
$id = 0;
$id_visibility = "hide";
require_once 'persoon_template.php';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenement_naam', $sessieVariabelen["evenement_naam"] );
if ( $persoon == null && $sessieVariabelen == null )
{
    $smarty->assign( 'contactpersoon_naam', "" );
    $sessieVariabelen["contactpersoon_email"] = "";
}
else
{
    $smarty->assign( 'contactpersoon_naam', $sessieVariabelen["contactpersoon_naam"] );
    $sessieVariabelen["contactpersoon_email"] = $sessieVariabelen["contactpersoon_email"];
}
$smarty->assign( 'extra_tekst', $extraTekst );
$smarty->assign( 'aantal_beschikbaar', $sessieVariabelen["aantal_beschikbaar"] );
$smarty->assign( 'aantal_deelnemers', $aantal_deelnemers );
$smarty->assign( 'aantal_deelnemersErr', $aantal_deelnemersErr );
$smarty->assign( 'prijs_per_persoon', $sessieVariabelen["prijs"] );
$smarty->assign( 'wijzigingDefinitieveInschrijving', $wijzigingDefinitieveInschrijving );

$smarty->assign( 'dynamichtml', $dynamicHtml );
$smarty->assign( 'readonly_email', $readonlyEmail );

$smarty->assign( 'deelnemerId', $deelnemerId );
$smarty->assign( 'persoonId', $persoonId );
$smarty->assign( 'inschrijvingnummer', $inschrijvingnummer );
$smarty->assign( 'all', '0' );
$smarty->assign( 'validatiemelding', $validatiemelding );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'noLogout', 'true' );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'inschrijving_deelnemer.tpl' );
