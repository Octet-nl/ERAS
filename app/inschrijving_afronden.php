<?php
/**
 * System      Inschrijvingen
 * Module      Inschrijving opties
 * Doel        Opties per inschrijving registreren
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       08-10-2019
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

use fb_model\fb_model\VoucherQuery;
use fb_model\fb_model\Contactlog;
use \fb_model\fb_model\DeelnemerHeeftOptieQuery;
use \fb_model\fb_model\DeelnemerQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingHeeftOptie;
use \fb_model\fb_model\InschrijvingHeeftOptieQuery;
use \fb_model\fb_model\InschrijvingQuery;
use \fb_model\fb_model\KeuzesQuery;
use \fb_model\fb_model\OptieQuery;
use \fb_model\fb_model\Mailinglist;
use \fb_model\fb_model\MailinglistQuery;
use \Propel\Runtime\Propel;

$sessie = new Sessie();

// https://www.smarty.net/docs/en/
$smarty = new Smarty(); 
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

$logger = new Logger();
$logger->level( LOGLEVEL );

$doctitle = "Inschrijving";

$statusRegel = "";
$signalError = false;

// define screen variables and set to empty values
require_once 'persoon_define_variables.inc';

$contactPersoonId = null;
$persoon = null;
$sessieVariabelen = null;
$aantal_deelnemers = 1;
$aantal_deelnemersErr = "";
$max_deelnemers = 0;
$status = 0;
$evt = 0;
$inschrijvingnummer = 0;
$validatiemelding = "";
$optieArray = array();
$dynamicHtml = "";
$avHtml = "";
$betaalwijzeHtml = "";
$voucherHtml = "";
$statusErr = "";
$betaalwijze = 0;
$annuleringsverzekering = ANNULERINGSVERZEKERING_GEEN;
$heeft_annuleringsverzekering = 0;
$evenement_annuleringsverzekering = 0;
$reedsBetaald = "0.00";

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );
$validateOk = 0;

if ( isset( $_SESSION['inschrijving'] ) )
{
    $sessieVariabelen = $_SESSION['inschrijving'];
}

function inschrijvingOptieToevoegen( $optieId, $inschrijvingId, $waarde, $inschrijvingOptieId = null )
{
    global $autorisatie;

    $logger = new Logger();
    $logger->level( LOGLEVEL );
    $logger->debug( "InschrijvingOptieToevoegen" );
    if ( $inschrijvingOptieId == null )
    {
        $inschrijvingOptie = new inschrijvingHeeftOptie();
        $inschrijvingOptie->setGemaaktDoor( $autorisatie->getUserId() );
    }
    else
    {
        $inschrijvingOptie = InschrijvingHeeftOptieQuery::create()->findPK( $inschrijvingOptieId );
    }
    $inschrijvingOptie->setGewijzigdDoor( $autorisatie->getUserId() );
    $inschrijvingOptie->setOptieId( $optieId );
    $inschrijvingOptie->setInschrijvingId( $inschrijvingId );
    $inschrijvingOptie->setWaarde( $waarde );
    $inschrijvingOptie->save();
}

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "inschrijving_overzicht.php" );
$autorisatie->validate( AUTORISATIE_STATUS_KLANT );

// DEEL 1
// De GET method heeft de sessiestatus nodig om huidige waarden te kunnen invullen

if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( $sessieVariabelen == null )
    {
        $logger->warning( "Geen sessiedata en geen evenement ID opgegeven" );
        header( "Location:evenement_kiezen.php" );
        exit();
    }
    else
    {
        $evt = $sessieVariabelen["evenement_id"];
        $contactPersoonId = $sessieVariabelen["contactpersoon_id"];
        if ( $evt == null )
        {
            $logger->warning( "Geen evenement ID in sessiedata gevonden" );
            echo "Geen evenement ID in sessiedata gevonden.";
            return;
        }
        if ( $contactPersoonId == null )
        {
            $logger->warning( "Geen contactpersoon ID in sessiedata gevonden" );
            echo "Geen contactpersoon ID in sessiedata gevonden.";
            return;
        }
    }

    $logger->debug( "GET controle ok" );

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
                $logger->warning( "Dit evenement (" . $evt . ") is niet geopend voor inschrijvingen. Status is: " . $statusNaam );
                alert( "Dit evenement is niet geopend voor inschrijvingen. Status is: " . $statusNaam );
                return;
            }
            else
            {
                $betaalwijze = $evenement->getBetaalwijze();
                $evenement_annuleringsverzekering = $evenement->getAnnuleringsverzekering();
            }
        }
        else
        {
            $logger->warning( "Evenement " . $evt . " is niet gevonden." );
            echo "Evenement " . $evt . " is niet gevonden.";
            return;
        }

        // $aantal_deelnemers = DeelnemerQuery::create()
        //     ->filterByInschrijvingId( $sessieVariabelen["inschrijving_id"] )
        //     ->count();

        $aantal_deelnemers = $sessieVariabelen["aantal_deelnemers"];
        $max_deelnemers = $sessieVariabelen["max_deelnemers"];

        $prijsOpties = DeelnemerHeeftOptieQuery::create()
            ->useDeelnemerQuery( 'a', 'left join' )
            ->useInschrijvingQuery( 'b', 'left join' )
            ->filterById( $sessieVariabelen["inschrijving_id"] )
            ->enduse()
            ->enduse()
            ->find();

        $totaalPrijsOpties = 0;
        foreach ( $prijsOpties as $prijsOptie )
        {
            //$logger->debug( "Toevoegen optieprijs " . $prijsOptie );
            $totaalPrijsOpties += $prijsOptie->getPrijs();
        }

        $logger->debug( $totaalPrijsOpties );
        $totaalPrijsOpties = number_format( $totaalPrijsOpties, 2 );
        $logger->debug( $totaalPrijsOpties );

        $opties = OptieQuery::create()
            ->filterByPerDeelnemer( '0' )
            ->useEvenementHeeftOptieQuery()
            ->filterByEvenementId( $evt )
            ->orderByVolgorde()
            ->endUse()
            ->orderByGroep()
            ->find();

        $aantalOpties = sizeof( $opties );
        $logger->debug( "Vullen optie array, er zijn " . $aantalOpties . " opties op inschrijvingniveau" );

        $inschrijving = InschrijvingQuery::create()->findPK( $sessieVariabelen["inschrijving_id"] );
        $annuleringsverzekering = $inschrijving->getAnnuleringsverzekering();

        $inschrijvingnummer = $sessieVariabelen["inschrijving_id"];

        $betaaldPer = $inschrijving->getBetaalWijze();

        $reedsBetaald = $inschrijving->getReedsBetaald();

        // Welke opties zijn momenteel actief?
        require "opties_huidig.php";
        $inschrijvingOpties = inschrijvingsOpties( $sessieVariabelen["inschrijving_id"] );
        $logger->debug( "inschrijvingOpties:" );
        $logger->dump( $inschrijvingOpties );

        if ( $inschrijvingOpties != null )
        {
            $logger->debug( "d.m.v. inschrijvingsOpties" );
            $currentOpties = $inschrijvingOpties;
        }
        else
        {
            $logger->debug( "Er zijn geen inschrijvingsopties." );
            $currentOpties = array();
        }

        $logger->dump( $currentOpties );

        require "opties_naar_html_class.php";
        $optiesNaarHtml = new optiesNaarHtml();
        $optiesNaarHtml->setEvenementId( $evt );
        $optiesNaarHtml->setAutorisatieRol( $autorisatie->getRol() );
        $optiesNaarHtml->setKopregel( "" ); //"Opties voor deze inschrijving");
        $optiesNaarHtml->setCurrent( $currentOpties );
        $optiesNaarHtml->genereerHtml( $opties );
        $dynamicHtml = $optiesNaarHtml->getHtml();
        // optieArray bevat alle inschrijvingsopties behalve de annuleringsverzekering
        $optieArray = $optiesNaarHtml->getOptieArray();

        require_once "annuleringsverzekering.php";
        $annuleringsVerzekeringObj = new AnnuleringsVerzekering();

        // Door optieArray door te geven aan avNaarHTML wordt een eventuele
        // annuleringsverzekering ge-append aan optieArray
        require "annuleringsverzekering_naar_html_class.php";
        $avNaarHTML = new avNaarHTML( $optieArray );
        //$avNaarHTML->setCurrent( $currentOpties );
        $avNaarHTML->heeftAv( $evenement_annuleringsverzekering );
        $avNaarHTML->setAv( $annuleringsverzekering );
        if ( $annuleringsVerzekeringObj != null )
        {
            $alleNamen = array();
            $alleNamen = $annuleringsVerzekeringObj->getAlleNamen();
            $logger->dump( $alleNamen );
            // $logger->dump( $opties );
            //$avNaarHTML->genereerHtml( $opties, $alleNamen );
            $avNaarHTML->genereerHtml( $alleNamen );
        }
        else
        {
            $logger->debug( "$annuleringsVerzekeringObj is null" );
            $avNaarHTML->genereerHtml( "" );
        }
        $avHtml = $avNaarHTML->getHtml();
        // Nu is de eventuele annuleringsverzekering toegevoegd aan optieArray
        $optieArray = $avNaarHTML->getOptieArray();

        if ( $betaalwijze > 0 )
        {
            require "betaalwijze_naar_html_class.php";
            $betalingNaarHTML = new betalingNaarHTML( $betaalwijze );
            $betalingNaarHTML->setBetaalwijze( $betaalwijze );
            $betalingNaarHTML->setBetaaldPer( $betaaldPer );
            $betalingNaarHTML->genereerHtml();
            $betaalwijzeHtml = $betalingNaarHTML->getHtml();
            $voucherHtml = $betalingNaarHTML->getVoucherHtml();
        }
        else
        {
            $logger->warning( "Geen betaalwijze opgegeven" );
        }

        $logger->dump( $optieArray );
    }
    else
    {
        $logger->warning( "Geen evenement opgegeven" );
        alert( "Geen evenement opgegeven" );
        return;
    }
    //$logger->dump( $dynamicHtml );
    //$logger->dump( $avHtml );

    $_SESSION['chkv'] = "ChEcKvOuChEr";

}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert niets, de invoer is gevuld met zinvolle default waarden.
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );
    $logger->dump( $_SESSION );

    $validateOk = 0;

    try
    {
        $setVar = new SetVariable();
        // POST variabelen zonder validatie, maar moeten wel aanwezig zijn
        $validateOk += $setVar->name( $evt )
            ->onerror( $statusRegel )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $aantal_deelnemers )
            ->onerror( $statusRegel )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $max_deelnemers )
            ->onerror( $statusRegel )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $heeft_annuleringsverzekering )
            ->defaultvalue( ANNULERINGSVERZEKERING_GEEN )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $annuleringsverzekering )
            ->defaultvalue( ANNULERINGSVERZEKERING_GEEN )
            ->required( true )
            ->go();
        $validateOk += $setVar->name( $betaalwijze )
        ->defaultvalue( 0 )
        ->required( false )
            ->go();

        $contactPersoonId = $sessieVariabelen["contactpersoon_id"];

    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    require_once "annuleringsverzekering.php";
    $annuleringsVerzekeringObj = new AnnuleringsVerzekering();

    if ( $validateOk == 0 )
    {
        $con->beginTransaction();
        try
        {
            $optieArray = $_SESSION['opties'];

            $logger->debug( "EvenementID:" . $sessieVariabelen["evenement_id"] . "Evenementnaam:" . $sessieVariabelen["evenement_naam"] . ", ContactpersoonID:" . $sessieVariabelen["contactpersoon_id"] );

            $evenementnaam = $sessieVariabelen["evenement_naam"];

            $inschrijving = InschrijvingQuery::create()->findPK( $sessieVariabelen["inschrijving_id"] );

            $inschrijvingnummer = $sessieVariabelen["inschrijving_id"];

            if ( $inschrijving != null )
            {
                $logger->debug( "Inschrijvingsopties opvoeren, inschrijving_id=" . $inschrijving->getId() );

                $reedsBetaald = $inschrijving->getReedsBetaald();
                $betaaldPerVoucher = $inschrijving->getBetaaldPerVoucher();

                // Eerst alle bestaande opties in de database verwijderen
                $huidigeOpties = InschrijvingHeeftOptieQuery::create()->filterByInschrijvingId( $inschrijving->getId() )->find();
                foreach ( $huidigeOpties as $huidigeOptie )
                {
                    $logger->debug( "Verwijderen inschrijvingsoptie ID=" . $huidigeOptie->getId() );
                    $huidigeOptie->delete();
                }

                // Daarna alle huidige opties weer opvoeren
                $totaalbedrag = 0;

                foreach ( $_POST as $key => $value )
                {
                    $logger->verbose( 'POST key ' . $key . ' value ' . $value );
                    $value = cleanInput( $_POST[$key] );

                    if ( $key == "totaalbedrag" )
                    {
                        $totaalbedrag = $value;
                    }

                    foreach ( $optieArray as $optienaam )
                    {
                        $oGroep = "";
                        if ( array_key_exists( "groep", $optienaam ) )
                        {
                            // In de url is bij de POST een underscore toegevoegd
                            $oGroep = str_replace( ' ', '_', $optienaam["groep"] );
                        }
                        $logger->verbose( 'Optienaam["groep"]: ' . $oGroep . ' optienaam["naam"]: ' . $optienaam["naam"] );
                        if ( $oGroep == $key || str_replace( ' ', '_', $optienaam["naam"] ) == $key )
                        {
                            if ( $optienaam["type"] == OPTIETYPE_KEUZE_RADIO || $optienaam["type"] == OPTIETYPE_KEUZE_MEERDERE )
                            {
                                if ( $optienaam["id"] == $value )
                                {
                                    $logger->verbose( 'Option select opvoeren  ID:' . $optienaam["id"] . ' key:' . $key . ' value:' . $value );
                                    inschrijvingOptieToevoegen( $optienaam["id"], $inschrijving->getId(), $value );
                                }
                            }
                            else
                            {
                                $logger->verbose( 'Niet option select opvoeren ID:' . $optienaam["id"] . ' key:' . $key . ' value:' . $value );
                                inschrijvingOptieToevoegen( $optienaam["id"], $inschrijving->getId(), $value );
                            }
                        }
                    }
                }

                //Controle net voor afronden of het aantal deelnemers nog kan.
                $sum = DeelnemerQuery::create()
                    ->useInschrijvingQuery( 'a', 'left join' )
                    ->filterByEvenementId( $evt )
                    ->filterByStatus( INSCHRIJVING_STATUS_DEFINITIEF )
                    ->enduse()
                    ->count();
                $aantal_beschikbaar = $max_deelnemers - $sum - $aantal_deelnemers;
                $over = $max_deelnemers - $sum;
                $logger->debug( "Aantal beschikbare plaatsen: " . $over . ", Aantal deelnemers: " . $aantal_deelnemers );

                if ( $aantal_beschikbaar < 0 )
                {
                    $con->rollBack();
                    $logger->error( "Rollback, Teveel deelnemers, beschikbaar: " . $over . ", Aantal deelnemers: " . $aantal_deelnemers );
                    alertAndGo( "Het spijt ons bijzonder. Inmiddels hebben anderen zich ingeschreven en zijn er niet meer voldoende plaatsen beschikbaar.", "inschrijving_overzicht.php?evt=" . $evt );
                    exit;
                }

                $voucherId = 0;
                $voucherWaarde = 0;
                $voucherRest = 0;
                $voucherType = 0;

                $nogTeBetalen = rondNul( (float)$_POST['teBetalen'] );

                if ( isset( $_POST['voucherid'] ) )
                {
                    $voucherId = $_POST['voucherid'];
                    if ( $voucherId > 0 )
                    {
                        $voucherWaarde = $_POST['voucherwaarde'];
                        $voucherRest = $_POST['voucherrest'];
                        $voucherType = $_POST['vouchertype'];
//ToDo: dit kan weg
//                        if ( $nogTeBetalen == 0 )
//                        {
//                            // Volledig bedrag betaald met een voucher
//                            $betaalwijze = BETAALWIJZE_VOUCHER;                        
//                        }
                    }
                }

                // Integriteits check
                $berekend = $totaalbedrag - ($reedsBetaald + $voucherWaarde );
                if ( $nogTeBetalen > 0 && abs($nogTeBetalen - $berekend) > 0.000001 )
                {
                    $logger->error( "Totaalbedrag " . $totaalbedrag );
                    $logger->error( "Reeds betaald " . $reedsBetaald );
                    $logger->error( "Voucherwaarde " . $voucherWaarde );
                    $logger->error( "Nog te betalen " . $nogTeBetalen );
                    $logger->error( "Berekend " . $berekend );
                    var_dump( $nogTeBetalen, $berekend );
                    $logger->error( "Te betalen bedrag berekening klopt niet. in POST: " . $nogTeBetalen . ", berekend: " . $berekend );
                    throw new Exception("Te betalen bedrag berekening klopt niet. Inschrijving is gestopt. Zie errorlog" );
                    exit;
                }
                else
                {
                    $logger->debug( "Betalingsberekening OK." );
                }
                
                if ( $voucherType == VOUCHERTYPE_KORTING )
                {
                    $inschrijving->setKorting( $voucherWaarde );
                }
                else
                {
                    $betaaldPerVoucher += $voucherWaarde;
                    $inschrijving->setKorting( "0.00" );
                }

                $inschrijving->setAnnuleringsverzekering( $annuleringsverzekering );
                $inschrijving->setBetaalwijze( $betaalwijze );
                $inschrijving->setBetaaldPerVoucher( $betaaldPerVoucher );
                $inschrijving->setVoucherId( $voucherId );
                $inschrijving->setTotaalbedrag( $totaalbedrag );
                $inschrijving->setNogTeBetalen( $nogTeBetalen);
                $inschrijving->setReedsBetaald( $voucherWaarde + $reedsBetaald);
                $inschrijving->setGewijzigdDoor( $autorisatie->getUserId() );

                $inschrijving->setStatus( INSCHRIJVING_STATUS_DEFINITIEF );

                $inschrijving->save();

                $inschrijfnummer = $inschrijving->getId();

                $contactlog = new Contactlog;
                $contactlog->setPersoonId( $contactPersoonId );
                $contactlog->setTekst(  "Inschrijving met id " . $inschrijving->getId() . " op evenement " . $sessieVariabelen["evenement_id"] . 
                                        ", " . $sessieVariabelen["evenement_naam"]  . '\nAfgerond door ' . $autorisatie->getUserId() . 
                                        ". Totaalbedrag " . geld($totaalbedrag) . ", nog te betalen " . geld($nogTeBetalen) );
                $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
                $contactlog->save();

                if ( $voucherId > 0 )
                {
                    $contactlog = new Contactlog;
                    $contactlog->setPersoonId( $contactPersoonId );
                    $contactlog->setTekst( "Inschrijving met id " . $inschrijving->getId() . ",\nBetaald met voucher id " . $voucherId . 
                                           ", type " . voucherNaam( $voucherType ) . ". Bedrag " . geld($voucherWaarde) . ", resterend op voucher EUR " . geld($voucherRest) ); 
                    $contactlog->setGemaaktDoor( $autorisatie->getUserId() );
                    $contactlog->save();
                    $voucher = VoucherQuery::create()->findpk( $voucherId );
                    if ( $voucher->getVoucherType() == VOUCHERTYPE_VOUCHER )
                    {
                        // Persoonlijke voucher
                        // Bedrag afboeken.
                        $voucher->setRestWaarde( $voucherRest );
                        $voucher->setVerbruikt( $voucher->getVerbruikt() + $voucherWaarde );
                        $voucher->setGewijzigdDoor( $autorisatie->getUserId() );
                        if ( $voucherRest <= 0 )
                        {
                            // actief is 1 of null, i.v.m. unique constraint. 
                            // Een email adres moet uniek zijn, maar alleen voor actieve vouchers.
                            // Als het actief op null (niet 0!) wordt gezet, kunnen er meerdere dezelfde email adressen zijn.
                            $voucher->setIsActief( null );
                        }
                        $voucher->save();   
                    }
                }

                if ( isset( $_POST['nieuwsbrief'] ) )
                {
                    $mailing = MailinglistQuery::create()
                        ->filterByEmail( $sessieVariabelen["contactpersoon_email"] )
                        ->filterByEvenementId( $evt )
                        ->findOne();
                    if ( $mailing != null )
                    {
                        $logger->dump( $mailing );
                        $logger->info( "Klant is al ingeschreven op deze mailinglist." );
                    }
                    else
                    {
                        try
                        {
                            require_once 'code_generator_class.php';
                            $codeGen = new CodeBeheer();
                            $codeGen->setLengte(8);
                            $code = $codeGen->genereer(false);
                    
                            // Opvoeren in database
                            $mailing = new Mailinglist();
        
                            $mailing->setEmail( $sessieVariabelen["contactpersoon_email"] );
                            $mailing->setEvenementId( $evt );
                            $mailing->setNaam( $sessieVariabelen["contactpersoon_naam"] );
                            $mailing->setCode( $code );
                            $mailing->setGewijzigdDoor( $autorisatie->getUserId() );
                            $mailing->save();
                        }
                        catch(Exception $ex)
                        {
                            $logger->dump( $ex );
                            // Geen probleem, dan maar geen nieuwsbrief..
                        }
                    }

                }

                // Commit transactie
                $con->commit();

                unset( $_SESSION['inschrijving'] );
                unset( $_SESSION['opties'] );
                unset( $_SESSION['chkv'] );

                $status = 0;
                $logger->debug( 'Gegevens zijn opgeslagen' );

                header("location:inschrijving_bevestiging.php?iid=" . $inschrijfnummer);
                exit;
            }
            else
            {
                $con->rollback();
                $logger->error( "Inschrijving (null) is niet gevonden." );
            }
        }
        catch ( \Exception $e )
        {
            $con->rollback();
            //var_dump( $e );
            $logger->error( 'Probleem met opslaan gegevens, details: ' . PHP_EOL . $e );
            $validatiemelding = 'Probleem met opslaan gegevens, details: <br/>' . $e;
            $validatiemelding .= "<br/>Evenement: " . $evt . "<br/>";
            alert( 'Probleem met opslaan gegevens, details: <br/>' . $e );
            exit;
        }
    }
    else
    {
        $logger->debug( 'Validatie niet akkoord, ' . $validateOk );
        $statusRegel = "Pas a.u.b. de gemarkeerde velden aan";
        $signalError = true;
    }
}

// DEEL 3
// Dit deel wordt altijd aangeroepen. De eerste keer met
// - lege variabelen, of
// - in geval van een wijziging, de gegevens van de te wijzigen persoon.
// Dit deel vult de waarden in voor de HTML template en start deze op.

//$validatiemelding = $htmlTotal . dynamic_radio_group('terugreis', $values, $html_elements, 'advert');

$_SESSION['opties'] = $optieArray;
if ( $annuleringsVerzekeringObj == null )
{
    $signalError = true;
    $statusRegel = "Geen annuleringsverzekering gevonden";
}
else
{
    $formuleAR     = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_ALLRISK );
    $formuleGewoon = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_GEWOON );
    $formuleGeen   = $annuleringsVerzekeringObj->getFormule( ANNULERINGSVERZEKERING_GEEN );

    $logger->debug( $formuleAR );
    $logger->debug( $formuleGewoon );
}

//            $formuleGewoon = "annulering_gewoon = subTotaal * 0.055;
//            annulering_gewoon += 350;
//            annulering_gewoon += (annulering_gewoon * 0.21);";

$ini= parse_ini_file( CONFIG_FILENAME, true );
$voorwaarden = $ini['organisatie']['voorwaarden'];

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenement_naam', $sessieVariabelen["evenement_naam"] );
if ( $persoon == null && $sessieVariabelen == null )
{
    $smarty->assign( 'contactpersoon_naam', "" );
    $smarty->assign( 'contactpersoon_email', "" );
}
else
{
    $smarty->assign( 'contactpersoon_naam', $sessieVariabelen["contactpersoon_naam"] );
    $smarty->assign( 'contactpersoon_email', $sessieVariabelen["contactpersoon_email"] );
}
$smarty->assign( 'aantal_beschikbaar', $sessieVariabelen["aantal_beschikbaar"] );
$smarty->assign( 'aantal_deelnemers', $aantal_deelnemers );
$smarty->assign( 'aantal_deelnemersErr', $aantal_deelnemersErr );
$smarty->assign( 'max_deelnemers', $max_deelnemers );
$smarty->assign( 'prijs_per_persoon', $sessieVariabelen["prijs"] );
$totaalPrijs = ( $aantal_deelnemers * $sessieVariabelen["prijs"] ) * 1.00;
$bedrag = number_format( $totaalPrijs, 2 );
$smarty->assign( 'totaalprijs', str_replace( ',', '', $bedrag ) );
$smarty->assign( 'totaalprijs_opties', $totaalPrijsOpties );
$smarty->assign( 'dynamichtml', $dynamicHtml );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'inschrijvingnummer', $inschrijvingnummer );
$smarty->assign( 'validatiemelding', $validatiemelding );
$smarty->assign( 'heeft_annuleringsverzekering', $heeft_annuleringsverzekering );
$smarty->assign( 'annulering_allrisk_formule', $formuleAR );
$smarty->assign( 'annulering_gewoon_formule', $formuleGewoon );
$smarty->assign( 'annulering_geen_formule', $formuleGeen );
$smarty->assign( 'avhtml', $avHtml );
$smarty->assign( 'reedsbetaald', $reedsBetaald );
$smarty->assign( 'betaalwijze', $betaalwijze );
$smarty->assign( 'betaalwijzeHtml', $betaalwijzeHtml );
$smarty->assign( 'voucherHtml', $voucherHtml );
$smarty->assign( 'voorwaarden', $voorwaarden );
$smarty->assign( 'statusErr', $statusErr );
$smarty->assign( 'email', $email );
$smarty->assign( 'typeVoucher', VOUCHERTYPE_VOUCHER );
$smarty->assign( 'typeKorting', VOUCHERTYPE_KORTING );

$smarty->assign( 'isPersoneel', $autorisatie->getRol() >= AUTORISATIE_STATUS_MEDEWERKER );
// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );
$smarty->assign( 'noLogout', 'true' );

$smarty->display( 'inschrijving_afronden.tpl' );
