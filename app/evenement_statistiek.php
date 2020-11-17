<?php
/**
 * System      Inschrijvingen
 * Module      Evenement statistiek
 * Doel        Gedetailleerde informatie over gebruik van evenement opties
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       14-01-2020
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

use fb_model\fb_model\DeelnemerHeeftOptieQuery;
use fb_model\fb_model\DeelnemerQuery;
use fb_model\fb_model\EvenementQuery;
use fb_model\fb_model\InschrijvingHeeftOptieQuery;
use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\OptieQuery;
use fb_model\fb_model\VoucherQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Respect\Validation\Validator as v;

// Defineer variabelen voor evenement

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Evenement statistiek";

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
$betaaldPerVoucher = 0;
$nogTeBetalen = 0;
$korting = 0;

//$restwaardeVouchers = 0;

$evenementNaam = "";
$evenementId = 0;

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

    $opties = null;

    if ( isset( $_GET['evt'] ) )
    {
        $evt = $_GET['evt'];

        $evenement = EvenementQuery::create()->findPk( $evt );
        $evenementNaam = $evenement->getNaam();
        $evenementId = $evenement->getId();

        $aantal_deelnemers = DeelnemerQuery::create()
            ->useInschrijvingQuery( 'a', 'left join' )
            ->filterByEvenementId( $evt )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->enduse()
            ->count();
        $aantal_beschikbaar = $evenement->getMaxDeelnemers() - $aantal_deelnemers;

        $opties = OptieQuery::create()
            ->useEvenementHeeftOptieQuery()
              ->filterByEvenementId( $evt )
            ->endUse()
            ->orderByGroep()
            ->orderByNaam()
            ->find();

        $definitieveInschrijvingen = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->count();
        $openInschrijvingen = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->filterByStatus( INSCHRIJVING_STATUS_OPEN )
            ->count();
        $geannuleerdeInschrijvingen = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->filterByStatus( INSCHRIJVING_STATUS_GEANNULEERD )
            ->count();

        $teBetalen = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->withColumn( 'SUM( totaalbedrag )', 'TeBetalen' )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->findOne()
            ->getTeBetalen();

        $alBetaald = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->withColumn( 'SUM( reeds_betaald )', 'AlBetaald' )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->findOne()
            ->getAlBetaald();

        $betaaldPerVoucher = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->withColumn( 'SUM( betaald_per_voucher )', 'BetaaldPerVoucher' )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->findOne()
            ->getBetaaldPerVoucher();

        $nogTeBetalen = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->withColumn( 'SUM( nog_te_betalen )', 'NogBetalen' )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->findOne()
            ->getNogBetalen();

        $korting = InschrijvingQuery::create()
            ->filterByEvenementId( $evt )
            ->withColumn( 'SUM( korting )', 'MetKorting' )
            ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
            ->findOne()
            ->getMetKorting();

        $logger->debug( 'Te betalen: ' . $teBetalen . ', reeds betaald: ' . $alBetaald . ', nog te betalen: ' . $nogTeBetalen . ', per voucher:' .$betaaldPerVoucher );

    }
    else
    {
        // Terug naar de evenementlijst
        //        header( "Location:evenement_lijst.php" );
    }

    $beginwaardeVouchers = VoucherQuery::create()
        ->filterByVoucherType( VOUCHERTYPE_VOUCHER )
        ->withColumn( 'SUM( oorsprongwaarde )', 'Beginwaarde' )
        ->findOne()
        ->getBeginwaarde();

    $beginaantalVouchers = VoucherQuery::create()
        ->filterByVoucherType( VOUCHERTYPE_VOUCHER )
        ->withColumn( 'COUNT( oorsprongwaarde )', 'Beginaantal' )
        ->findOne()
        ->getBeginaantal();

    $restwaardeVouchers = VoucherQuery::create()
        ->filterByVoucherType( VOUCHERTYPE_VOUCHER )
        ->filterByIsActief( 1 )
        ->withColumn( 'SUM( restwaarde )', 'Eindwaarde' )
        ->findOne()
        ->getEindwaarde();

    $restaantalVouchers = VoucherQuery::create()
        ->filterByVoucherType( VOUCHERTYPE_VOUCHER )
        ->filterByIsActief( 1 )
        ->withColumn( 'COUNT( restwaarde )', 'Eindaantal' )
        ->findOne()
        ->getEindaantal();

    if ( $opties != null )
    {
        foreach ( $opties as $optie )
        {
            $opt_lijst = array();
            $aantalOpties = 0;

            $opt_lijst["id"] = $optie->getId();
            $opt_lijst["per_deelnemer"] = $optie->getPerDeelnemer();

            if ( $optie->getPerDeelnemer() == "1" )
            {
                if ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
                {
                    $aantalOpties = DeelnemerHeeftOptieQuery::create()
                        ->useDeelnemerQuery( 'a', 'left join' )
                        ->useInschrijvingQuery( 'b', 'left join' )
                        ->filterByEvenementId( $evt )
                        ->enduse()
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->filterByWaarde( OPTIE_KEUZE_JA )
                        ->count();
                }
                else
                {
                    if ( $optie->getOptieType() == OPTIETYPE_TEKSTREGEL || $optie->getOptieType() == OPTIETYPE_TEKSTVAK )
                    {
                        $aantalOpties = DeelnemerHeeftOptieQuery::create()
                            ->useDeelnemerQuery( 'a', 'left join' )
                            ->useInschrijvingQuery( 'b', 'left join' )
                            ->filterByEvenementId( $evt )
                            ->enduse()
                            ->enduse()
                            ->filterByOptieId( $optie->getId() )
                            ->filterByWaarde( "", Criteria::NOT_EQUAL )
                            ->count();
                    }
                    else
                    {
                        $aantalOpties = DeelnemerHeeftOptieQuery::create()
                            ->useDeelnemerQuery( 'a', 'left join' )
                            ->useInschrijvingQuery( 'b', 'left join' )
                            ->filterByEvenementId( $evt )
                            ->enduse()
                            ->enduse()
                            ->filterByOptieId( $optie->getId() )
                            ->count();
                    }
                }
            }
            else
            {
                if ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
                {
                    $aantalOpties = InschrijvingHeeftOptieQuery::create()
                        ->useInschrijvingQuery( 'b', 'left join' )
                        ->filterByEvenementId( $evt )
                        ->enduse()
                        ->filterByOptieId( $optie->getId() )
                        ->filterByWaarde( OPTIE_KEUZE_JA )
                        ->count();
                }
                else
                {
                    if ( $optie->getOptieType() == OPTIETYPE_TEKSTREGEL || $optie->getOptieType() == OPTIETYPE_TEKSTVAK )
                    {
                        $aantalOpties = InschrijvingHeeftOptieQuery::create()
                            ->useInschrijvingQuery( 'b', 'left join' )
                            ->filterByEvenementId( $evt )
                            ->enduse()
                            ->filterByOptieId( $optie->getId() )
                            ->filterByWaarde( "", Criteria::NOT_EQUAL )
                            ->count();
                    }
                    else if ( $optie->getOptieType() == OPTIETYPE_KOPTEKST || 
                              $optie->getOptieType() == OPTIETYPE_VASTE_TEKST || 
                              $optie->getOptieType() == OPTIETYPE_AKKOORD )
                    {
                        continue;
                    }
                    else
                    {
                        $aantalOpties = InschrijvingHeeftOptieQuery::create()
                            ->useInschrijvingQuery( 'b', 'left join' )
                            ->filterByEvenementId( $evt )
                            ->enduse()
                            ->filterByOptieId( $optie->getId() )
                            ->count();
                    }
                }
            }

            $opt_lijst["aantal_opties"] = $aantalOpties;

            $opt_lijst["naam"] = $optie->getNaam();
            $opt_lijst["groep"] = $optie->getGroep();
            $opt_lijst["tekst_voor"] = $optie->getTekstVoor();
            if ( $optie->getPrijs() != 0 )
            {
                $opt_lijst["prijs"] = geld( $optie->getPrijs() );
                $opt_lijst["totaalprijs"] = geld( $optie->getPrijs() * $aantalOpties );
            }
            else
            {
                $opt_lijst["prijs"] = "";
                $opt_lijst["totaalprijs"] = "";
            }

            if ( $optie->getStatus() != OPTIE_STATUS_ACTIEF )
            {
                $opt_lijst["deleted"] = "1";
            }
            else
            {
                $opt_lijst["deleted"] = "0";
            }

            array_push( $optie_lijst, $opt_lijst );
        }
    }

    // Vullen evenementenlijst
    $evenementen = EvenementQuery::create()
        ->filterByStatus( EVENEMENT_STATUS_OPEN )
        ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
        ->find();
    $inactief = false;

    $evenement_lijst["0"] = "";
    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }

}

// Deel 2
// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    if ( isset( $_POST['terug'] ) )
    {
        $terug =  $history->get( );
        $logger->debug( "History get: " . $terug );
        header( "Location:" . $terug );
        exit;
    }

    try
    {
        $setVar = new SetVariable();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['evenement_click'] ) )
    {
        $evt = $_POST["evenement"];
        $logger->debug( 'Evenement filter: ' . $evt );

        if ( $evt > 0 )
        {
            //header( "Location:optie_lijst.php?evt=" . $_POST["evenement"] );
            header( 'Location: ' . $_SERVER['PHP_SELF'] . "?evt=" . $_POST["evenement"] );
            exit();
        }
        else
        {
            header( 'Location: ' . $_SERVER['PHP_SELF'] );
            exit();
        }
    }

}

// Deel 3

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenementnaam', $evenementNaam );
$smarty->assign( 'evenementid', $evenementId );
$smarty->assign( 'evenementenLijst', $evenement_lijst );
$smarty->assign( 'aantal_deelnemers', $aantal_deelnemers );
$smarty->assign( 'aantal_beschikbaar', $aantal_beschikbaar );
$smarty->assign( 'definitieveInschrijvingen', $definitieveInschrijvingen );
$smarty->assign( 'geannuleerdeInschrijvingen', $geannuleerdeInschrijvingen );
$smarty->assign( 'openInschrijvingen', $openInschrijvingen );
$smarty->assign( 'annuleringsverzekeringLijst', $annuleringsverzekering_lijst );
$smarty->assign( 'Opties', $optie_lijst );

$smarty->assign( 'teBetalen', $teBetalen );
$smarty->assign( 'nogTeBetalen', $nogTeBetalen );
$smarty->assign( 'alBetaald', $alBetaald );
$smarty->assign( 'betaaldPerVoucher', $betaaldPerVoucher );
$smarty->assign( 'korting', $korting );

$smarty->assign( 'beginwaardeVouchers', $beginwaardeVouchers );
$smarty->assign( 'restwaardeVouchers', $restwaardeVouchers );
$smarty->assign( 'beginaantalVouchers', $beginaantalVouchers );
$smarty->assign( 'restaantalVouchers', $restaantalVouchers );

$smarty->display( 'evenement_statistiek.tpl' );
