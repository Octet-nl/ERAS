<?php
/**
 * System      ERAS
 * Module      Session status
 * Doel        Vullen session met statusarray (voor wijzigen inschrijving/deelnemer)
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       30-10-2019
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
//require_once 'utilities.php';

use fb_model\fb_model\Base\DeelnemerQuery;
use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\PersoonQuery;
use fb_model\fb_model\GebruikerQuery;
use fb_model\fb_model\EvenementQuery;

function setSessieVariabelen( $id, $userid )
{
    $logger = new Logger();
    $logger->level( LOGLEVEL );

    $sessieVariabelen = null;

    $inschrijving = InschrijvingQuery::create()->findPk( $id );
    if ( $inschrijving == null )
    {
        $logger->error( "Inschrijving opvragen mislukt, id=" . $id );
        return false;
    }

    $gebruiker = GebruikerQuery::create()->filterByUserId( $userid )->findOne(  );

    if ( $gebruiker->getRol() < AUTORISATIE_STATUS_MEDEWERKER && $gebruiker->getPersoonId() != $inschrijving->getContactPersoonId() )
    {
        $logger->security( "Gebruiker " .$userid. " is niet gemachtigd om inschrijving nr. " .$id. " te bekijken.");
        return false;
    }

    $evt = $inschrijving->getEvenementId();
    $uitgegeven = InschrijvingQuery::create()
        ->filterByEvenementId( $evt )
        ->count();

    $evenement = EvenementQuery::create()->findPk( $evt );
    if ( $evenement == null )
    {
        $logger->error( "Evenement opvragen mislukt, id=" . $evt );
        return false;
    }

    $contactpersoonId = $inschrijving->getContactPersoonId(  );

    $persoon = PersoonQuery::create()->findPK( $contactpersoonId );
    if ( $persoon == null )
    {
        $logger->error( "Persoon opvragen mislukt, id=" . $contactpersoonId );
        return false;
    }

    $isDeelnemer = OPTIE_KEUZE_NEE;
    $deelnemer = DeelnemerQuery::create()->filterByInschrijvingId( $id )->filterByPersoonId( $contactpersoonId )->findPk( $id );
    if ( $deelnemer != null )
    {
        $logger->debug( "Deelnemer met inschrijvingsID " . $id . " en contactpersoonId " . $contactpersoonId . " is gevonden");
        $isDeelnemer = OPTIE_KEUZE_JA;
    }
    else
    {
        $logger->debug( "Deelnemer met inschrijvingsID " . $id . " en contactpersoonId " . $contactpersoonId . " is NIET gevonden");
    }

    // Extra gegevens toevoegen aan sessievariabele "inschrijving"
    if ( isset( $_SESSION['inschrijving'] ) )
    {
        $sessieVariabelen = $_SESSION['inschrijving']; 
    }

    //ToDo: kan deze vraag (isset) weg? Lijkt me onnodig en werkt niet goed als er al een sessie is
    //Nu weggehaald i.v.m. ticket FS#123
    //if ( !isset( $sessieVariabelen["evenement_id"] ) )
    {
        $sessieVariabelen["evenement_id"] = $evt;
        $sessieVariabelen["evenement_naam"] = $evenement->getNaam();
        $sessieVariabelen["max_deelnemers"] = $evenement->getMaxDeelnemers();
        $sessieVariabelen["aantal_beschikbaar"] = $evenement->getMaxDeelnemers() - $uitgegeven;
        $sessieVariabelen["prijs"] = $evenement->getPrijs();
        $sessieVariabelen["extra_contact"] = $evenement->getExtraContactGegevens();
        $sessieVariabelen["extra_deelnemer"] = $evenement->getExtraDeelnemerGegevens();
    }
    $sessieVariabelen["inschrijving_id"] = $inschrijving->getId();
    $sessieVariabelen["inschrijving_status"] = $inschrijving->getStatus();
    $sessieVariabelen["contactpersoon_id"] = $contactpersoonId;
    $sessieVariabelen["contactpersoon_naam"] = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
    $sessieVariabelen["contactpersoon_email"] = $persoon->getEmail();
    $sessieVariabelen["is_deelnemer"] = $isDeelnemer;
    $_SESSION['inschrijving'] = $sessieVariabelen;

    return true;
}
