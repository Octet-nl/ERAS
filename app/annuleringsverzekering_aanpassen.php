<?php
/**
 * System      ERAS
 * Module      Annuleringsverzekering
 * Doel        Aanpassen parameters voor annuleringsverzekering
 * Auteur      Sander Kuiper
 * Datum       14-01-2020
 * License     MIT
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

// Propel use
use \fb_model\fb_model\AnnuleringsverzekeringQuery;

// Validator
use Respect\Validation\Validator as v;

// Session autorisatie
$sessie = new Sessie();
$autorisatie = new Autorisatie();
$autorisatie->setNotAuth( "login.php" );
$autorisatie->validate( AUTORISATIE_STATUS_ADMINISTRATOR );

// Variabelen definieren
$afsluitkostenGeen = $percentageGeen = $btwGeen = $afsluitkostenGewoon = $percentageGewoon = $btwGewoon = $afsluitkostenAllrisk =
$percentageAllrisk = $btwAllrisk = $geenAfsluitErr = $geenPercentageErr = $geenBtwErr = $gewoonAfsluitErr = $gewoonPercentageErr =
$gewoonBtwErr = $allriskAfsluitErr = $allriskPercentageErr = $allriskBtwErr = "";

$doctitle = 'Annuleringsverzekering aanpassen';
$actionForm = 'annuleringsverzekering_aanpassen.php';

//Database get info
// Ophalen afsluitkosten, percentage, btw (Geen)
$annuleringGeen = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_GEEN );
$afsluitkostenGeen = $annuleringGeen->getAfsluitkosten();
$percentageGeen = $annuleringGeen->getPercentage();
$btwGeen = $annuleringGeen->getBtw();

// Ophalen afsluitkosten, percentage, btw (gewoon)
$annuleringGewoon = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_GEWOON );
$afsluitkostenGewoon = $annuleringGewoon->getAfsluitkosten();
$percentageGewoon = $annuleringGewoon->getPercentage();
$btwGewoon = $annuleringGewoon->getBtw();

// Ophalen afsluitkosten, percentage, btw (Allrisk)
$annuleringAllrisk = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_ALLRISK );
$afsluitkostenAllrisk = $annuleringAllrisk->getAfsluitkosten();
$percentageAllrisk = $annuleringAllrisk->getPercentage();
$btwAllrisk = $annuleringAllrisk->getBtw();

// Geen afsluitkosten, percentage, btw opslaan
if ( $_SERVER["REQUEST_METHOD"] == "POST" )
{
    if ( isset( $_POST['terug'] ) )
    {
        header( "Location:index.php" );
        exit;
    }

    if ( isset( $_POST['opslaanGeen'] ) )
    {
        $validateOk = 0;
        try
        {
            $setVar = new SetVariable();

            $validateOk += $setVar->name( $afsluitkostenGeen )
                ->onerror( $geenAfsluitErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 15 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $percentageGeen )
                ->onerror( $geenPercentageErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 1 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $btwGeen )
                ->onerror( $geenBtwErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 50 ) )
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
            $annuleringGeenOpslaan = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_GEEN );
            $annuleringGeenOpslaan->setAfsluitkosten( $afsluitkostenGeen );
            $annuleringGeenOpslaan->setPercentage( $percentageGeen );
            $annuleringGeenOpslaan->setBtw( $btwGeen );
            $annuleringGeenOpslaan->setGewijzigdDoor( $autorisatie->getUserId() );
            $annuleringGeenOpslaan->save();
        }
    }

    // Gewone afsluitkosten, percentage, btw checken en opslaan
    if ( isset( $_POST['opslaanGewoon'] ) )
    {
        $validateOk = 0;
        try
        {
            $setVar = new SetVariable();

            $validateOk += $setVar->name( $afsluitkostenGewoon )
                ->onerror( $gewoonAfsluitErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 15 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $percentageGewoon )
                ->onerror( $gewoonPercentageErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 1 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $btwGewoon )
                ->onerror( $gewoonBtwErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 50 ) )
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
            $annuleringGewoonOpslaan = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_GEWOON );
            $annuleringGewoonOpslaan->setAfsluitkosten( $afsluitkostenGewoon );
            $annuleringGewoonOpslaan->setPercentage( $percentageGewoon );
            $annuleringGewoonOpslaan->setBtw( $btwGewoon );
            $annuleringGewoonOpslaan->setGewijzigdDoor( $autorisatie->getUserId() );
            $annuleringGewoonOpslaan->save();
        }
    }

    // Allrisk afsluitkosten, percentage, btw checken en opslaan
    if ( isset( $_POST['opslaanAllrisk'] ) )
    {

        $validateOk = 0;
        try
        {
            $setVar = new SetVariable();

            $validateOk += $setVar->name( $afsluitkostenAllrisk )
                ->onerror( $allriskAfsluitErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 15 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $percentageAllrisk )
                ->onerror( $allriskPercentageErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 1 ) )
                ->required( true )
                ->go();

            $validateOk += $setVar->name( $btwAllrisk )
                ->onerror( $allriskBtwErr )
                ->formatter( 'prijs' )
                ->validator( v::numericVal()->between( 0, 50 ) )
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
            $annuleringAllriskOpslaan = AnnuleringsverzekeringQuery::create()->findOneByCode( ANNULERINGSVERZEKERING_ALLRISK );
            $annuleringAllriskOpslaan->setAfsluitkosten( $afsluitkostenAllrisk );
            $annuleringAllriskOpslaan->setPercentage( $percentageAllrisk );
            $annuleringAllriskOpslaan->setBtw( $btwAllrisk );
            $annuleringAllriskOpslaan->setGewijzigdDoor( $autorisatie->getUserId() );
            $annuleringAllriskOpslaan->save();
        }
    }
}

// Smarty assign
$smarty->assign( 'geenAfsluitkosten', $afsluitkostenGeen );
$smarty->assign( 'geenPercentage', $percentageGeen );
$smarty->assign( 'geenBtw', $btwGeen );
$smarty->assign( 'afsluitkostenGewoon', $afsluitkostenGewoon );
$smarty->assign( 'percentageGewoon', $percentageGewoon );
$smarty->assign( 'btwGewoon', $btwGewoon );
$smarty->assign( 'afsluitkostenAllrisk', $afsluitkostenAllrisk );
$smarty->assign( 'percentageAllrisk', $percentageAllrisk );
$smarty->assign( 'btwAllrisk', $btwAllrisk );
$smarty->assign( 'geenAfsluitErr', $geenAfsluitErr );
$smarty->assign( 'geenPercentageErr', $geenPercentageErr );
$smarty->assign( 'geenBtwErr', $geenBtwErr );
$smarty->assign( 'gewoonAfsluitErr', $gewoonAfsluitErr );
$smarty->assign( 'gewoonPercentageErr', $gewoonPercentageErr );
$smarty->assign( 'gewoonBtwErr', $gewoonBtwErr );
$smarty->assign( 'allriskAfsluitErr', $allriskAfsluitErr );
$smarty->assign( 'allriskPercentageErr', $allriskPercentageErr );
$smarty->assign( 'allriskBtwErr', $allriskBtwErr );
$smarty->assign( 'actionForm', $actionForm );
$smarty->assign( 'doctitle', $doctitle );
// Inladen Smarty
$smarty->display( 'annuleringsverzekering_aanpassen.tpl' );
