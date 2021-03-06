<?php
/**
 * System      ERAS
 * Module      Inschrijving bevestiging
 * Doel        Gedetailleerde bevestigings PDF voor de inschrijving
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       20-05-2020
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

use fb_model\fb_model\BetaalwijzeQuery;
use fb_model\fb_model\DeelnemerHeeftOptieQuery;
use fb_model\fb_model\DeelnemerQuery;
use fb_model\fb_model\EvenementQuery;
use fb_model\fb_model\InschrijvingHeeftOptieQuery;
use fb_model\fb_model\InschrijvingQuery;
use fb_model\fb_model\OptieQuery;
use fb_model\fb_model\PersoonQuery;
use fb_model\fb_model\VoucherQuery;
use fb_model\fb_model\MailinglistQuery;
use fb_model\fb_model\CategorieQuery;

class InschrijvingBevestiging
{
    private $inschrijfnummer = 0;
    private $logger = null;
    private $contactNaam = "";
    private $contactAanschrijving = "";
    private $contactAdres = "";
    private $contactWoonplaats = "";
    private $contactEmail = "";
    private $messageBody = "";
    private $ondersteRegels = "";
    private $totaalBedrag = "0.00";
    private $reedsBetaaldBedrag = "0.00";
    private $nogTeBetalenBedrag = "0.00";
    private $factuurArray = array();
    private $evenementNaam = "";
    private $betaalwijze = "";
    private $evenementDatum = "";
    private $aantalDeelnemers = 0;
    private $evenementPrijs = 0.00;
    private $errorTekst = "";

    public function __construct()
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }

    public function setInschrijfnummer( $iis )
    {
        $this->inschrijfnummer = $iis;
    }

    public function getContactNaam()
    {
        return $this->contactNaam;
    }

    public function getContactAanschrijving()
    {
        return $this->contactAanschrijving;
    }

    public function getContactAdres()
    {
        return $this->contactAdres;
    }

    public function getContactWoonplaats()
    {
        return $this->contactWoonplaats;
    }

    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    public function getErrorTekst()
    {
        return $this->errorTekst;
    }

    public function getMessageBody()
    {
        return $this->messageBody;
    }

    public function getOndersteRegels()
    {
        return $this->ondersteRegels;
    }

    public function getBetaalwijze()
    {
        return $this->betaalwijze;
    }

    public function getFactuurData()
    {
        return $this->factuurArray;
    }

    public function getEvenementNaam()
    {
        return $this->evenementNaam;
    }

    public function getEvenementDatum()
    {
        return $this->evenementDatum;
    }

    public function getEvenementPrijs()
    {
        return $this->evenementPrijs;
    }

    public function getAantalDeelnemers()
    {
        return $this->aantalDeelnemers;
    }

    public function getTotaalBedrag()
    {
        return $this->totaalBedrag;
    }

    public function getReedsBetaaldBedrag()
    {
        return rondNul( $this->reedsBetaaldBedrag );
    }

    public function getNogTeBetalenBedrag()
    {
        return rondNul( $this->nogTeBetalenBedrag );
    }

    public function go()
    {

        if ( $this->inschrijfnummer == 0 )
        {
            $this->logger->error( "Inschrijfnummer is niet gezet." );
            return null;
        }

        $inschrijving = InschrijvingQuery::create()->findPk( $this->inschrijfnummer );

        if ( $inschrijving == null )
        {
            $this->logger->error( "Inschrijfnummer " . $this->inschrijfnummer . " is niet gevonden." );
            $this->errorTekst = "Inschrijfnummer " . $this->inschrijfnummer . " is niet gevonden.";
            return null;
        }

        $ini = parse_ini_file( CONFIG_FILENAME, true );

        if ( $inschrijving->getStatus() != INSCHRIJVING_STATUS_DEFINITIEF )
        {
//            $this->logger->error( "Deze inschrijving (" . $this->inschrijfnummer . ") is niet definitief." );
            //            $this->errorTekst = "Deze inschrijving (" . $this->inschrijfnummer . ") is niet definitief.";
            //            return null;
        }

        $this->betaalwijze = $inschrijving->getBetaalwijze();
        $this->reedsBetaaldBedrag = $inschrijving->getReedsBetaald();
        $this->nogTeBetalenBedrag = $inschrijving->getNogTeBetalen();

        // Contactpersoon
        $contactPersoon = PersoonQuery::create()->findPk( $inschrijving->getContactPersoonId() );
        $this->contactNaam = $contactPersoon->getVoornaam() . " " . $contactPersoon->getTussenvoegsel() . " " . $contactPersoon->getAchternaam();
        $this->contactAdres = $contactPersoon->getStraat() . " " . $contactPersoon->getHuisnummer() . " " . $contactPersoon->getToevoeging();
        $this->contactWoonplaats = $contactPersoon->getPostcode() . " " . $contactPersoon->getWoonplaats();
        $this->contactEmail = $contactPersoon->getEmail();

        if ( $contactPersoon->getGeslacht() == GESLACHT_MAN )
        {
            $this->contactAanschrijving = "heer " . $contactPersoon->getTussenvoegsel() . " " . $contactPersoon->getAchternaam();
        }
        elseif ( $contactPersoon->getGeslacht() == GESLACHT_VROUW )
        {
            $this->contactAanschrijving = "mevrouw " . $contactPersoon->getTussenvoegsel() . " " . $contactPersoon->getAchternaam();
        }
        else
        {
            $this->contactAanschrijving = "mevrouw/mijnheer " . $contactPersoon->getTussenvoegsel() . " " . $contactPersoon->getAchternaam();
        }

        // Informatie over het evenement
        $evenement = EvenementQuery::create()->findPk( $inschrijving->getEvenementId() );
        $this->evenementNaam = $evenement->getNaam();
        $this->evenementId = $evenement->getId();

        $this->evenementDatum = $evenement->getDatumBegin( "d-m-Y" );
        if ( $evenement->getDatumEind() != $evenement->getDatumBegin() )
        {
            $this->evenementDatum .= " - " . $evenement->getDatumEind( "d-m-Y" );
        }

        $categorie = CategorieQuery::create()->filterByCode( $evenement->getCategorie() )->findOne();
        
        define( "TABEL_NORMAAL", "<table style='margin-left: 2em; font-family: sans-serif; font-size: 0.85em; width: 60%%; border-collapse: collapse;'>" );
        define( "TD_NORMAAL", "<td style='border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-color: #dddddd #444444; padding: 0.3em 0.3em 0.3em 0.3em;'>" );
        define( "TD_CENTER", "<td style='border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-color: #dddddd #444444; padding: 0.3em 0.3em 0.3em 0.3em;text-align: center;'>" );
        define( "TD_RIGHT", "<td style='border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-color: #dddddd #444444; padding: 0.3em 0.3em 0.3em 0.3em;text-align: right;'>" );
        define( "TH_NORMAAL", "<th style='padding: 0.44em 0.3em 0.44em 0.3em; background-color: lightgray; border-radius: 0.20em; color: black;'>");

        $this->messageBody = "<h4>Gegevens evenement</h4>";
        $this->messageBody .= "<br/><div><span style='border: 0.0625em solid; padding: 0.44em 0.3em 0.44em 0.3em; border-radius: 0.20em;'>Uw inschrijfnummer is: " . $this->inschrijfnummer . "</span></div><br/><br/>";

        $deelnemers = DeelnemerQuery::create()->filterByInschrijvingId( $this->inschrijfnummer )->find();
        $this->aantalDeelnemers = sizeof( $deelnemers );
 
        $this->evenementPrijs = $evenement->getPrijs();
        $totaalprijs = $this->aantalDeelnemers * $this->evenementPrijs;

        $this->messageBody .= TABEL_NORMAAL .
        "<tr>
          " . TH_NORMAAL . $ini['tabelkop']['evenement-kolom1'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['evenement-kolom2'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['evenement-kolom3'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['evenement-kolom4'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['evenement-kolom5'] . "</th>
        </tr>
        <tr>
          " . TD_NORMAAL . "" . $categorie->getNaam() . " \"" . $this->evenementNaam . "\"</td>
          " . TD_CENTER . "" . $this->evenementDatum . "</td>
          " . TD_CENTER . "" . $this->aantalDeelnemers . "</td>
          " . TD_RIGHT . "" . geldHtml( $evenement->getPrijs() ) . "</td>
          " . TD_RIGHT . "" . geldHtml( $totaalprijs ) . "</td>
        </tr>
        </table><br/>";

        $this->messageBody .= "<h4>Opties en bijzonderheden</h4>";

        $this->messageBody .= TABEL_NORMAAL .
        "<tr>
          " . TH_NORMAAL . $ini['tabelkop']['deelnemer-kolom1'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['deelnemer-kolom2'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['deelnemer-kolom3'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['deelnemer-kolom4'] . "</th>
          " . TH_NORMAAL . $ini['tabelkop']['deelnemer-kolom5'] . "</th>
        </tr>";

        foreach ( $deelnemers as $deelnemer )
        {
            $deelnemertotaal = 0;
            $persoon = PersoonQuery::create()->findPk( $deelnemer->getPersoonId() );

            $deelnemerNaam = $persoon->getVoornaam() . " " . $persoon->getTussenvoegsel() . " " . $persoon->getAchternaam();
            // Kolommen:
            // Deelnemer
            // Omschrijving
            // Aantal
            // à
            // Prijs
            
            try
            {
                $opties = OptieQuery::create()
                ->filterByPerDeelnemer( '1' )
                ->useEvenementHeeftOptieQuery()
                ->filterByEvenementId( $this->evenementId )
                ->orderByVolgorde()
                ->endUse()
                ->useDeelnemerHeeftOptieQuery()
                    ->filterByDeelnemerId( $deelnemer->getId() )
                ->endUse()
                ->orderByGroep()
                ->find();                
            }
            catch( Exception $ex)
            {
                $this->logger->error( "Exceptie bij opvragen deelnemeropties en volgorde daarvan" );
                $this->logger->errordump( $ex );
                alert( "Er is een probleem opgetreden." );
                exit;
            }

            $this->logger->debug( "Aantal deelnemer opties " . $opties->count() );
            
            if ( $opties->count() > 0 )
            {
                $this->logger->verbose( $opties );
                $bevestigingNaam = $deelnemerNaam;

                foreach ( $opties as $optie )
                {
                    $messageRegel = "<tr>" . TD_NORMAAL . "" . $bevestigingNaam . "</td>";
                    $bevestigingNaam = "";

                    $this->logger->debug( "Deelnemer optie " . $optie->getId() );

                    $deelnemerOptie = DeelnemerHeeftOptieQuery::create()
                        ->filterByDeelnemerId( $deelnemer->getId() )
                        ->filterByOptieId( $optie->getId() )
                        ->findOne();

                    $this->logger->verbose( $deelnemerOptie );

                    $omschrijving = "";
                    $aantal = "";
                    $a = "";
                    $prijs = "";
                    if ( $optie->getGroep() != "" )
                    {
                        if ( $optie->getPrijs() != 0 )
                        {
                            $regel = array( "deelnemer" => $deelnemerNaam, "naam" => $optie->getGroep(), "omschrijving" => $optie->getTekstVoor(), "aantal" => 1, "prijs" => $optie->getPrijs() );
                            array_push( $this->factuurArray, $regel );
                            $omschrijving = $optie->getGroep() . ": &emsp; " . $optie->getTekstVoor();
                            $a = geldHtml( $optie->getPrijs() );
                            $prijs = geldHtml( $optie->getPrijs() );
                            $aantal = "1";
                            $deelnemerNaam = "";
                        }
                        else
                        {
                            $omschrijving = $optie->getGroep() . ": &emsp; " . $optie->getTekstVoor();
                            if ( $deelnemerOptie->getWaarde() && $deelnemerOptie->getWaarde() != $optie->getId() )
                            {
                                $omschrijving .= " (" . $deelnemerOptie->getWaarde() . ")";
                            }
                        }
                        $totaalprijs += $optie->getPrijs();
                        $deelnemertotaal += $optie->getPrijs();
                    }
                    else
                    {
                        $omschrijving = $optie->getTekstVoor() . ": &emsp; " . $deelnemerOptie->getWaarde();
                        if ( $optie->getPrijs() != 0 )
                        {
                            if ( $optie->getOptieType() == OPTIETYPE_AANTAL )
                            {
                                if ( $deelnemerOptie->getWaarde() > 0 )
                                {
                                    $regel = array( "deelnemer" => $deelnemerNaam, "naam" => "", "omschrijving" => $optie->getTekstVoor(), "aantal" => $deelnemerOptie->getWaarde(), "prijs" => $optie->getPrijs() );
                                    array_push( $this->factuurArray, $regel );

                                    $a = geldHtml( $optie->getPrijs() );
                                    $aantal = $deelnemerOptie->getWaarde();
                                    $prijs = geldHtml( $optie->getPrijs() * $deelnemerOptie->getWaarde() );

                                    $totaalprijs += $optie->getPrijs() * $deelnemerOptie->getWaarde();
                                    $deelnemertotaal += $optie->getPrijs() * $deelnemerOptie->getWaarde();
                                    $deelnemerNaam = "";
                                }
                            }
                            else
                            {
                                if ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
                                {
                                    if ( $deelnemerOptie->getWaarde() == OPTIE_KEUZE_JA )
                                    {
                                        $regel = array( "deelnemer" => $deelnemerNaam, "naam" => $optie->getTekstVoor(), "omschrijving" => "ja", "aantal" => 1, "prijs" => $optie->getPrijs() );
                                        array_push( $this->factuurArray, $regel );
                                        $totaalprijs += $optie->getPrijs();
                                        $deelnemertotaal += $optie->getPrijs();
                                        $a = geldHtml( $optie->getPrijs() );
                                        $aantal = "1";
                                        $prijs = geldHtml( $optie->getPrijs() );
                                        $deelnemerNaam = "";
                                    }
                                }
                                else
                                {
                                    $a = geldHtml( $optie->getPrijs() );
                                    $aantal = "1";
                                    $prijs = geldHtml( $optie->getPrijs() );
                                    $totaalprijs += $optie->getPrijs();
                                    $deelnemertotaal += $optie->getPrijs();
                                }
                            }
                        }
                        else
                        {
                            $prijs .= geldHtml( $deelnemerOptie->getWaarde() );
                        }
                    }
                    $messageRegel .= TD_NORMAAL . $omschrijving . "</td>";
                    $messageRegel .= TD_CENTER . $aantal . "</td>";
                    $messageRegel .= TD_RIGHT . $a . "</td>";
                    $messageRegel .= TD_RIGHT . $prijs . "</td>";

                    $this->logger->debug("deelnemerregel: " . $messageRegel );
                    $this->messageBody .= $messageRegel;
                    $this->messageBody .= "</tr>";
                }

                if ( $this->aantalDeelnemers > 1 )
                {
                    $messageRegel = "<tr>" . TD_NORMAAL . "</td>";
                    $messageRegel .= "<td style='font-size: 0.8em;border-bottom: 1px solid; border-color: #dddddd #444444;'><u>Deze deelnemer:</u><br/>Totaalprijs opties: " . geldHtml($deelnemertotaal) . "
                    ,<br/>Inclusief evenementprijs: " . geldHtml($this->evenementPrijs+$deelnemertotaal) . "</td>";
                    $messageRegel .= TD_NORMAAL . "</td>";
                    $messageRegel .= TD_NORMAAL . "</td>";
                    $messageRegel .= TD_NORMAAL . "</td>";
                    $this->messageBody .= $messageRegel;
                    $this->messageBody .= "</tr>";
                }
            }
        }

        // Inschrijvingsopties
        try
        {
            $opties = OptieQuery::create()
              ->filterByPerDeelnemer( '0' )
              ->useEvenementHeeftOptieQuery()
              ->filterByEvenementId( $this->evenementId )
              ->orderByVolgorde()
              ->endUse()
              ->useInschrijvingHeeftOptieQuery()
                  ->filterByInschrijvingId( $this->inschrijfnummer )
              ->endUse()
              ->orderByGroep()
              ->find();                
        }
        catch( Exception $ex)
        {
            $this->logger->error( "Exceptie bij opvragen deelnemeropties en volgorde daarvan" );
            $this->logger->errordump( $ex );
            exit;
        }

        $this->logger->debug( "Aantal inschrijving opties " . $opties->count() );

        if ( $opties->count() > 0 )
        {
            $deelnemerNaam = "Algemeen";

            foreach ( $opties as $optie )
            {
                $messageRegel = "<tr>";
                $messageRegel .= TD_NORMAAL . $deelnemerNaam . "</td>";
                $deelnemerNaam = "";

                $omschrijving = "";
                $aantal = "";
                $a = "";
                $prijs = "";

                $this->logger->debug( "Inschrijvings optie " . $optie->getId() );

                $inschrijvingsOptie = InschrijvingHeeftOptieQuery::create()
                    ->filterByInschrijvingId( $this->inschrijfnummer )
                    ->filterByOptieId( $optie->getId( ) )
                    ->findOne();

                $this->logger->debug( "Inschrijvings optie " . $optie->getId() . 
                                      " " . $optie->getTekstVoor() . 
                                      ", groep: " . $optie->getGroep() .
                                      ", type: " . $optie->getOptieType() .
                                      ", waarde " . $inschrijvingsOptie->getWaarde() );                                     
        
                if ( $optie->getGroep() != "" )
                {
                    if ( $optie->getPrijs() != 0 )
                    {
                        $regel = array( "deelnemer" => "Algemeen", "naam" => $optie->getGroep(), "omschrijving" => $optie->getTekstVoor(), "aantal" => 1, "prijs" => $optie->getPrijs() );
                        array_push( $this->factuurArray, $regel );
                    }
                    $omschrijving = $optie->getGroep() . ": " . $optie->getTekstVoor();
                    if ( $inschrijvingsOptie->getWaarde() && ($inschrijvingsOptie->getWaarde() != $optie->getId()) )
                    {
                        $omschrijving .= " (" . $inschrijvingsOptie->getWaarde() . ")";
                    }

                    $prijs = $optie->getPrijs();
                    $totaalprijs += $optie->getPrijs();
                }
                else
                {
                    $omschrijving = $optie->getTekstVoor() . ": &emsp; " . $inschrijvingsOptie->getWaarde();
                    if ( $optie->getPrijs() != 0 )
                    {
                        if ( $optie->getOptieType() == OPTIETYPE_AANTAL )
                        {
                            if ( $inschrijvingsOptie->getWaarde() > 0 )
                            {
                                $regel = array( "deelnemer" => "Algemeen", "naam" => $optie->getTekstVoor(), "omschrijving" => "", "aantal" => $inschrijvingsOptie->getWaarde(), "prijs" => $optie->getPrijs() );
                                array_push( $this->factuurArray, $regel );

                                $a = geldHtml( $optie->getPrijs() );
                                $aantal = $inschrijvingsOptie->getWaarde();
                                $prijs = geldHtml( $optie->getPrijs() * $inschrijvingsOptie->getWaarde());
                                $totaalprijs += $optie->getPrijs() * $inschrijvingsOptie->getWaarde();
                            }
                        }
                        else
                        {
                            if ( $optie->getOptieType() == OPTIETYPE_KEUZE_JA_NEE )
                            {
                                if ( $inschrijvingsOptie->getWaarde() == OPTIE_KEUZE_JA )
                                {
                                    $regel = array( "deelnemer" => "Algemeen", "naam" => "", "omschrijving" => $optie->getTekstVoor(), "aantal" => "1", "prijs" => $optie->getPrijs() );
                                    array_push( $this->factuurArray, $regel );
                                    $totaalprijs += $optie->getPrijs();
                                }
                            }
                            else
                            {
                                $totaalprijs += $optie->getPrijs();
                            }

                            $prijs = geldHtml( $optie->getPrijs() );
                        }
                    }
                }
                $messageRegel .= TD_NORMAAL . $omschrijving . "</td>";
                $messageRegel .= TD_CENTER . $aantal . "</td>";
                $messageRegel .= TD_RIGHT . $a . "</td>";
                $messageRegel .= TD_RIGHT . $prijs . "</td>";

                $this->logger->debug("inschrijvingsregel: " . $messageRegel );
                $this->messageBody .= $messageRegel;
                $this->messageBody .= "</tr>";
            }
        }
        $this->messageBody .= "</table><br/>";

        $this->messageBody .= "<h4>Betaling</h4>";

        $this->messageBody .= TABEL_NORMAAL .
        "<tr>" .
          TH_NORMAAL . "Omschrijving</th>" .
          TH_NORMAAL . "Bedrag</th>
        </tr>";

        $messageRegel = "<tr>" . TD_NORMAAL . "<strong>Subtotaal:</strong></td>";
        $messageRegel .= TD_RIGHT . geldHtml( $totaalprijs ) . "</td></tr>";
        $this->messageBody .= $messageRegel;

        $betaling = $inschrijving->getBetaalwijze();
        $wijze = BetaalwijzeQuery::create()->filterByCode( $betaling )->findOne();

        if ( naarJaNee( $evenement->getAnnuleringsverzekering() ) == OPTIE_KEUZE_JA )
        {
            if ( $inschrijving->getAnnuleringsverzekering() == ANNULERINGSVERZEKERING_ALLRISK ||
                $inschrijving->getAnnuleringsverzekering() == ANNULERINGSVERZEKERING_GEWOON ||
                $inschrijving->getAnnuleringsverzekering() == ANNULERINGSVERZEKERING_GEEN )
            {
                require_once "annuleringsverzekering.php";
                $annuleringsverzekering = new AnnuleringsVerzekering();
                $avpremie = $annuleringsverzekering->bereken( $totaalprijs, $inschrijving->getAnnuleringsverzekering() );
                $totaalprijs += $avpremie;

                $messageRegel = "<tr>" . TD_NORMAAL . "Annuleringsverzekering: " . annuleringsverzekeringNaam( $inschrijving->getAnnuleringsverzekering() ) . ", premie:</td>";
                $messageRegel .= TD_RIGHT . geldHtml( $avpremie ) . "</td></tr>";
                $this->messageBody .= $messageRegel;
        
                if ( $inschrijving->getAnnuleringsverzekering() != ANNULERINGSVERZEKERING_GEEN )
                {
                    $regel = array( "deelnemer" => "Algemeen", "naam" => "Annuleringsverzekering", "omschrijving" => annuleringsverzekeringNaam( $inschrijving->getAnnuleringsverzekering() ), "aantal" => "1", "prijs" => $avpremie );
                    array_push( $this->factuurArray, $regel );
                }
            }
        }

        $tekstwijze = "";
        $messageRegel = "";
        if ( rondNul( $this->nogTeBetalenBedrag ) > 0 )
        {
            $naam = $wijze->getNaam();
            if ( $wijze->getCode() == BETAALWIJZE_INCASSO )
            {
                require_once "zegge_class.php";
                $zegge = new Zegge();
                $ini = parse_ini_file( CONFIG_FILENAME, true );
                $aantalTermijnen = $zegge->toWords( $ini['betaling']['incasso_termijnen'] );
                $naam = str_replace( "{aantal}", $aantalTermijnen, $naam );
            }
            $tekstwijze = "Betaalwijze: " . $naam;
        }
        if ( $wijze->getKosten() > 0 )
        {
            $naam = "";
            if ( $wijze->getCode() == BETAALWIJZE_INCASSO )
            {
                $naam = "Incassokosten:";
            }
            else if ( $wijze->getCode() == BETAALWIJZE_CONTANT )
            {
                $naam = "Kosten contante betaling:";
            }
            else if ( $wijze->getCode() == BETAALWIJZE_CREDITCARD )
            {
                $naam = "Kosten creditcard betaling:";
            }
            else if ( $wijze->getCode() == BETAALWIJZE_OVERSCHRIJVING )
            {
                $naam = "Kosten betaling per overschrijving:";
            }
            else if ( $wijze->getCode() == BETAALWIJZE_IDEAL )
            {
                $naam = "Kosten betaling per iDeal:";
            }
            else if ( $wijze->getCode() == BETAALWIJZE_VOUCHER )
            {
                $naam = "Kosten betaling per tegoedbon/voucher:";
            }
            $regel = array( "deelnemer" => "Algemeen", "naam" => $naam, "omschrijving" => "", "aantal" => "1", "prijs" => $wijze->getKosten() );
            array_push( $this->factuurArray, $regel );

            $totaalprijs += $wijze->getKosten();

            $messageRegel = "<tr>" . TD_NORMAAL . $tekstwijze . "<br/>" . $naam . "</td>";
            $messageRegel .= TD_RIGHT . geldHtml( $wijze->getKosten() ) . "</td></tr>";
            $this->messageBody .= $messageRegel;
            $messageRegel = "";
        }

        $messageRegel .= "<tr>" . TD_NORMAAL . "<strong>Totaalbedrag: </strong></td>";
        $messageRegel .= "" . TD_RIGHT . "<strong>" . geldHtml( $totaalprijs ) . "</strong></td></tr>";
        $this->messageBody .= $messageRegel;
        $messageRegel = "";

        $this->logger->verbose( $this->messageBody );

        if ( rondNul( $this->reedsBetaaldBedrag ) > 0 )
        {
            $messageRegel = "<tr>" . TD_NORMAAL . "U heeft reeds betaald:</td>";
            $messageRegel .= TD_RIGHT . geldHtml( $this->reedsBetaaldBedrag ) . "</td></tr>";
            $this->messageBody .= $messageRegel;
        }

        $temp = "";
        if ( $inschrijving->getVoucherId() > 0 )
        {
            // Betaald per voucher > 0, dan tegoedbon
            if ( $inschrijving->getBetaaldPerVoucher() > 0 )
            {
                $voucher = VoucherQuery::create()->findpk( $inschrijving->getVoucherId() );

                if ( $voucher->getVoucherType() == VOUCHERTYPE_VOUCHER )
                {
                    $temp = "<br/>U heeft met een tegoedbon/voucher betaald: " . geldHtml( $inschrijving->getBetaaldPerVoucher() ) . "<br/>";
                }
                elseif ( $voucher->getVoucherType() == VOUCHERTYPE_KORTING )
                {
                    $temp = "<br/>U heeft met een kortingsbon betaald: " . geldHtml( $inschrijving->getBetaaldPerVoucher() ) . "<br/>";
                }

                $waarde = $voucher->getRestWaarde( );
                if ( $voucher->getEmail() && $waarde > 0 )
                {
                    $temp .= "Op de voucher resteert nog een bedrag van " . geldHtml( $waarde ) . "<br/><br/>";
                }
            }
            else // Betaald per voucher == 0, dan kortingsbon
            {
                $voucher = VoucherQuery::create()->findpk( $inschrijving->getVoucherId() );
                $waarde = $voucher->getRestWaarde( );
                $type = $voucher->getVoucherType();
                if ( $type == VOUCHERTYPE_KORTING )
                {
                    $temp = "<br/>Korting: " . geldHtml( $waarde ) . "<br/>";
                    $regel = array( "deelnemer" => "Algemeen", "naam" => "Korting", "omschrijving" => "", "aantal" => 1, "prijs" => $waarde );
                    array_push( $this->factuurArray, $regel );
                }
                else
                {
                    $this->logger->error( "Flow error. Geen bedrag betaald per voucher en ook geen kortingsbon" );
                }
            }
            if ( $temp != "" )
            {
                $messageRegel = "<tr>" . TD_NORMAAL . "" . $temp . "</td>";
                $messageRegel .= TD_NORMAAL . "</td></tr>";
                $this->messageBody .= $messageRegel;
            }
        }

        if ( $this->nogTeBetalenBedrag > 0 )
        {
            $messageRegel = "<tr>" . TD_NORMAAL . "<strong>U moet nog betalen:</strong>:</td>";
            $messageRegel .= "" . TD_RIGHT . "<strong>" . geldHtml( $this->nogTeBetalenBedrag ) . "</strong></td></tr>";
            $this->messageBody .= $messageRegel;
        }
        else
        {
            $messageRegel = "<tr>" . TD_NORMAAL . "Het volledige bedrag is voldaan</td>";
            $messageRegel .= "" . TD_RIGHT . "</td></tr>";
            $this->messageBody .= $messageRegel;
        }

        $this->messageBody .= "</table><br/>";

        if ( $this->nogTeBetalenBedrag > 0 )
        {
            //$this->messageBody .= "<u></u><br/><br/>";

            if( $betaling == BETAALWIJZE_INCASSO )
            {
                $incassotekst = $ini['betaling']['incasso_tekst'];
                require_once "zegge_class.php";
                $zegge = new Zegge();
                $ini = parse_ini_file( CONFIG_FILENAME, true );
                $aantalTermijnen = $zegge->toWords( $ini['betaling']['incasso_termijnen'] );
                $incassotekst = str_replace( "{aantal}", $aantalTermijnen, $incassotekst );
                $this->messageBody .= $incassotekst;
            } 
            else if( $betaling == BETAALWIJZE_CONTANT )
            {
                $this->messageBody .= $ini['betaling']['contant_tekst'];
            } 
            else 
            {
                $this->messageBody .= $ini['betaling']['voorwaarden'];
            }
        }
        else
        {
            $verschil = $inschrijving->getTotaalBedrag() - $this->reedsBetaaldBedrag;
            if ( $verschil < 0 )
            {
                $this->messageBody .= "Neem a.u.b. contact met ons op over het teveel betaalde bedrag van " . geldHtml( 0-$verschil ) . "<br/>";
            }
        }

        // Magic om de huidige URL te vinden
        $requestUri = substr( $_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$requestUri}";

        $inschrijver = MailinglistQuery::create()
                    ->filterByEvenementId( $this->evenementId )
                    ->filterByEmail( $this->contactEmail )
                    ->findOne();

        if ( $inschrijver != null )
        {
            $unsubscribeLink = $url . '/mailing_afmelden.php?mail=' . $inschrijver->getEmail() . "&code=" . $inschrijver->getCode();
            $adresRegel = '<div>' . $ini['organisatie']['adresregel'] . '</div>';
            $ondersteRegels = '<br/><div align="center" style="font-size:0.8em;">U heeft zich aangemeld voor onze nieuwsbrief, u kunt zich <a href="' . $unsubscribeLink . '">hier</a> afmelden.<br/>' . $adresRegel . '</div>';
        }
        else
        {
            $adresRegel = '<div>' . $ini['organisatie']['adresregel'] . '</div>';
            $ondersteRegels = '<br/><div align="center" style="font-size:0.8em;"><br/>' . $adresRegel . '</div>';
        }

        $this->ondersteRegels =  $ondersteRegels;

        //////////////////////////////////////////////////////
        // Controle of de nu berekende totaalprijs gelijk is aan wat de website berekend heeft.
        // Staat wel heel slordig als de klant op z'n factuur een ander totaal ziet dan wat wij rekenen.
        //////////////////////////////////////////////////////
        if ( number_format( $totaalprijs, 2 ) != number_format( $inschrijving->getTotaalbedrag(), 2 ) )
        {
            $this->logger->error( "Berekeningsfout bij opstellen factuur. Voor factuur berekende prijs = " . geldAnsi( $totaalprijs ) . ", prijs bij inschrijving = " . geldAnsi( $inschrijving->getTotaalbedrag() ) );
            $this->logger->error( "Totaalprijs ruw = " . $totaalprijs . ", prijs bij inschrijving ruw = " . $inschrijving->getTotaalbedrag() );
            $this->logger->error( $this->messageBody );

            $this->errorTekst = "Er is een fout opgetreden bij het opstellen van uw factuur. Neem a.u.b. contact met ons op.";
            return null;
        }

        $this->totaalBedrag = number_format( $inschrijving->getTotaalbedrag(), 2, ",", "" );

        // Maak de inschrijving definitief.
        // $inschrijving->setStatus( INSCHRIJVING_STATUS_DEFINITIEF );
        // $inschrijving->save();

        return 1;
    }

}
