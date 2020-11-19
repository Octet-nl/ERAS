<?php
/**
 * System      ERAS
 * Module      Persoonsgegevens
 * Doel        Persoonsgegevens beheerclass
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       01-01-2020
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

$inactief = false;

use Respect\Validation\Validator as v;
use \fb_model\fb_model\Persoon;
use \fb_model\fb_model\PersoonQuery;

class Persoonsgegevens
{
    private $logger = null;
    private $persoon = null;
    private $creator = "";
    private $extraGegevens = 5;
    private $all = 0;

    private $id = null;
    private $voornaam = "";
    private $straat = "";
    private $huisnummer = "";
    private $postcode = "";
    private $woonplaats = "";
    private $email = "";
    private $telefoonnummer = "";
    private $achternaam = "";
    private $tussenvoegsel = "";
    private $geslacht = "";
    private $geboortedatum = "";
    private $landnaam = "";
    private $landnaamErr = "";
    private $huisnummer_toevoeging = "";
    private $voornaamErr = "";
    private $straatErr = "";
    private $huisnummerErr = "";
    private $postcodeErr = "";
    private $woonplaatsErr = "";
    private $emailErr = "";
    private $telefoonnummerErr = "";
    private $achternaamErr = "";
    private $tussenvoegselErr = "";
    private $geslachtErr = "";
    private $geboortedatumErr = "";
    private $huisnummer_toevoegingErr = "";
    private $validateOk = 0;
    private $userid = "";

    public function __construct( $userid )
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
        $this->userid = $userid;
    }

    public function load( $id )
    {
        if ( $id != null )
        {
            $this->id = $id;
            $this->persoon = PersoonQuery::create()->findPK( $id );
            if ( $this->persoon != null )
            {
                $this->voornaam = $this->persoon->getVoornaam();
                $this->tussenvoegsel = $this->persoon->getTussenvoegsel();
                $this->achternaam = $this->persoon->getAchternaam();
                $this->voornaam = $this->persoon->getVoornaam();
                $this->straat = $this->persoon->getStraat();
                $this->huisnummer = $this->persoon->getHuisnummer();
                $this->huisnummer_toevoeging = $this->persoon->getToevoeging();
                $this->postcode = $this->persoon->getPostcode();
                $this->woonplaats = $this->persoon->getWoonplaats();
                $this->landnaam = $this->persoon->getLandnaam();
                $temp = $this->persoon->getGeboorteDatum();
                if ( $temp != null )
                {
                    $this->geboortedatum = $temp->format( 'd-m-Y' );
                }
                $this->geslacht = $this->persoon->getGeslacht();
                $this->email = $this->persoon->getEmail();
                $this->telefoonnummer = $this->persoon->getTelefoonnummer();
                $this->readonly = "readonly";
                $this->logger->debug( "Bestaand persoon gevonden, id=" . $id );
                return $this->persoon;
            }
            else
            {
                $this->logger->info( "persoon " . $id . " is niet gevonden." );
                $this->validatiemelding = "persoon " . $id . " is niet gevonden.";
            }
        }
        return null;
    }

    function new ()
    {
        $this->logger->debug( "Nieuw persoon" );
        $this->persoon = new Persoon();
        $this->persoon->setGemaaktDoor( $this->userid );
        $this->persoon->setGewijzigdDoor( $this->userid );
        $this->id = $this->persoon->getId();
    }

    public function validate()
    {
        /////////////////////////////////////////////////
        // Dit is de validatie van de persoonsgegevens
        /////////////////////////////////////////////////
        //use Respect\Validation\Validator as v;

        $this->logger->dump( $_POST );

        if ( isset( $_POST['id'] ) )
        {
            $this->id = $_POST['id'];
        }

        $setVar = new SetVariable();
        $this->validateOk = 0;
        $req = false;

        $toegestaneTekens = "áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ '";

        // POST variabelen met validatie
        $this->validateOk += $setVar->name( $this->voornaam, get_object_vars( $this ) )
            ->onerror( $this->voornaamErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 64 ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->tussenvoegsel, get_object_vars( $this ) )
            ->onerror( $this->tussenvoegselErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 24 ) )
            ->required( false )
            ->go();
        $this->validateOk += $setVar->name( $this->achternaam, get_object_vars( $this ) )
            ->onerror( $this->achternaamErr )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 200 ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->straat, get_object_vars( $this ) )
            ->onerror( $this->straatErr )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( $toegestaneTekens )->length( 1, 200 ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->huisnummer, get_object_vars( $this ) )
            ->onerror( $this->huisnummerErr )
            ->validator( v::number()->between( 1, 99999 ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->huisnummer_toevoeging, get_object_vars( $this ) )
            ->onerror( $this->huisnummer_toevoegingErr )
            ->validator( v::alwaysValid()->length( 0, 24 ) )
            ->required( false )
            ->go();
        $this->validateOk += $setVar->name( $this->postcode, get_object_vars( $this ) )
            ->onerror( $this->postcodeErr )
            ->formatter( 'postcode' )
            ->errormessage( "Postcodeformaat NL, BE, DE of GB" )
//            ->validator( v::alnum()->length( 1, 10 ) )
            ->validator( v::oneOf( v::postalCode( 'NL' ), v::postalCode( 'BE' ), v::postalCode( 'DE' ), v::postalCode( 'GB' ) ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->woonplaats, get_object_vars( $this ) )
            ->onerror( $this->woonplaatsErr )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ \'()' )->length( 1, 200 ) )
            ->required( true )
            ->go();
        $this->validateOk += $setVar->name( $this->landnaam, get_object_vars( $this ) )
            ->onerror( $this->landnaamErr )
            ->formatter( 'ucfirst' )
            ->validator( v::alpha( 'áéíóúäëïöüûâçñÁÉÍÓÚÄËÏÖÜÇÑÛÂ.-/ \'' )->length( 1, 200 ) )
            ->required( $this->extraGegevens & VOLLEDIGHEID_LANDNAAM )
            ->go();
        $this->validateOk += $setVar->name( $this->geboortedatum, get_object_vars( $this ) )
            ->onerror( $this->geboortedatumErr )
            ->validator( v::date( 'd-m-Y' ) )
            ->errormessage( "Controleer datum aub, formaat: dd-mm-yyyy" )
            ->required( $this->extraGegevens & VOLLEDIGHEID_GEBOORTEDATUM )
            ->go();
        $this->validateOk += $setVar->name( $this->geslacht, get_object_vars( $this ) )
            ->onerror( $this->geslachtErr )
            ->formatter( 'strtoupper' )
            ->validator( v::regex( "/^(?:M|V)$/" ) )
            ->errormessage( "M of V graag" )
            ->required( $this->extraGegevens & VOLLEDIGHEID_GESLACHT )
            ->go();
        $this->validateOk += $setVar->name( $this->email, get_object_vars( $this ) )
            ->onerror( $this->emailErr )
            ->validator( v::regex( "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/" )->length( 1, 200 ) )
        //->validator( v::email()->length( 1, 255 ) )
            ->required( $this->extraGegevens & VOLLEDIGHEID_MAIL )
            ->go();
        $this->validateOk += $setVar->name( $this->telefoonnummer, get_object_vars( $this ) )
            ->onerror( $this->telefoonnummerErr )
            ->validator( v::phone() )
            ->required( $this->extraGegevens & VOLLEDIGHEID_TELEFOON )
            ->go();

        if (  (  ( $this->extraGegevens & VOLLEDIGHEID_GEBOORTEDATUM ) || $this->all ) && substr_count( $this->geboortedatum, '-' ) == 2 )
        {
            $gebdat = explode( '-', $this->geboortedatum );
            $nudat = explode( '-', date( "d-m-Y" ) );
            if (  (  ( $nudat[2] - $gebdat[2] ) < 5 ) || (  ( $nudat[2] - $gebdat[2] ) > 100 ) )
            {
                $this->geboortedatumErr = "Controleer de geboortedatum a.u.b.";
                $this->validateOk += 1;
            }
        }
    }

    public function save( $persoon = null )
    {
        if ( $this->creator == "" )
        {
            $this->creator = $this->email;
        }

        if ( $this->persoon == null )
        {
            if ( $persoon == null )
            {
                $this->logger->error( "Kan leeg persoonobject niet opslaan" );
                throw new Exception( "Kan leeg persoonobject niet opslaan" );
            }
            else
            {
                $this->persoon = $persoon;
            }
        }
        else
        {
            $this->logger->debug( "Bestaand persoon, id=" . $this->id );
        }

        try
        {

            $this->persoon->setVoornaam( $this->voornaam );
            $this->persoon->setTussenvoegsel( $this->tussenvoegsel );
            $this->persoon->setAchternaam( $this->achternaam );
            $this->persoon->setStraat( $this->straat );
            $this->persoon->setHuisnummer( $this->huisnummer );
            $this->persoon->setToevoeging( $this->huisnummer_toevoeging );
            $this->persoon->setPostcode( $this->postcode );
            $this->persoon->setWoonplaats( $this->woonplaats );
            $this->persoon->setLandnaam( $this->landnaam );
            $this->persoon->setGeboorteDatum( $this->geboortedatum );
            $this->persoon->setGeslacht( $this->geslacht );
            $this->persoon->setEmail( $this->email );
            $this->persoon->setTelefoonnummer( $this->telefoonnummer );
            $this->persoon->setGewijzigdDoor( $this->userid );
            $this->persoon->save();

            $this->id = $this->persoon->getId();

            $this->logger->debug( "Persoon opgevoerd met id " . $this->persoon->getId() );
        }
        catch ( \Exception $e )
        {
            //var_dump( $e );
            $this->logger->error( 'Probleem met opslaan gegevens, details: ' . PHP_EOL . $e );
            //$validatiemelding = 'Probleem met opslaan gegevens, details: <br/>' . $e;
            alert( 'Probleem met opslaan gegevens, details: <br/>' . $e );
        }

    }

    // Getters en setters
    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator( $creator )
    {
        $this->creator = $creator;
    }

    public function getExtraGegevens()
    {
        return $this->extraGegevens;
    }

    public function setExtraGegevens( $extraGegevens )
    {
        $this->extraGegevens = $extraGegevens;
    }

    public function setAll( $all )
    {
        $this->all = $all;
    }

    public function getVoornaam()
    {
        return $this->voornaam;
    }

    public function setVoornaam( $voornaam )
    {
        $this->voornaam = $voornaam;
    }

    public function getStraat()
    {
        return $this->straat;
    }

    public function setStraat( $straat )
    {
        $this->straat = $straat;
    }

    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    public function setHuisnummer( $huisnummer )
    {
        $this->huisnummer = $huisnummer;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode( $postcode )
    {
        $this->postcode = $postcode;
    }

    public function getWoonplaats()
    {
        return $this->woonplaats;
    }

    public function setWoonplaats( $woonplaats )
    {
        $this->woonplaats = $woonplaats;
    }

    public function getLandnaam()
    {
        return $this->landnaam;
    }

    public function setLandnaam( $landnaam )
    {
        $this->landnaam = $landnaam;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail( $email )
    {
        $this->email = $email;
    }

    public function getTelefoonnummer()
    {
        return $this->telefoonnummer;
    }

    public function setTelefoonnummer( $telefoonnummer )
    {
        $this->telefoonnummer = $telefoonnummer;
    }

    public function getAchternaam()
    {
        return $this->achternaam;
    }

    public function setAchternaam( $achternaam )
    {
        $this->achternaam = $achternaam;
    }

    public function getTussenvoegsel()
    {
        return $this->tussenvoegsel;
    }

    public function setTussenvoegsel( $tussenvoegsel )
    {
        $this->tussenvoegsel = $tussenvoegsel;
    }

    public function getNaam()
    {
        return $this->voornaam . " " . $this->tussenvoegsel . " " . $this->achternaam;
    }

    public function getGeslacht()
    {
        return $this->geslacht;
    }

    public function setGeslacht( $geslacht )
    {
        $this->geslacht = $geslacht;
    }

    public function getGeboortedatum()
    {
        return $this->geboortedatum;
    }

    public function setGeboortedatum( $geboortedatum )
    {
        $this->geboortedatum = $geboortedatum;
    }

    public function gethuisnummerToevoeging()
    {
        return $this->huisnummer_toevoeging;
    }

    public function sethuisnummerToevoeging( $huisnummer_toevoeging )
    {
        $this->huisnummer_toevoeging = $huisnummer_toevoeging;
    }

    public function getVoornaamErr()
    {
        return $this->voornaamErr;
    }

    public function setVoornaamErr( $voornaamErr )
    {
        $this->voornaamErr = $voornaamErr;
    }

    public function getStraatErr()
    {
        return $this->straatErr;
    }

    public function setStraatErr( $straatErr )
    {
        $this->straatErr = $straatErr;
    }

    public function getHuisnummerErr()
    {
        return $this->huisnummerErr;
    }

    public function setHuisnummerErr( $huisnummerErr )
    {
        $this->huisnummerErr = $huisnummerErr;
    }

    public function getPostcodeErr()
    {
        return $this->postcodeErr;
    }

    public function setPostcodeErr( $postcodeErr )
    {
        $this->postcodeErr = $postcodeErr;
    }

    public function getWoonplaatsErr()
    {
        return $this->woonplaatsErr;
    }

    public function setWoonplaatsErr( $woonplaatsErr )
    {
        $this->woonplaatsErr = $woonplaatsErr;
    }

    public function getLandnaamErr()
    {
        return $this->landnaamErr;
    }

    public function setLandnaamErr( $landnaamErr )
    {
        $this->landnaamErr = $landnaamErr;
    }

    public function getEmailErr()
    {
        return $this->emailErr;
    }

    public function setEmailErr( $emailErr )
    {
        $this->emailErr = $emailErr;
    }

    public function getTelefoonnummerErr()
    {
        return $this->telefoonnummerErr;
    }

    public function setTelefoonnummerErr( $telefoonnummerErr )
    {
        $this->telefoonnummerErr = $telefoonnummerErr;
    }

    public function getAchternaamErr()
    {
        return $this->achternaamErr;
    }

    public function setAchternaamErr( $achternaamErr )
    {
        $this->achternaamErr = $achternaamErr;
    }

    public function getTussenvoegselErr()
    {
        return $this->tussenvoegselErr;
    }

    public function setTussenvoegselErr( $tussenvoegselErr )
    {
        $this->tussenvoegselErr = $tussenvoegselErr;
    }

    public function getGeslachtErr()
    {
        return $this->geslachtErr;
    }

    public function setGeslachtErr( $geslachtErr )
    {
        $this->geslachtErr = $geslachtErr;
    }

    public function getGeboortedatumErr()
    {
        return $this->geboortedatumErr;
    }

    public function setGeboortedatumErr( $geboortedatumErr )
    {
        $this->geboortedatumErr = $geboortedatumErr;
    }

    public function gethuisnummerToevoegingerr()
    {
        return $this->huisnummer_toevoegingErr;
    }

    public function sethuisnummerToevoegingerr( $huisnummer_toevoegingErr )
    {
        $this->huisnummer_toevoegingErr = $huisnummer_toevoegingErr;
    }

    public function getValidateOk()
    {
        return $this->validateOk;
    }

    public function setValidateOk( $validateOk )
    {
        $this->validateOk = $validateOk;
    }
}
