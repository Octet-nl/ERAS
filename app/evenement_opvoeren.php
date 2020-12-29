<?php
/**
 * System      ERAS
 * Module      Evenement
 * Doel        Evenementgegevens registreren of wijzigen
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

//require_once '../vendor/autoload.php';
require_once 'constanten.php';
require_once 'utilities.php';

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/
use Propel\Runtime\Propel;

// http://propelorm.org/documentation/
use Respect\Validation\Validator as v;
use \fb_model\fb_model\BetaalwijzeQuery;
use \fb_model\fb_model\CategorieQuery;
use \fb_model\fb_model\Evenement;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\KeuzesQuery;

$doctitle = "Evenementgegevens";

$sessie = new Sessie();
$history = new History();

$logger = new Logger();
$logger->level( LOGLEVEL );

// Defineer variabelen voor evenement
$evenement_naam = $korteOmschrijving = $langeOmschrijving = $prijs = $betaalwijze = "";
$datumBegin = $datumEind = $inschrijfDatumBegin = $inschrijfDatumEind = "00-00-0000";
$inschrijfTijdBegin = $inschrijfTijdEind = "00:00:00";
$inschrijfDatumBeginErr = $inschrijfDatumEindErr = $inschrijfTijdBeginErr = $inschrijfTijdEindErr = $categorieErr = "";
$maxDeelnemers = $categorie = $betaalwijze_deelnemer = "";
$naamErr = $korteOmschrijvingErr = $langeOmschrijvingErr = $datumBeginErr = $datumEindErr = $prijsErr = "";
$maxDeelnemersErr = $statusErr = $aantalDagen = $aantalDagenErr = "";
$isAnnuleringsverzekeringErr = $betaalwijze_deelnemerErr = $isAccountNodigErr = $groepsInschrijvingErr = "";
$status = $extraContact = $extraDeelnemer = 0;
$isAccountNodig = null;
$isAnnuleringsverzekering = null;
$groepsInschrijving = OPTIE_KEUZE_NEE;
$volledigheid_contact = array();
$volledigheid_deelnemer = array(); 
$betaalwijze_deelnemer = array();
$id = null;
$statusRegel = "";
$loggedin = "";
$signalError = false;

$isWijziging = false;

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );
$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;

$ini = parse_ini_file( CONFIG_FILENAME, true );

$heeftAV = false;
if ( $ini['verzekering']['toestaan'] == OPTIE_KEUZE_JA )
{
    $heeftAV = true;
}

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?evt= parameter,
// Voorbeeld: http://www.mijnsite.com/evenement?evt=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van evenement 234.
// Wordt de ?evt= parameter niet opgegeven dan gaat het om een nieuw evenement en wordt
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $history->set();
    
    if ( isset( $_GET['evt'] ) )
    {
        $id = $_GET['evt'];

        $evenement = EvenementQuery::create()->findPK( $id );
        if ( $evenement != null )
        {
            $evenement_naam = $evenement->getNaam();
            $categorie = $evenement->getCategorie();
            $korteOmschrijving = $evenement->getKorteOmschrijving();
            $langeOmschrijving = $evenement->getLangeOmschrijving();
            $datumBegin = $evenement->getDatumBegin()->format( 'd-m-Y' );
            $datumEind = $evenement->getDatumEind()->format( 'd-m-Y' );
            $inschrijfDatumBegin = $evenement->getInschrijvingBegin()->format( 'd-m-Y' );
            $inschrijfTijdBegin = $evenement->getInschrijvingBegin()->format( 'H:i:s' );
            $inschrijfDatumEind = $evenement->getInschrijvingEind()->format( 'd-m-Y' );
            $inschrijfTijdEind = $evenement->getInschrijvingEind()->format( 'H:i:s' );
            $extraContact = $evenement->getExtraContactGegevens();
            $extraDeelnemer = $evenement->getExtraDeelnemerGegevens();
            $prijs = $evenement->getPrijs();
            $betaalwijze = $evenement->getBetaalwijze();
            $maxDeelnemers = $evenement->getMaxDeelnemers();
            $aantalDagen = $evenement->getAantalDagen();
            $status = $evenement->getStatus();
            $isAnnuleringsverzekering = naarJaNee( $evenement->getAnnuleringsverzekering() );
            $isAccountNodig = naarJaNee( $evenement->getAccountNodig() );
            $volledigheid_deelnemer = getDecimal( $extraDeelnemer );
            $logger->dump( $volledigheid_deelnemer );
            $volledigheid_contact = getDecimal( $extraContact );
            $logger->dump( $volledigheid_contact );
            $betaalwijze_deelnemer = getDecimal( $betaalwijze );
            $logger->dump( $betaalwijze_deelnemer );
            $isWijziging = true;
        }
        else
        {
            $logger->info( "evenement " . $id . " is niet gevonden." );
            $statusRegel = "evenement " . $id . " is niet gevonden.";
            $id = null;
        }
    }
    else
    {
        // Bij nieuw evenement email voor contactpersoon standaard aanzetten
        $volledigheid_contact = VOLLEDIGHEID_MAIL;
    }
}

function getDecimal( $decimal )
{
    $bin = decbin( $decimal );
    $total = strlen( $bin );

    $stock = array();

    for ( $i = 0; $i < $total; $i++ )
    {
        if ( $bin[$i] != 0 )
        {
            $bin_2 = str_pad( $bin[$i], $total - $i, 0 );
            array_push( $stock, bindec( $bin_2 ) );
        }
    }
    return $stock;
}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    $alsNieuw = false;

    $setVar = new SetVariable();
    $setVar->name( $isWijziging )->go();

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    if ( isset( $_POST['alsNieuw'] ) )
    {
        $alsNieuw = true;
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

    if ( isset( $_POST['id'] ) )
    {
        $id = $_POST['id'];
    }

    $extraContact = 0;
    if ( isset( $_POST['volledigheid_contact'] ) )
    {
        $volledigheid_contact = $_POST['volledigheid_contact'];
        foreach ( $volledigheid_contact as $extra_contact )
        {
            $logger->debug( "Extra contact " . $extra_contact );
            $extraContact += $extra_contact;
        }
        // E-mail adres is altijd nodig, anders kunnen we geen bevestiging sturen.
        $extraContact |= VOLLEDIGHEID_MAIL;
    }

    $extraDeelnemer = 0;
    if ( isset( $_POST['volledigheid_deelnemer'] ) )
    {
        $volledigheid_deelnemer = $_POST['volledigheid_deelnemer'];
        foreach ( $volledigheid_deelnemer as $extra_deelnemer )
        {
            $logger->debug( "Extra deelnemer " . $extra_deelnemer );
            $extraDeelnemer += $extra_deelnemer;
        }
    }

    $betaalwijze = 0;
    if ( isset( $_POST['betaalwijze_deelnemer'] ) )
    {
        $betaalwijze_deelnemer = $_POST['betaalwijze_deelnemer'];
        foreach ( $betaalwijze_deelnemer as $betaal_wijze )
        {
            $logger->debug( "Betaalwijze " . $betaal_wijze );
            $betaalwijze += $betaal_wijze;
        }
    }

    $logger->debug( "Extra contact " . $extraContact . ", Extra deelnemer " . $extraDeelnemer . ", Betaalwijze " . $betaalwijze );

    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $evenement_naam )
            ->onerror( $naamErr )
        //    ->validator( v::alpha( "-/ 0123456789" )->length( 1, 255 ) )
            ->validator( v::alwaysValid()->length( 1, 255 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $categorie )
            ->onerror( $categorieErr )
            ->validator( v::intVal()->min( 1 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $korteOmschrijving )
            ->onerror( $korteOmschrijvingErr )
            ->noHtmlCleaning()
            ->validator( v::alwaysValid()->length( 1, 512 ) )
            ->errormessage( "De korte omschrijving is te lang" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $langeOmschrijving )
            ->onerror( $langeOmschrijvingErr )
            ->noHtmlCleaning()
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $datumBegin )
            ->onerror( $datumBeginErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Datum: dd-mm-yyyy" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $datumEind )
            ->onerror( $datumEindErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Datum: dd-mm-yyyy" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $inschrijfDatumBegin )
            ->onerror( $inschrijfDatumBeginErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Datum: dd-mm-yyyy" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $inschrijfDatumEind )
            ->onerror( $inschrijfDatumEindErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Datum: dd-mm-yyyy" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $inschrijfTijdBegin )
            ->onerror( $inschrijfTijdBeginErr )
            ->validator( v::time( 'H:i:s' ) )
            ->errormessage( "Tijd: hh:mm:ss" )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $inschrijfTijdEind )
            ->onerror( $inschrijfTijdEindErr )
            ->validator( v::time( 'H:i:s' ) )
            ->errormessage( "Tijd: hh:mm:ss" )
            ->required( false )
            ->go();
        $validateOk += $setVar->name( $prijs )
            ->onerror( $prijsErr )
            ->formatter( 'prijs' )
            ->validator( v::regex( "/^[0-9]+(\.[0-9]{1,2})?$/" ) )
            ->errormessage( "Bedrag in euros.centen" )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $maxDeelnemers )
            ->onerror( $maxDeelnemersErr )
            ->errormessage( "Aantal deelnemers moet tussen 1 en 5000 liggen" )
            ->validator( v::intVal()->between( 1, 5000 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $aantalDagen )
            ->onerror( $aantalDagenErr )
            ->validator( v::intVal()->between( 1, 365 ) )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $status )
            ->onerror( $statusErr )
            ->validator( v::intVal()->min( 1 ) )
            ->required( true )
            ->go();
        if ( $heeftAV )
        {
            $validateOk += $setVar->name( $isAnnuleringsverzekering )
            ->onerror( $isAnnuleringsverzekeringErr )
            ->required( true )
            ->go();
        }
        else
        {
            $isAnnuleringsverzekering = OPTIE_KEUZE_NEE;
        }
        $validateOk += $setVar->name( $isAccountNodig )
            ->onerror( $isAccountNodigErr )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $groepsInschrijving )
            ->onerror( $groepsInschrijvingErr )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $betaalwijze_deelnemer )
            ->onerror( $betaalwijze_deelnemerErr )
            ->required( true )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( datumVerschil( $datumBegin, $datumEind ) < 0 )
    {
        $validateOk += 9;
        $datumEindErr = "Begindatum ligt na einddatum";
    }

    if ( datumVerschil( $inschrijfDatumBegin, $inschrijfDatumEind ) < 0 )
    {
        $validateOk += 9;
        $inschrijfDatumEindErr = "Begindatum ligt na einddatum";
    }

    if ( $betaalwijze == BETAALWIJZE_VOUCHER )
    {
        $validateOk += 9;
        $betaalwijze_deelnemerErr = "Alleen betaling per voucher is niet mogelijk. Kies ook andere betaalwijze.";
    }

    $logger->debug( "validateOK = " . $validateOk );

    if ( $validateOk == 0 )
    {
        $con->beginTransaction();
        try
        {
            if ( $id == null || $alsNieuw == true )
            {
                $logger->debug( "Nieuw evenement" );
                $evenement = new Evenement();
                $evenement->setGemaaktDoor( $autorisatie->getUserId() );
                $evenement->setGewijzigdDoor( $autorisatie->getUserId() );
            }
            else
            {
                $logger->debug( "Bestaand evenement id=" . $id );
                $evenement = EvenementQuery::create()->findPK( $id );
                $evenement->setGewijzigdDoor( $autorisatie->getUserId() );
            }
            $evenement->setNaam( $evenement_naam );
            $evenement->setCategorie( $categorie );
            $evenement->setKorteOmschrijving( $korteOmschrijving );
            $evenement->setLangeOmschrijving( $langeOmschrijving );
            $evenement->setDatumBegin( $datumBegin );
            $evenement->setDatumEind( $datumEind );
            $evenement->setAantalDagen( $aantalDagen );
            $evenement->setInschrijvingBegin( $inschrijfDatumBegin . " " . $inschrijfTijdBegin );
            $evenement->setInschrijvingEind( $inschrijfDatumEind . " " . $inschrijfTijdEind );
            $evenement->setExtraContactGegevens( $extraContact );
            $evenement->setExtraDeelnemerGegevens( $extraDeelnemer );
            $evenement->setBetaalwijze( $betaalwijze );
            $evenement->setPrijs( $prijs );
            $evenement->setMaxDeelnemers( $maxDeelnemers );
            $evenement->setStatus( $status );
            $evenement->setAnnuleringsverzekering( vanJaNee( $isAnnuleringsverzekering ) );
            $evenement->setAccountNodig( vanJaNee( $isAccountNodig ) );
            $evenement->setGroepsInschrijving( vanJaNee( $groepsInschrijving ) );
            $evenement->save();
            $con->commit();

            $logger->info( "Gegevens van evenenement " . $evenement->getId() . " zijn opgeslagen" );
            $statusRegel = "Gegevens van evenenement " . $evenement->getId() . " zijn opgeslagen";

            if ( isset( $_POST["opslaanOpties"] ) )
            {
                $logger->debug( "Nu opties toevoegen aan dit evenement" );
                header( "Location:optie_opvoeren.php?evt=" . $evenement->getId() );
                exit;
            }

            if ( $id != 0 )
            {
                $id = 0;
                $terug =  $history->get( );
                $logger->debug( "History get: " . $terug );
                header( "Location:" . $terug );
                exit;
                    }

            $status = 0;
            //header( "Refresh:0" );
        }
        catch ( \Exception $e )
        {
            $con->rollback();
            $logger->dump( $e );
            $logger->error( $e->getMessage() );
            $signalError = true;
            $statusRegel = 'Probleem met opslaan gegevens, zie log voor details.';
        }
    }
    else
    {
        $logger->error( "Validatie niet correct. Verwerking stopt." );
        $signalError = true;
        $statusRegel = 'Vul a.u.b. de aangegeven velden correct in';
    }

}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

try
{
    $sessieVariabelen = array();
    if ( $sessieVariabelen == null )
    {
        $statussen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_EVENEMENT )->filterByIsActief( "1" )->find();
        foreach ( $statussen as $dbstatus )
        {
            $sessieVariabelen[$dbstatus->getCode()] = $dbstatus->getNaam();
        }
        $logger->debug( "Sessievariabelen geladen" );
    }

    $categorieArray = array();
    if ( $categorieArray == null )
    {
        $categorien = CategorieQuery::create()->filterByIsActief( "1" )->find();
        foreach ( $categorien as $dbcategorie )
        {
            $categorieArray[$dbcategorie->getCode()] = $dbcategorie->getNaam();
        }
        $logger->debug( "Categorie array geladen" );
    }

    $volledigheidArray = array();
    if ( $volledigheidArray == null )
    {
        $volledigen = KeuzesQuery::create()->filterByKeuzeType( KEUZETYPE_EXTRA_PERSOONSGEGEVENS )->filterByIsActief( "1" )->find();
        foreach ( $volledigen as $dbvolledigheid )
        {
            $volledigheidArray[$dbvolledigheid->getCode()] = $dbvolledigheid->getNaam();
        }
        $logger->debug( "Volledigheid array geladen" );
    }
    
    $betaalwijzeArray = array();
    if ( $betaalwijzeArray == null )
    {
        $betalingen = null;
        $betalingen = BetaalwijzeQuery::create()->filterByIsActief( "1" )->find();

        $skipIdeal = false;
        if ( $ini['ideal_payment']['toestaan'] != OPTIE_KEUZE_JA )
        {
            $skipIdeal = true;
        }

        foreach ( $betalingen as $dbbetaling )
        {
            if ( $skipIdeal && $dbbetaling->getCode() == BETAALWIJZE_IDEAL )
            {
                continue;
            }
            $betaalwijzeArray[$dbbetaling->getCode()] = $dbbetaling->getNaam();
        }
        $logger->debug( "Betaalwijze array geladen" );
    }
}
catch ( Exception $e )
{
    $logger->dump( $e );
    $logger->error( $e->getMessage() );
    $signalError = true;
    $statusRegel = 'Probleem met opslaan gegevens, zie log voor details.';
}

$logger->debug( "Smarty schermopbouw" );

$imageDirectory = $ini['settings']['image_directory'] . '/';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'id', $id );
$smarty->assign( 'imageDirectory', $imageDirectory );
$smarty->assign( 'evenement_naam', $evenement_naam );
$smarty->assign( 'naamErr', $naamErr );
$smarty->assign( 'korteOmschrijving', $korteOmschrijving );
$smarty->assign( 'korteOmschrijvingErr', $korteOmschrijvingErr );
$smarty->assign( 'langeOmschrijving', $langeOmschrijving );
$smarty->assign( 'langeOmschrijvingErr', $langeOmschrijvingErr );
$smarty->assign( 'datumBegin', $datumBegin );
$smarty->assign( 'datumBeginErr', $datumBeginErr );
$smarty->assign( 'datumEind', $datumEind );
$smarty->assign( 'datumEindErr', $datumEindErr );
$smarty->assign( 'inschrijfDatumBegin', $inschrijfDatumBegin );
$smarty->assign( 'inschrijfDatumBeginErr', $inschrijfDatumBeginErr );
$smarty->assign( 'inschrijfDatumEind', $inschrijfDatumEind );
$smarty->assign( 'inschrijfDatumEindErr', $inschrijfDatumEindErr );
$smarty->assign( 'inschrijfTijdBegin', $inschrijfTijdBegin );
$smarty->assign( 'inschrijfTijdBeginErr', $inschrijfTijdBeginErr );
$smarty->assign( 'inschrijfTijdEind', $inschrijfTijdEind );
$smarty->assign( 'inschrijfTijdEindErr', $inschrijfTijdEindErr );
$smarty->assign( 'prijs', $prijs );
$smarty->assign( 'prijsErr', $prijsErr );
$smarty->assign( 'maxDeelnemers', $maxDeelnemers );
$smarty->assign( 'maxDeelnemersErr', $maxDeelnemersErr );
$smarty->assign( 'aantalDagen', $aantalDagen );
$smarty->assign( 'aantalDagenErr', $aantalDagenErr );
$smarty->assign( 'isWijziging', $isWijziging );

$smarty->assign( 'heeftAV', $heeftAV );
$smarty->assign( 'annuleringsverzekeringKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isAnnuleringsverzekering', $isAnnuleringsverzekering );
$smarty->assign( 'isAnnuleringsverzekeringErr', $isAnnuleringsverzekeringErr );

$smarty->assign( 'accountNodigKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'isAccountNodig', $isAccountNodig );
$smarty->assign( 'isAccountNodigErr', $isAccountNodigErr );

$smarty->assign( 'groepsInschrijvingKeus', array(
    OPTIE_KEUZE_JA => OPTIE_KEUZE_JA,
    OPTIE_KEUZE_NEE => OPTIE_KEUZE_NEE ) );
$smarty->assign( 'groepsInschrijving', $groepsInschrijving );
$smarty->assign( 'groepsInschrijvingErr', $groepsInschrijvingErr );

$smarty->assign( 'categorielijst', $categorieArray );
$smarty->assign( 'categorie', $categorie );
$smarty->assign( 'categorieErr', $categorieErr );
$smarty->assign( 'statuslijst', $sessieVariabelen );
$smarty->assign( 'status', $status );
$smarty->assign( 'volledigheidlijst', $volledigheidArray );
$smarty->assign( 'volledigheid_contact', $volledigheid_contact );
$smarty->assign( 'volledigheid_deelnemer', $volledigheid_deelnemer );
$smarty->assign( 'betaalwijzelijst', $betaalwijzeArray );
$smarty->assign( 'betaalwijze_deelnemer', $betaalwijze_deelnemer );
$smarty->assign( 'betaalwijze_deelnemerErr', $betaalwijze_deelnemerErr );

$toonWysiwig = false;
if ( EVENEMENT_EDIT_WYSIWIG == true && LOGLEVEL > LOGLEVEL_DEBUG )
{
    $toonWysiwig = true;
}
$toonKalenders = false;
if ( EVENEMENT_DATUM_KALENDERS == true && LOGLEVEL > LOGLEVEL_DEBUG )
{
    $toonKalenders = true;
}

$smarty->assign( 'toonWysiwig', $toonWysiwig );
$smarty->assign( 'toonKalenders', $toonKalenders );

$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusErr', $statusErr );
$smarty->assign( 'validatiemelding', $statusRegel );

$smarty->display( 'evenement_opvoeren.tpl' );
