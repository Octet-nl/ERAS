<?php
/**
 * System      Inschrijvingen
 * Module      Lijst met evenementen in status WACHTEN
 * Doel        Keuzelijst, overzicht van evenementen in wachtstatus voor testdoeleinden
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       16-09-2020
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

$doctitle = "Evenement testen: ";

// https://www.smarty.net/docs/en/
$smarty = new Smarty();
$smarty->setTemplateDir( 'smarty/templates' );
$smarty->setCompileDir( 'smarty/templates_c' );
$smarty->setCacheDir( 'smarty/cache' );
$smarty->setConfigDir( 'smarty/configs' );

use \fb_model\fb_model\EvenementQuery;

// Defineer variabelen voor evenement
$evenement_naam = $korteOmschrijving = $langeOmschrijving = $datumBegin = $datumEind = $prijs = "";
$maxDeelnemers = $annuleringsverzekering = $id = $opslaan = "";
$evt = $sum = 0;
$status = 0;

$logger = new Logger();
$logger->level( LOGLEVEL );

$evenementen_lijst = array();

$doctitle = "Testen evenement: ";

$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_SUPERVISOR );

// DEEL 1
// De GET method wordt alleen getriggerd als dit script wordt aangeroepen met de ?evt= parameter,
// Voorbeeld: http://www.mijnsite.com/evenement?evt=234
// Is dat het geval, dan wordt dat in dit script afgehandeld als een wijziging van evenement 234.
// Wordt de ?id= parameter niet opgegeven dan gaat het om een nieuw evenement en wordt
// in eerste instantie alleen DEEL 3 hieronder (het tonen van de template) uitgevoerd.
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    // Bestaande inschrijvingsgegevens verwijderen voordat een nieuwe wordt opgevoerd.
    unset( $_SESSION['inschrijving'] );

    $systeem = new Sysdb( true );

    $evenementen = EvenementQuery::create()
                   ->filterByStatus( EVENEMENT_STATUS_WACHT )
                   ->find();

    if ( $evenementen == null )
    {
        alert( "Er zijn geen evenementen met status WACHTEN." );
        exit;
    }

    foreach ( $evenementen as $evenement )
    {
        $evt_lijst = array();
        $evt_lijst["id"] = $evenement->getId();
        $evt_lijst["naam"] = $evenement->getNaam();
        $evt_lijst["categorie"] = $evenement->getCategorie();
        $evt_lijst["korteOmschrijving"] = $evenement->getKorteOmschrijving();
        $evt_lijst["langeOmschrijving"] = $evenement->getLangeOmschrijving();
        $evt_lijst["datumBegin"] = $evenement->getDatumBegin()->format( 'd-m-Y' );
        $evt_lijst["datumEind"] = $evenement->getDatumEind()->format( 'd-m-Y' );
        $evt_lijst["prijs"] = $evenement->getPrijs();
        $evt_lijst["maxDeelnemers"] = $evenement->getMaxDeelnemers();
        $evt_lijst["status"] = $evenement->getStatus();
        $evt_lijst["beschikbaar"] = $evenement->getMaxDeelnemers();

        array_push( $evenementen_lijst, $evt_lijst );
    }
}

// Na drukken op de "inschrijven" knop
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    try
    {
        $setVar = new SetVariable();
        $validateOk += $setVar->name( $opslaan )
            ->go();
    }
    catch ( Exception $ex )
    {
        $logger->error( "Unhandled exception in SetVariable" );
        $logger->errordump( $ex );
        $validateOk = 999;
    }

    //header( "Location:registreer.php?evt=".$opslaan );
    header( "Location:evenement_testen_2.php?evt=" . $opslaan );
}

$disclaimer = '<h4>Let op: Deze toepassing dient om evenementen te testen voordat ze "live" gaan.<br/>Hier worden alleen evenementen getoond met status "wachten".<br/>De testgevallen worden wel gewoon in de database opgeslagen, dus maak het niet te bont!</h4>';

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'disclaimer', $disclaimer );
$smarty->assign( 'statusGeannuleerd', EVENEMENT_STATUS_GEANNULEERD );
$smarty->assign( 'Evenementen', $evenementen_lijst );

$smarty->display( 'evenementen_lijst.tpl' );
