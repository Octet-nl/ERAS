<?php
/**
 * System      ERAS
 * Module      constanten
 * Doel        Globale constanten voor literals e.d.
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       01-11-2019
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

//////////////////////////////////////////
// Constanten zijn gesorteerd op alfabet.
// Graag zo houden !
//////////////////////////////////////////

define("ANNULERINGSVERZEKERING_GEEN", "1");
define("ANNULERINGSVERZEKERING_GEWOON", "2");
define("ANNULERINGSVERZEKERING_ALLRISK", "3");

// Autorisaties moeten oplopende waarden hebben, 
// Lopend van weinig naar veel autorisatie.
// Bijvoorbeeld Administrator moet altijd groter zijn dan de rest
define("AUTORISATIE_STATUS_GEEN", "0" );
define("AUTORISATIE_STATUS_KLANT", "1" );
define("AUTORISATIE_STATUS_MEDEWERKER", "2" );
define("AUTORISATIE_STATUS_SUPERVISOR", "3" );
define("AUTORISATIE_STATUS_ADMINISTRATOR", "4" );
define("AUTORISATIE_STATUS_ROOT", "5" );

// Volgende constanten worden binair gebruikt (allemaal een enkel bit), 
// dus bij uitbreiding reeks vervolgen: 16, 32, 64. Boven de 64 moet 
// betaalwijze_naar_html_class.php aangepast worden.
define("BETAALWIJZE_IDEAL", "1");
define("BETAALWIJZE_OVERSCHRIJVING", "2");
define("BETAALWIJZE_INCASSO", "4");
define("BETAALWIJZE_CONTANT", "8");
define("BETAALWIJZE_CREDITCARD", "16");
define("BETAALWIJZE_VOUCHER", "32");

define("CONFIG_DIRNAME", '../config' );
define("CONFIG_FILENAME", '../config/config_ini.php' );
define("DEBUG_CONFIG_FILENAME", '../config/debug_ini.php' );
define("DATABASE_CONFIG_FILENAME", '../config/database_ini.php' );

define("DB_INVALID", "0");
define("DB_VALID", "1");

define("DEELNEMER_STATUS_ACTIEF", "1");
define("DEELNEMER_STATUS_NIET_ACTIEF", "2");
define("DEELNEMER_STATUS_GEANNULEERD", "9");

define("EVENEMENT_STATUS_OPEN", "1");
define("EVENEMENT_STATUS_GESLOTEN", "2");
define("EVENEMENT_STATUS_WACHT", "3");
define("EVENEMENT_STATUS_VOL", "4");
define("EVENEMENT_STATUS_GEANNULEERD", "9");

// Deze drie schakelen de fancy opmaak, de kalenders en de alerts uit
// Dit kan nodig zijn bij automatisch testen
// Loglevel DEBUG of DUMP schakelt de fancy opmaak ook uit!
define("EVENEMENT_EDIT_WYSIWIG", true);
define("EVENEMENT_DATUM_KALENDERS", true);
define("TOON_ALERTS", true);

define("GESLACHT_MAN", "M");
define("GESLACHT_VROUW", "V");

define("HORIZONTALE_LIJN_GEEN",  "0");
define("HORIZONTALE_LIJN_BOVEN", "1");
define("HORIZONTALE_LIJN_ONDER", "2");
define("HORIZONTALE_LIJN_BEIDE", "3");

define("INSCHRIJVING_SOORT_INDIVIDU", "individu");
define("INSCHRIJVING_SOORT_GROEP", "groep");
define("INSCHRIJVING_KLANT_NIEUW", "1" );
define("INSCHRIJVING_KLANT_BESTAAND", "2" );

define("INSCHRIJVING_STATUS_OPEN", "1");
define("INSCHRIJVING_STATUS_DEFINITIEF", "2");
define("INSCHRIJVING_STATUS_GEANNULEERD", "9");

define("KEUZETYPE_EVENEMENT", "1");
define("KEUZETYPE_OPTIE", "2");
define("KEUZETYPE_INSCHRIJVING", "3");
define("KEUZETYPE_AUTORISATIE", "4");
define("KEUZETYPE_DEELNEMER", "5");
define("KEUZETYPE_HORIZONTALE_LIJN", "7");
define("KEUZETYPE_EXTRA_PERSOONSGEGEVENS", "8");
define("KEUZETYPE_VOUCHER", "9");

define("LOGFILE_NAME", "ERAS.log");

define("LOGLEVEL_VERBOSE", "0");
define("LOGLEVEL_DUMP", "1");
define("LOGLEVEL_DEBUG", "2");
define("LOGLEVEL_INFO", "3");
define("LOGLEVEL_WARNING", "4");
define("LOGLEVEL_ERROR", "5");
define("LOGLEVEL_SECURITY", "6");
define("LOGLEVEL_NONE", "7");

define("OPTIE_KEUZE_JA", "ja");
define("OPTIE_KEUZE_NEE", "nee");

define("OPTIE_STATUS_ACTIEF", "1");
define("OPTIE_STATUS_NIET_ACTIEF", "2");

define("OPTIETYPE_AANTAL", "1");
define("OPTIETYPE_GETAL", "2");
define("OPTIETYPE_TEKSTREGEL", "3");
define("OPTIETYPE_TEKSTVAK", "4");
define("OPTIETYPE_KEUZE_JA_NEE", "5");
define("OPTIETYPE_KEUZE_RADIO", "6");
define("OPTIETYPE_KEUZE_MEERDERE", "7");
define("OPTIETYPE_KOPTEKST", "8");
define("OPTIETYPE_VASTE_TEKST", "9");
define("OPTIETYPE_AKKOORD", "10");
define("OPTIETYPE_VOORWAARDE", "11");

define("PASSWORD_ZWAK", "1");
define("PASSWORD_MEDIUM", "2");
define("PASSWORD_STERK", "3");
define("PASSWORD_ZEERSTERK", "4");

// 1800 seconden is een half uur
define("SESSIE_GELDIGHEID_SECONDEN", 7200);

// Volgende constanten worden binair gebruikt (allemaal een enkel bit), 
// dus bij uitbreiding reeks vervolgen: 16, 32, 64, 128, 256 etc.
define("VOLLEDIGHEID_NAW", 0 );
define("VOLLEDIGHEID_MAIL", 1);
define("VOLLEDIGHEID_TELEFOON", 2 );
define("VOLLEDIGHEID_LANDNAAM", 4);
define("VOLLEDIGHEID_GEBOORTEDATUM", 8 );
define("VOLLEDIGHEID_GESLACHT", 16 );

define("VOUCHERTYPE_VOUCHER", "1");
define("VOUCHERTYPE_KORTING", "2");

?>