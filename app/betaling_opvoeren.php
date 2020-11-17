<?php
/**
 * System      Inschrijvingen
 * Module      Secretariaat betalingen
 * Doel        Verwerken van betalingen door het secretariaat
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       17-12-2019
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

$doctitle = "Evenementen";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/

use fb_model\fb_model\EvenementQuery;
use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\PersoonQuery;
use Respect\Validation\Validator as v;
use \fb_model\fb_model\Contactlog;

use \Propel\Runtime\Propel;

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );


// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenementen_lijst = array();

$doctitle = "Verwerken betaling";

$teBetalen = 0;
$reedsBetaald = 0;
$korting = 0;
$teBetalen = 0;
$nuBetaald = 0;
$evenementNaam = "";
$contactNaam = "";
$inschrijfnummer = 0;
$contactPersoonId = 0;
$omschrijving = "";

$statusRegel = "";
$signalError = false;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );
    $history->set();

    if ( isset( $_GET['iid'] ) )
    {
        $iid = $_GET['iid'];

        $inschrijving = InschrijvingQuery::create()->findPk( $iid );
        if ( $inschrijving == null )
        {
            $signalError = true;
            $statusRegel = "Inschrijving niet gevonden";
        }
        else
        {
            $contactPersoonId = $inschrijving->getContactPersoonId();

            $persoon = PersoonQuery::create()->findPk( $contactPersoonId );
            if ( $persoon == null )
            {
                $logger->error( "Persoon niet gevonden. Id=" . $inschrijving->getContactPersoonId() );
            }
            $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
            if ( $evenement == null )
            {
                $logger->error( "Evenement niet gevonden. Id=" . $inschrijving->getEvenementId() );
            }
            $evenementNaam = $evenement->getNaam();
            $contactNaam = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
            $inschrijfnummer = $iid;
            $korting = $inschrijving->getKorting();
            $reedsBetaald = $inschrijving->getReedsBetaald();
            $teBetalen = $inschrijving->getTotaalbedrag();
        }
    }
    else
    {
        // Betalingen alleen via de inschrijvinglijst
        header( "Location:inschrijving_lijst.php" );
    }
}

// Deel 2
// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

    //ToDo: Err variabelen toevoegen. Nu geen terugmelding als er iets fout gaat.
    try
    {
        $validateOk = 0;
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $reedsBetaald )
            ->formatter( 'prijs' )
            ->validator( v::numericVal() )
            ->go();
        $validateOk += $setVar->name( $korting )
            ->formatter( 'prijs' )
            ->validator( v::numericVal() )
            ->go();
        $validateOk += $setVar->name( $teBetalen )
            ->formatter( 'prijs' )
            ->validator( v::numericVal() )
            ->go();
        $validateOk += $setVar->name( $nuBetaald )
            ->formatter( 'prijs' )
            ->validator( v::numericVal() )
            ->go();
        $validateOk += $setVar->name( $inschrijfnummer )->go();
        $validateOk += $setVar->name( $omschrijving )->go();
        $validateOk += $setVar->name( $contactPersoonId )->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['opslaan'] ) )
    {
        if ( $validateOk == 0 )
        {
            $con->beginTransaction();
            try
            {
                $inschrijving = InschrijvingQuery::create()->findPk( $inschrijfnummer );
                $totaalBedrag = $inschrijving->getTotaalbedrag();
                $teBetalen = $totaalBedrag;
                $inschrijving->setKorting( $korting );
                $teBetalen -= $korting;
                $inschrijving->setReedsBetaald( $reedsBetaald + $nuBetaald );
                $teBetalen -= $reedsBetaald;
                $teBetalen -= $nuBetaald;
                $teBetalen = rondNul( $teBetalen );
                $inschrijving->setNogTeBetalen( $teBetalen );
                $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );
                $inschrijving->save();

                $contactlog = new Contactlog;
                $contactlog->setPersoonId( $contactPersoonId );
                $contactlog->setTekst( "Betaling inschrijving met id " . $inschrijving->getId() .
                    ", Totaalbedrag " . geld($totaalBedrag) .
                    ", Had reeds betaald " . geld($reedsBetaald) .
                    ", Nu betaald " . geld($nuBetaald) .
                    ", nog te betalen " . geld($teBetalen) .
                    '\nomschrijving: ' . $omschrijving );
                $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
                $contactlog->save();

                $con->commit();
            }
            catch ( \Exception $e )
            {
                $con->rollback();
                //var_dump( $e );
                $logger->error( 'Probleem met opslaan gegevens, details: ' . PHP_EOL . $e );
                alert( 'Probleem met opslaan gegevens, details: <br/>' . $e );
                exit;
            }
        }
        else
        {
            $logger->error( 'Validatie niet ok.' );
        }
    }

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

}

// Deel 3

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenementNaam', $evenementNaam );
$smarty->assign( 'contactNaam', $contactNaam );
$smarty->assign( 'contactPersoonId', $contactPersoonId );
$smarty->assign( 'inschrijfnummer', $inschrijfnummer );

$smarty->assign( 'totaalBedrag', $teBetalen );
$smarty->assign( 'reedsBetaald', $reedsBetaald );
$smarty->assign( 'korting', $korting );
$smarty->assign( 'nuBetaald', $nuBetaald );
$smarty->assign( 'teBetalen', $teBetalen );
$smarty->assign( 'omschrijving', $omschrijving );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'betaling_opvoeren.tpl' );
