<?php
/**
 * System      ERAS
 * Module      Persoon template variabelen
 * Doel        Invullen van de persoonsgegevens in de template
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       11-09-2019
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

// Dit deel vult de waarden in voor de HTML template en start deze op.

$smarty->assign( 'doctitle', $doctitle );
$smarty->assign( 'id_visibility', $id_visibility );
$smarty->assign( 'evt', $evt );
$smarty->assign( 'readonly', $readonly );
$smarty->assign( 'id', $persoonsGegevens->getId() );
$smarty->assign( 'voornaam', $persoonsGegevens->getVoornaam() );
$smarty->assign( 'voornaamErr', $persoonsGegevens->getVoornaamErr() );
$smarty->assign( 'tussenvoegsel', $persoonsGegevens->getTussenvoegsel() );
$smarty->assign( 'tussenvoegselErr', $persoonsGegevens->getTussenvoegselErr() );
$smarty->assign( 'achternaam', $persoonsGegevens->getAchternaam() );
$smarty->assign( 'achternaamErr', $persoonsGegevens->getAchternaamErr() );
$smarty->assign( 'naam', $persoonsGegevens->getNaam() );
$smarty->assign( 'straat', $persoonsGegevens->getStraat() );
$smarty->assign( 'straatErr', $persoonsGegevens->getStraatErr() );
$smarty->assign( 'huisnummer', $persoonsGegevens->getHuisnummer() );
$smarty->assign( 'huisnummerErr', $persoonsGegevens->getHuisnummerErr() );
$smarty->assign( 'huisnummer_toevoeging', $persoonsGegevens->getHuisnummerToevoeging() );
$smarty->assign( 'huisnummer_toevoegingErr', $persoonsGegevens->gethuisnummerToevoegingErr() );
$smarty->assign( 'postcode', strtoupper( $persoonsGegevens->getPostcode() ));
$smarty->assign( 'postcodeErr', $persoonsGegevens->getPostcodeErr() );
$smarty->assign( 'woonplaats', $persoonsGegevens->getWoonplaats() );
$smarty->assign( 'woonplaatsErr', $persoonsGegevens->getWoonplaatsErr() );
$landNaam = $persoonsGegevens->getLandnaam();
if ( $landNaam == "" )
{
    $landNaam = "Nederland";
}
$smarty->assign( 'landnaam', $landNaam);
$smarty->assign( 'landnaamErr', $persoonsGegevens->getLandnaamErr() );
$smarty->assign( 'geboortedatum', $persoonsGegevens->getGeboortedatum() );
$smarty->assign( 'geboortedatumErr', $persoonsGegevens->getGeboortedatumErr() );
$smarty->assign( 'geslacht', $persoonsGegevens->getGeslacht() );
$smarty->assign( 'geslachtErr', $persoonsGegevens->getGeslachtErr() );
$smarty->assign( 'email', $persoonsGegevens->getEmail() );
$smarty->assign( 'emailErr', $persoonsGegevens->getEmailErr() );
$smarty->assign( 'telefoonnummer', $persoonsGegevens->getTelefoonnummer() );
$smarty->assign( 'telefoonnummerErr', $persoonsGegevens->getTelefoonnummerErr() );
$smarty->assign( 'validatiemelding', $validatiemelding );
$smarty->assign( 'volledigheid', $extraContact );
$smarty->assign( 'keuzeNAW', VOLLEDIGHEID_NAW );
$smarty->assign( 'keuzeLandnaam', VOLLEDIGHEID_LANDNAAM );
$smarty->assign( 'keuzeMail', VOLLEDIGHEID_MAIL );
$smarty->assign( 'keuzeTelefoon', VOLLEDIGHEID_TELEFOON );
$smarty->assign( 'keuzeGeboortedatum', VOLLEDIGHEID_GEBOORTEDATUM );
$smarty->assign( 'keuzeGeslacht', VOLLEDIGHEID_GESLACHT );
