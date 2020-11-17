<?php
/**
 * System      Inschrijvingen
 * Module      Optie
 * Doel        Optiegegevens registreren of wijzigen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       11-08-2019
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

// https://respect-validation.readthedocs.io/en/1.1/
use Propel\Runtime\Propel;
use Respect\Validation\Validator as v;
use \fb_model\fb_model\EvenementHeeftOptie;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\KeuzesQuery;
use \fb_model\fb_model\Optie;
use \fb_model\fb_model\OptieQuery;
use \fb_model\fb_model\TypeQuery;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$doctitle = "Optiegegevens";

$sessie = new Sessie();

require_once 'optie_define_variables.inc';

$validatiemelding = "";
$volgorde = 1;
$statusRegel = "";
$signalError = false;

$evenement_lijst = array();

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;
$id = 0;
$wijzigen = false;

$logger = new Logger();
$logger->level( LOGLEVEL );

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?id= parameter,
// Voorbeeld: http://www.mijnsite.com/evenement?id=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van optie 234.
// Wordt de evt parameter opgegeven wordt de optie gekoppeld aan dit evenement.

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $history->set();

    if ( isset( $_GET['id'] ) )
    {
        $id = $_GET['id'];

        $optie = OptieQuery::create()->findPK( $id );
        if ( $optie != null )
        {
            $optieNaam = $optie->getNaam();
            $perDeelnemer = naarJaNee( $optie->getPerDeelnemer() );
            $tekstVoor = $optie->getTekstVoor();
            $tekstAchter = $optie->getTekstAchter();
            $tooltipTekst = $optie->getTooltipTekst();
            $heeftHorLijn = $optie->getHeeftHorizontaleLijn();
            $groep = $optie->getGroep();
            $type = $optie->getOptieType();
            $label = $optie->getLabel();
            $status = $optie->getStatus();
            $totaalAantal = $optie->getTotaalAantal();
            $isDefault = naarJaNee( $optie->getIsDefault() );
            $isInternGebruik = naarJaNee( $optie->getInternGebruik() );
            $isKlantWijzigen = naarJaNee( $optie->getLaterWijzigen() );
            $prijs = $optie->getPrijs();
        }
        else
        {
            $validatiemelding = "Optie " . $id . " is niet gevonden.";
            $id = 0;
        }
    }

    // Evenement opgegeven, koppel alle opties aan dit evenement.
    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];
        $evenement = EvenementQuery::create()->findPK( $evt );
        if ( $evenement != null )
        {
            $evenementNaam = $evenement->getNaam();
        }
    }
    else
    {
        // Vullen evenementenlijst
        $evenementen = EvenementQuery::create()
            ->filterByStatus( array(EVENEMENT_STATUS_OPEN, EVENEMENT_STATUS_WACHT) )
            ->find();

        $evenement_lijst["0"] = "";
        foreach ( $evenementen as $evenement )
        {
            $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
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

    if ( isset( $_POST['id'] ) )
    {
        $id = $_POST['id'];
    }

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    if ( isset( $_POST['leegmaken'] ) )
    {
        $logger->debug( "Leegmaken, refresh." );
        header( "refresh:0" );
        exit( 0 );
    }

    if ( isset( $_POST['evenementId'] ) )
    {
        $evenementId = $_POST['evenementId'];
        if ( $evenementId != 0 )
        {
            $logger->debug( 'Voor evenement ' . $evenementId );
            header( "Location:optie_opvoeren.php?evt=" . $evenementId );
            exit();
        }
        $logger->debug( 'Evenement is 0' );
    }

    // Als evenement wordt opgegeven, nieuw gemaakte opties koppelen aan dit evenement.
    if ( isset( $_POST['evt'] ) )
    {
        $evt = $_POST['evt'];
        if ( $evt != 0 )
        {
            $evenement = EvenementQuery::create()->findPK( $evt );
            if ( $evenement != null )
            {
                $evenementNaam = $evenement->getNaam();
            }
        }
    }

    if ( isset( $_POST['opslaan'] ) || isset( $_POST['opslaanNieuw'] ) )
    {
        try
        {
            $setVar = new SetVariable();

            $validateOk += $setVar->name( $evt )
                ->validator( v::alwaysValid() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $optieNaam )
                ->onerror( $optieNaamErr )
                ->formatter( 'stripTekens' )
                ->validator( v::alwaysValid()->length( 1, 64 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $type )
                ->onerror( $typeErr )
                ->validator( v::intVal()->between( 1, 100 ) )
                ->required( true )
                ->go();

            $requiredMeerdere = false;
            if ( $type == OPTIETYPE_KEUZE_RADIO || $type == OPTIETYPE_KEUZE_MEERDERE )
            {
                $requiredMeerdere = true;
            }

            $validateOk += $setVar->name( $tekstVoor )
                ->onerror( $tekstVoorErr )
                ->validator( v::alnum( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-?!/ ()' )->length( 1, 255 ) )
                ->errormessage( "Alleen lettertekens, vraagteken, spatie, dash, slash, ronde haken en punt zijn toegestaan" )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $tekstAchter )
                ->onerror( $tekstAchterErr )
                ->validator( v::alwaysValid() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $tooltipTekst )
                ->onerror( $tooltipTekstErr )
                ->validator( v::alwaysValid() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $heeftHorLijn )
                ->onerror( $horizontaleLijnErr )
                ->validator( v::alwaysValid() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $perDeelnemer )
                ->onerror( $perDeelnemerErr )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $groep )
                ->onerror( $groepErr )
                ->validator( v::alpha( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-?/ ()' )->length( 1, 45 ) )
                ->errormessage( "Alleen lettertekens, vraagteken, spatie, dash, slash, ronde haken en punt zijn toegestaan" )
                ->required( $requiredMeerdere )
                ->go();
            $validateOk += $setVar->name( $isDefault )
                ->onerror( $isDefaultErr )
                ->required( $requiredMeerdere )
                ->go();
            $validateOk += $setVar->name( $totaalAantal )
                ->onerror( $totaalAantalErr )
                ->errormessage( "Totaal aantal moet tussen 1 en 5000 liggen" )
                ->validator( v::intVal()->between( 0, 5000 ) )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $prijs )
                ->onerror( $prijsErr )
                ->formatter( 'prijs' )
                ->defaultvalue( '0,00' )
                ->validator( v::regex( "/^\-?[0-9]+(\.[0-9]{1,2})?$/" ) )
                ->errormessage( "Bedrag in euros.centen" )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $status )
                ->onerror( $statusErr )
                ->validator( v::intVal()->between( 1, 100 ) )
                ->required( true )
                ->go();
            $validateOk += $setVar->name( $selectLabel )
                ->onerror( $selectLabelErr )
                ->validator( v::alwaysValid() )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $label )
                ->onerror( $labelErr )
                ->validator( v::alpha( '_0123456789' )->length( 1, 32 ) )
                ->errormessage( "Alleen lettertekens, cijfers en underscore zijn toegestaan" )
                ->required( $type == OPTIETYPE_VOORWAARDE )
                ->go();
            $validateOk += $setVar->name( $isInternGebruik )
                ->onerror( $isInternGebruikErr )
                ->required( false )
                ->go();
            $validateOk += $setVar->name( $isKlantWijzigen )
                ->onerror( $isKlantWijzigenErr )
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
            $con->beginTransaction();
            try
            {
                if ( $id == 0 || isset( $_POST['opslaanNieuw'] ) )
                {
                    $logger->debug( "Toevoegen nieuwe optie" );
                    $optie = new Optie();
                    $optie->setGemaaktDoor( $autorisatie->getUserId() );
                    $optie->setGewijzigdDoor( $autorisatie->getUserId() );
                }
                else
                {
                    $logger->debug( "Wijzigen bestaande optie id=" . $id );
                    $optie = OptieQuery::create()->findPK( $id );
                    $optie->setGewijzigdDoor( $autorisatie->getUserId() );
                }

                $optie->setNaam( $optieNaam );
                $optie->setPerDeelnemer( vanJaNee( $perDeelnemer ) );
                $optie->setTekstVoor( $tekstVoor );
                $optie->setTekstAchter( $tekstAchter );
                $optie->setTooltipTekst( $tooltipTekst );
                $optie->setHeeftHorizontaleLijn( $heeftHorLijn );
                $optie->setGroep( $groep );
                $optie->setOptieType( $type );
                $optie->setTotaalAantal( $totaalAantal );
                $optie->setIsDefault( vanJaNee( $isDefault ) );
                $optie->setPrijs( $prijs );
                $logger->debug( "prijs: " . $prijs );
                $optie->setStatus( $status );
                if ( $type == OPTIETYPE_VOORWAARDE )
                {
                    $optie->setLabel( $label );
                }
                else
                {
                    $optie->setLabel( $selectLabel );
                }
                $optie->setInternGebruik( vanJaNee( $isInternGebruik ) );
                $optie->setLaterWijzigen( vanJaNee( $isKlantWijzigen ) );
                $optie->save( $con );

                if ( $evt > 0 )
                {
                    $volgorde = $_POST["volgorde"];

                    // Koppelen aan het evenement
                    $logger->debug( "EvenementID " . $evt . ", OptieID " . $optie->getId() . ", Volgorde " . $volgorde );
                    $evtOptie = new EvenementHeeftOptie();
                    $evtOptie->setEvenementId( $evt );
                    $evtOptie->setOptieId( $optie->getId() );
                    $evtOptie->setVolgorde( $volgorde );
                    $evtOptie->setGemaaktDoor( $autorisatie->getUserId() );
                    $evtOptie->setGewijzigdDoor( $autorisatie->getUserId() );
                    $evtOptie->save();
                    $volgorde += 1;
                }

                $con->commit();

                $statusRegel = "Optie toegevoegd als nummer " . $optie->getId();

                //$status = 0;
                $isDefault = OPTIE_KEUZE_NEE;
                //$isInternGebruik = OPTIE_KEUZE_NEE;
                if ( $id != 0 )
                {
                    $id = 0;
                    $terug =  $history->get( );
                    $logger->debug( "Gestart met ID, ga terug naar vorige: " . $terug );
                    header( "Location:" . $terug );
                    exit;
                            }
                else
                {
                }

            }
            catch ( \Exception $e )
            {
                $con->rollback();
                $statusRegel = "Probleem met opslaan gegevens. Optie is niet opgeslagen";
                $signalError = true;
                $logger->error( $e->getMessage() );
                $logger->error( 'Probleem met opslaan gegevens contactpersoon, foutcode ' . $e->getPrevious()->errorInfo[1] );
                $logger->error( $e->getPrevious()->errorInfo[2] );
                $validatiemelding = 'Probleem met opslaan gegevens, details: <br/>' . $e;
            }
        }
        else
        {
            $logger->error( "Validatie niet correct. Verwerking stopt." );
            $statusRegel = "Probleem met opslaan gegevens. Optie is niet opgeslagen";
            $signalError = true;
        }
    }
    else
    {
        $logger->error( "Geen keuze gemaakt. Verwerking stopt." );
        $statusRegel = "Geen keuze gemaakt. Optie is niet opgeslagen";
        $signalError = true;
    }
    //header("refresh:0");
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen optie.
// Dit deel vult de waarden in voor de HTML template en start deze op.

// Alleen bij wijzigen bestaande optie komt er een opslaan als nieuw knop.
if ( $id == 0 )
{
    $alsnieuwbutton = '';
}
else
{
    $alsnieuwbutton = '<button name="opslaanNieuw">Opslaan als nieuwe optie</button>';
}

$typenLijst = array();
if ( $typenLijst == null )
{
    $alleTypes = TypeQuery::create()
        ->filterByIsActief( "1" )
        ->find();
    foreach ( $alleTypes as $ditType )
    {
        $typenLijst[$ditType->getCode()] = $ditType->getNaam();
    }
}

$horizontaleLijnLijst = array();
if ( $horizontaleLijnLijst == null )
{
    $statussen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_HORIZONTALE_LIJN )->filterByIsActief( "1" )->find();
    foreach ( $statussen as $dbstatus )
    {
        $horizontaleLijnLijst[$dbstatus->getCode()] = $dbstatus->getNaam();
    }
}

$labelLijst = array();
if ( $labelLijst == null )
{
    $labelLijst[""] = "";
    $labels = OptieQuery::create()->
              filterByOptieType( OPTIETYPE_VOORWAARDE )->
              filterByStatus( OPTIE_STATUS_ACTIEF )->
              find();
    foreach ( $labels as $mylabel )
    {
        $labelLijst[$mylabel->getLabel()] = $mylabel->getLabel();
    }
}

$statusLijst = array();
if ( $statusLijst == null )
{
    $statussen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_OPTIE )->filterByIsActief( "1" )->find();
    foreach ( $statussen as $dbstatus )
    {
        $statusLijst[$dbstatus->getCode()] = $dbstatus->getNaam();
    }
}

$logger->debug( "Vullen smarty gegevens" );
$evenement = "";
if ( $evt > 0 )
{
    $evenement = "Automatisch toevoegen aan " . $evenementNaam;
}
$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenement', $evenement );
$smarty->assign( 'volgorde', $volgorde );
$smarty->assign( 'alsnieuwbutton', $alsnieuwbutton );
$smarty->assign( 'id', $id );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'evenementId', $evt );

$smarty->assign( 'evenement_lijst', $evenement_lijst );

$smarty->assign( 'perDeelnemerKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'perDeelnemer', $perDeelnemer );
$smarty->assign( 'perDeelnemerErr', $perDeelnemerErr );

$smarty->assign( 'optieNaam', $optieNaam );
$smarty->assign( 'optieNaamErr', $optieNaamErr );
$smarty->assign( 'tekstVoor', $tekstVoor );
$smarty->assign( 'tekstVoorErr', $tekstVoorErr );
$smarty->assign( 'tekstAchter', $tekstAchter );
$smarty->assign( 'tekstAchterErr', $tekstAchterErr );
$smarty->assign( 'tooltipTekst', $tooltipTekst );
$smarty->assign( 'tooltipTekstErr', $tooltipTekstErr );
$smarty->assign( 'heeft_hor_lijn', $heeftHorLijn );
$smarty->assign( 'horizontaleLijn', $horizontaleLijnLijst );
$smarty->assign( 'horizontaleLijnErr', $horizontaleLijnErr );
$smarty->assign( 'groep', $groep );
$smarty->assign( 'groepErr', $groepErr );
$smarty->assign( 'type', $type );
$smarty->assign( 'typeErr', $typeErr );
$smarty->assign( 'typenLijst', $typenLijst );
$smarty->assign( 'status', $status );
$smarty->assign( 'statusErr', $statusErr );
$smarty->assign( 'statusLijst', $statusLijst );
$smarty->assign( 'labelLijst', $labelLijst );
$smarty->assign( 'selectLabel', $selectLabel );
$smarty->assign( 'label', $label );
$smarty->assign( 'labelErr', $labelErr );
$smarty->assign( 'totaalAantal', $totaalAantal );
$smarty->assign( 'totaalAantalErr', $totaalAantalErr );

$smarty->assign( 'defaultKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isDefault', $isDefault );
$smarty->assign( 'isDefaultErr', $isDefaultErr );

$smarty->assign( 'internGebruikKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isInternGebruik', $isInternGebruik );
$smarty->assign( 'isInternGebruikErr', $isInternGebruikErr );

$smarty->assign( 'klantWijzigenKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isKlantWijzigen', $isKlantWijzigen );
$smarty->assign( 'isKlantWijzigenErr', $isKlantWijzigenErr );

$smarty->assign( 'prijs', $prijs );
$smarty->assign( 'prijsErr', $prijsErr );

$smarty->assign( 'validatiemelding', $validatiemelding );
$smarty->assign( 'keuzeRadio', OPTIETYPE_KEUZE_RADIO );
$smarty->assign( 'keuzeMeerdere', OPTIETYPE_KEUZE_MEERDERE );
$smarty->assign( 'keuzeJaNee', OPTIETYPE_KEUZE_JA_NEE );
$smarty->assign( 'keuzeAantal', OPTIETYPE_AANTAL );
$smarty->assign( 'keuzeGetal', OPTIETYPE_GETAL );
$smarty->assign( 'keuzeTekstvak', OPTIETYPE_TEKSTVAK );
$smarty->assign( 'keuzeTekstregel', OPTIETYPE_TEKSTREGEL );
$smarty->assign( 'keuzeKoptekst', OPTIETYPE_KOPTEKST );
$smarty->assign( 'keuzeVasteTekst', OPTIETYPE_VASTE_TEKST );
$smarty->assign( 'keuzeInstemming', OPTIETYPE_AKKOORD );
$smarty->assign( 'keuzeVoorwaarde', OPTIETYPE_VOORWAARDE );
// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'optie_opvoeren.tpl' );
