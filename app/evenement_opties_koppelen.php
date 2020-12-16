<?php
/**
 * System      ERAS
 * Module      Evenement-opties
 * Doel        Evenement-Optie gegevens koppelen
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       03-09-2019
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

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

// https://respect-validation.readthedocs.io/en/1.1/
use Propel\Runtime\Propel;
use Respect\Validation\Validator as v;
use \fb_model\fb_model\EvenementHeeftOptie;
use \fb_model\fb_model\EvenementHeeftOptieQuery;
use \fb_model\fb_model\EvenementQuery;
use \fb_model\fb_model\OptieQuery;

$doctitle = "Koppel opties aan evenement";

$evenementNaam = $evenementId = "";
$evenementenLijst = array();
$beschikbaarLijst = array();
$gekozenLijst = array();
$statusRegel = "";
$signalError = false;

$con = Propel::getConnection( fb_model\fb_model\Map\OptieTableMap::DATABASE_NAME );

$logger = new Logger();
$logger->level( LOGLEVEL );

$sessie = new Sessie();
$history = new History();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_MEDEWERKER );

// DEEL 1
// De GET method wordt alleen getriggerd als dit script voor de eerste keer wordt aangeroepen
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    if ( isset( $_GET['evt'] ) )
    {
        $evenementId = $_GET['evt'];

        $evenement = EvenementQuery::create()->findPK( $evenementId );
        if ( $evenement != null )
        {
            $evenementNaam = $evenement->getNaam();
            $status = $evenement->getStatus();
            if ( $status == EVENEMENT_STATUS_GESLOTEN )
            {
                echo "Evenement is gesloten";
                return;
            }

            $alleOpties = OptieQuery::create()
                ->filterByStatus( OPTIE_STATUS_ACTIEF )
                ->orderByNaam()
                ->find();
 
            foreach ( $alleOpties as $optie )
            {
                $beschikbaarLijst[$optie->getId()] = $optie->getNaam();
            }
            $logger->dump( $beschikbaarLijst );

            $huidigeOpties = EvenementHeeftOptieQuery::create()
                ->filterByEvenementId( $evenementId )
                ->orderByVolgorde()
                ->find();

            foreach ( $huidigeOpties as $opties )
            {
                $optieNaam = OptieQuery::create()->filterById( $opties->getOptieId() )->findOne();
                $gekozenLijst[$opties->getOptieId()] = $optieNaam->getNaam();
            }
            $logger->dump( $gekozenLijst );

            $beschikbaarLijst = array_diff_key( $beschikbaarLijst, $gekozenLijst );
        }
        else
        {
            $validatiemelding = "evenement " . $evenementId . " is niet gevonden.";
            $id = null;
            $statusRegel = "Evenement " . $evenementId . " is niet gevonden.";
            $signalError = true;
        }
    }
    else
    {
        // echo "Geen evenement opgegeven";
        // return;
        $beschikbaarLijst[0] = "-";
        $gekozenLijst[0] = "-";
    }
}

// DEEL 2
// De POST method wordt getriggered door het drukken op de 'opslaan' knop.
// Dus de eerste keer dat dit script wordt aangeroepen wordt dit gedeelte overgeslagen.
// Dit deel controleert de invoer en plaatst de waarden uit het formulier terug in de PHP variabelen
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    $logger->dump( $_POST );

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

    if ( isset( $_POST['opslaan'] ) )
    {
        $validateOk = 0;
        try
        {
            $setVar = new SetVariable();
            $validateOk += $setVar->name( $evenementId )
                ->validator( v::alwaysValid() )
                ->required( true )
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
                $opties = EvenementHeeftOptieQuery::create()->filterByEvenementId( $evenementId )->find();
                $opties->delete();
                $logger->debug( "Opties verwijderd" );

                $optieArray = array();
                if ( isset( $_POST['gekozen'] ))
                {
                    $optieArray = $_POST['gekozen'];
                }

                $volgorde = 1;
                foreach ( $optieArray as $key => $value )
                {
                    $optie = new EvenementHeeftOptie();
                    $optie->setEvenementId( $evenementId );
                    $optie->setOptieId( $value );
                    $optie->setVolgorde( $volgorde );
                    $optie->setGemaaktDoor( $autorisatie->getUserId() );
                    $optie->setGewijzigdDoor( $autorisatie->getUserId() );
                    $optie->save();
                    $volgorde += 1;
                }

                $con->commit();
                $logger->debug( "Opties opgeslagen" );
                //$con->rollback();
                alert( 'Optiegegevens zijn opgeslagen.' );
                $status = 0;
                header( "Refresh:0" );
                exit;
            }
            catch ( \Exception $e )
            {
                $con->rollback();
                echo $e->getMessage() . "<br/><br/>";
                $logger->error( "Unhandled exception bij opslaan opties" );
                $logger->errordump( $e );
                $signalError = true;
                $statusRegel = 'Probleem met opslaan gegevens, details: <br/>' . $e;
            }
        }
    }
    elseif ( isset( $_POST['beschikbaar'] ) )
    {
        $evt = $_POST['beschikbaar'];
        // header( "Location:evenement_opties.php?evt=".$evt );
        header( 'Location: ' . $_SERVER['REQUEST_URI'] . '?evt=' . $evt );
        exit;
    }
}

// DEEL 3
$alleEvenementen = EvenementQuery::create()
    ->filterByStatus( EVENEMENT_STATUS_OPEN )
    ->_or()
    ->filterByStatus( EVENEMENT_STATUS_WACHT )
    ->find();

$vandaag = new DateTime( date( "Y-m-d" ) );

foreach ( $alleEvenementen as $event )
{
    $eindDatum = new DateTime( $event->getDatumEind()->format( 'Y-m-d' ) );
    if ( $vandaag <= $eindDatum )
    {
        //$beschikbaarLijst[$optie->getNaam()] = $optie->getNaam();
        $evenementenLijst[$event->getId()] = $event->getNaam();
    }
}

$smarty->assign( 'evenementenLijst', $evenementenLijst );

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'evenementNaam', $evenementNaam );
$smarty->assign( 'evenementId', $evenementId );
$smarty->assign( 'beschikbaarLijst', $beschikbaarLijst );
$smarty->assign( 'gekozenLijst', $gekozenLijst );

$smarty->assign( 'isError', $signalError );
$smarty->assign( 'statusRegel', $statusRegel );

$smarty->assign( 'loggedin', $autorisatie->getUserId() );
$smarty->display( 'evenement_opties_koppelen.tpl' );
