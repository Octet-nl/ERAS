<?php
/**
 * System      ERAS
 * Module      Lijst met opties
 * Doel        Keuzelijst, beheer van opties
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       06-11-2019
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

$sessie = new Sessie();

define( "UITLEG_ACTIEF", 1 );
define( "UITLEG_INACTIEF", 2 );
define( "UITLEG_ONGEBRUIKT", 3 );
define( "UITLEG_EVENEMENT", 4 );
define( "UITLEG_ZOEKEN", 5 );
define( "UITLEG_ALLES", 6 );

$doctitle = "Opties beheren";
$toonUitleg = UITLEG_ALLES;

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\DeelnemerHeeftOptieQuery;
use \fb_model\fb_model\EvenementHeeftOptieQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\InschrijvingHeeftOptieQuery;
use \fb_model\fb_model\OptieQuery;

$logger = new Logger();
$logger->level( LOGLEVEL_DUMP );

$statusRegel = "";
$signalError = false;

$evt = 0;
$evenementnaam = "";

$opties = null;

$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

$zonderVragenCheck = '';
$optie_lijst = array();
$evenement_lijst = array();

// DEEL 1
// Opbouwen optielijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $history->set();

    getGetVar( $filter );
    getGetVar( $evenement );
    getGetVar( $argument );

    $logger->debug( "Filter:    " . $filter );
    $logger->debug( "Evenement: " . $evenement );

    if ( $filter == null )
    {
        $filter = 'Actief';
        $logger->debug( "Filter op 'Actief' gezet" );
    }

    if ( $filter == 'Alles' )
    {
        $opties = OptieQuery::create()
            ->orderByGroep()
            ->orderByNaam()
            ->find();
        $toonUitleg = UITLEG_ALLES;
    }
    else if ( $filter == 'Evenement' )
    {
        if ( $evenement != null )
        {
            $evt = $evenement;

            $logger->debug( "Zoeken naar opties voor evenement " . $evt );
    
            $opties = OptieQuery::create()
                ->useEvenementHeeftOptieQuery()
                ->filterByEvenementId( $evt )
                ->endUse()
                ->orderByGroep()
                ->orderByNaam()
                ->find();
            $toonUitleg = UITLEG_EVENEMENT;
    
            $evenement = EvenementQuery::create()->findPk( $evt );
            if ( $evenement != null )
            {
                $evenementnaam = $evenement->getNaam();
                $logger->debug( "Opties voor evenement " . $evenementnaam );
            }
            else
            {
                $logger->warning( "Kan evenement " . $evt . " niet vinden..." );
            }
    
        }
        else
        {
            $toonUitleg = "";
        }
    }
    else if ( $filter == 'Ongebruikt' )
    {
        $actieveopties = OptieQuery::create()
            ->useEvenementHeeftOptieQuery( 'a', 'left join' )
              ->useEvenementQuery( 'b', 'left join' )
                ->filterByStatus( EVENEMENT_STATUS_OPEN )
                ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
              ->enduse()
            ->enduse()
            ->select( 'id' )
            ->distinct()
            ->filterByStatus( OPTIE_STATUS_ACTIEF )
            ->find();

        $opties = OptieQuery::create()
            ->where( "Optie.id NOT IN ?", $actieveopties )
            ->orderByGroep()
            ->orderByNaam()
            ->find();

        $toonUitleg = UITLEG_ONGEBRUIKT;
    }
    else if ( $filter == 'Inactief' )
    {
        $opties = OptieQuery::create()
            ->useEvenementHeeftOptieQuery( 'a', 'left join' )
              ->useEvenementQuery( 'b', 'left join' )
                ->filterByStatus( EVENEMENT_STATUS_OPEN )
                ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
              ->enduse()
            ->enduse()
            ->distinct()
            ->filterByStatus( OPTIE_STATUS_NIET_ACTIEF )
            ->orderByGroep()
            ->orderByNaam()
            ->find();

        $toonUitleg = UITLEG_INACTIEF;
    }
    else if ( $filter == 'Actief' )
    {
        // Toon alleen actieve opties voor open evenementen die nog niet afgelopen zijn
        $opties = OptieQuery::create()
            ->useEvenementHeeftOptieQuery( 'a', 'left join' )
              ->useEvenementQuery( 'b', 'left join' )
                ->filterByStatus( EVENEMENT_STATUS_OPEN )
                ->filterByDatumEind( array( "min" => date( "Y-m-d" ) . " 00:00:00" ) )
              ->enduse()
            ->enduse()
            ->distinct()
            ->filterByStatus( OPTIE_STATUS_ACTIEF )
            ->orderByGroep()
            ->orderByNaam()
            ->find();
        $toonUitleg = UITLEG_ACTIEF;
    }
    else if ( $filter == 'Zoeken' )
    {
        if ( $argument != null )
        {
            $myFilter = '%'.strtoupper($argument).'%';
            // Toon opties waar dit zoekargument in voorkomt
            $opties = OptieQuery::create()
                ->where( 'UPPER(Optie.Naam) LIKE ?', $myFilter )
                ->_or()
                ->where( 'UPPER(Optie.TekstVoor) LIKE ?', $myFilter )
                ->_or()
                ->where( 'UPPER(Optie.TekstAchter) LIKE ?', $myFilter )
                ->_or()
                ->where( 'UPPER(Optie.Label) LIKE ?', $myFilter )
                ->orderByGroep()
                ->orderByNaam()
                ->find();
            $toonUitleg = UITLEG_ZOEKEN;
        }
        else
        {
            $toonUitleg = "";
        }
    }

    if ( isset( $_SESSION['verwijderZonderVragen'] ) )
    {
        $zonderVragenCheck = $_SESSION['verwijderZonderVragen'];
    }

    if ( $opties != null )
    {
        foreach ( $opties as $optie )
        {
            $opt_lijst = array();
            $opt_lijst["id"] = $optie->getId();
            $opt_lijst["per_deelnemer"] = $optie->getPerDeelnemer();
            $opt_lijst["naam"] = $optie->getNaam();
            $opt_lijst["tekst_voor"] = $optie->getTekstVoor();
            $opt_lijst["tekst_achter"] = $optie->getTekstAchter();
            $opt_lijst["type"] = optieTypeNaam( $optie->getOptieType() );
            $opt_lijst["groep"] = $optie->getGroep();
            $opt_lijst["is_default"] = $optie->getIsDefault();
            $opt_lijst["totaal_aantal"] = $optie->getTotaalAantal();
            $opt_lijst["prijs"] = $optie->getPrijs();
            $opt_lijst["status"] = $optie->getStatus();
            $opt_lijst["label"] = $optie->getLabel();
            $opt_lijst["gemaakt_datum"] = $optie->getDatumGemaakt();
            $opt_lijst["gemaakt_door"] = $optie->getGemaaktDoor();
            $opt_lijst["gewijzigd_datum"] = $optie->getDatumGewijzigd();
            $opt_lijst["gewijzigd_door"] = $optie->getGewijzigdDoor();
            if ( $optie->getStatus() != OPTIE_STATUS_ACTIEF )
            {
                $opt_lijst["deleted"] = "1";
            }
            else
            {
                $opt_lijst["deleted"] = "0";
            }
    
            $opt_lijst["kanVerwijderd"] = "0";
            $opties = EvenementHeeftOptieQuery::create()->filterByOptieId( $optie->getId() )->find();
            if ( sizeof( $opties ) == 0 )
            {
                $opties = DeelnemerHeeftOptieQuery::create()->filterByOptieId( $optie->getId() )->find();
                if ( sizeof( $opties ) == 0 )
                {
                    $opties = InschrijvingHeeftOptieQuery::create()->filterByOptieId( $optie->getId() )->find();
                    if ( sizeof( $opties ) == 0 )
                    {
                        $opt_lijst["kanVerwijderd"] = "1";
                    }
                }
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

    foreach ( $evenementen as $evenement )
    {
        $evenement_lijst[$evenement->getId()] = $evenement->getNaam();
    }
    $evenement_lijst["0"] = "";

    $filter_lijst['0']         = '';
    $filter_lijst['Inactief']  = 'Inactief';
    $filter_lijst['Actief']    = 'Actief';
    $filter_lijst['Ongebruikt']= 'Ongebruikt';
    $filter_lijst['Evenement'] = 'Evenement';
    $filter_lijst['Zoeken']    = 'Zoeken';
    $filter_lijst['Alles']     = 'Alles';
}

// Na drukken op een van de knoppen
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

    if ( isset( $_POST['afmelden'] ) )
    {
        $autorisatie->logout();
        header( "Refresh:0" );
        exit;
    }

    if ( isset( $_POST['evenement'] ) )
    {
        $evt = $_POST["evenement"];
    }
    if ( isset( $_POST['filter'] ) )
    {
        $filter = $_POST["filter"];
    }
    if ( isset( $_POST['zoekarg'] ) )
    {
        $zoekArgument = $_POST["zoekarg"];
    }

    if ( isset( $_POST['zonderVragen'] ) )
    {
        $logger->debug( "Zonder vragen aangezet" );
        $_SESSION['verwijderZonderVragen'] = 'checked="checked"';
    }
    else
    {
        $logger->debug( "Zonder vragen uitgezet" );
        $_SESSION['verwijderZonderVragen'] = '';
    }

    $zonderVragenCheck = $_SESSION['verwijderZonderVragen'];

    if ( $filter == 'Inactief' )
    {
        $logger->debug( 'Ook inactieve opties.' );
        header( "Location:optie_lijst.php?filter=Inactief" );
        exit();
    }
    else if ( $filter == 'Actief' )
    {
        $logger->debug( 'Alleen actieve opties.' );
        header( "Location:optie_lijst.php?filter=Actief" );
        exit();
    }
    else if ( $filter == 'Ongebruikt' )
    {
        $logger->debug( 'Alleen ongebruikte opties.' );
        header( "Location:optie_lijst.php?filter=Ongebruikt" );
        exit();
    }
    else if ( $filter == 'Zoeken' )
    {
        $logger->debug( 'Alleen actieve opties.' );
        header( "Location:optie_lijst.php?filter=Zoeken&argument=" . $zoekArgument );
        exit();
    }

    if ( isset( $_POST['verwijder'] ) )
    {
        $logger->debug( "Verwijderen" );
        $optie = OptieQuery::create()->findPk( $_POST['verwijder'] );
        try
        {
            $optie->delete();
        }
        catch ( Exception $ex )
        {
            $logger->warning( $ex->getMessage() );
            $logger->warning( $ex->getPrevious()->getPrevious() );
            $foutCode = $ex->getPrevious()->getPrevious()->errorInfo[1];

            if ( $foutCode == "1451" )
            {
                alert( 'Deze optie is in gebruik en kan niet verwijderd worden.\nU kunt de optie inactief maken zodat deze niet meer in de lijst verschijnt.' );
            }
            else
            {
                alert( 'Verwijderen is mislukt. Er is iets misgegaan. ' );
            }
        }

        header( "Refresh:0" );
        exit;
    }

    try
    {
        $setVar = new SetVariable();
        $setVar->name( $bewerk )
            ->go();
        $setVar->name( $inactief )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    if ( isset( $_POST['toevoegen'] ) )
    {
        $metEvt = "";
        if ( $evt > 0 )
        {
            $metEvt = "?evt=" . $evt;
        }
        header( "Location:optie_opvoeren.php" . $metEvt );
        exit;
    }
    elseif ( isset( $_POST['bewerk'] ) )
    {
        header( "Location:optie_opvoeren.php?id=" . $bewerk );
        exit;
    }
    elseif ( isset( $_POST['inactief'] ) )
    {
        $optie = OptieQuery::create()->findPk( $_POST['inactief'] );
        $optie->setStatus( OPTIE_STATUS_NIET_ACTIEF );
        $optie->setGewijzigdDoor( $autorisatie->getUserId() );
        $optie->save();

        header( "Location:optie_lijst.php" );
        exit();
//        header( "Refresh:0" );
        //        exit;
    }
    elseif ( isset( $_POST['actief'] ) )
    {
        $optie = OptieQuery::create()->findPk( $_POST['actief'] );
        $optie->setStatus( OPTIE_STATUS_ACTIEF );
        $optie->setGewijzigdDoor( $autorisatie->getUserId() );
        $optie->save();
        header( "Location:optie_lijst.php?inact=true" );
        exit();
//        header( "Refresh:0" );
        //        exit;
    }

    $logger->debug( 'Fall through filter ' . $filter . ", evenement " . $evt );

    if ( $evt > 0 )
    {
        //header( "Location:optie_lijst.php?evt=" . $_POST["evenement"] );
        header( 'Location: ' . $_SERVER['PHP_SELF'] . "?evenement=" . $_POST["evenement"] . "&filter=" . $filter );
        exit();
    }
    else
    {
        header( 'Location: ' . $_SERVER['PHP_SELF'] . "?filter=" .$filter );
        exit();
    }
}

if ( $toonUitleg == UITLEG_ACTIEF )
{
    $doctitle = "Actieve opties";
    $documentsubtekst = "Alleen actieve opties voor openstaande evenementen die nog niet afgelopen zijn. (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "inact";
    $buttonitemtekst = "Inactief";
    $buttonitemname = "inactief";
}
else if ( $toonUitleg == UITLEG_INACTIEF )
{
    $doctitle = "Inactieve opties";
    $documentsubtekst = "Inactieve opties. (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "inact";
    $buttonitemtekst = "Inactief";
    $buttonitemname = "inactief";
}
else if ( $toonUitleg == UITLEG_ONGEBRUIKT )
{
    $doctitle = "Ongebruikte opties";
    $documentsubtekst = "Inactieve opties of opties uit evenementen die niet actief zijn. (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "inact";
    $buttonitemtekst = "Inactief";
    $buttonitemname = "inactief";
}
else if ( $toonUitleg == UITLEG_EVENEMENT )
{
    $doctitle = "Actieve opties voor " . $evenementnaam;
    $documentsubtekst = "Alleen opties voor dit evenement. (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "inact";
    $buttonitemtekst = "Inactief";
    $buttonitemname = "inactief";
}
else if ( $toonUitleg == UITLEG_ZOEKEN )
{
    $doctitle = "Zoekresultaat";
    $documentsubtekst = "Opties waar het zoekargument '" . $argument . "' in voorkomt. (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "inact";
    $buttonitemtekst = "Inactief";
    $buttonitemname = "inactief";
}
else if ( $toonUitleg == UITLEG_ALLES )
{
    $doctitle = "Alle opties";
    $documentsubtekst = "Alle opties (" . sizeof( $optie_lijst ) . ")";
    $buttonname = "act";
    $buttonitemtekst = "Actief";
    $buttonitemname = "actief";
}
else
{
    $doctitle = "Niets gevonden";
    $documentsubtekst = "(betekenisloze selectie)";
    $buttonname = "";
    $buttonitemtekst = "";
    $buttonitemname = "";
}

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'documentsubtekst', $documentsubtekst );
$smarty->assign( 'buttonname', $buttonname );
$smarty->assign( 'buttonitemtekst', $buttonitemtekst );
$smarty->assign( 'buttonitemname', $buttonitemname );
$smarty->assign( 'zonderVragenCheck', $zonderVragenCheck );
$smarty->assign( 'Opties', $optie_lijst );
$smarty->assign( 'filterlijst', $filter_lijst );
$smarty->assign( 'evenement', $evt );
$smarty->assign( 'evenementenLijst', $evenement_lijst );

// Voor statusregel
$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );
$smarty->assign( 'loggedin', $autorisatie->getUserId() );

$smarty->display( 'optie_lijst.tpl' );
