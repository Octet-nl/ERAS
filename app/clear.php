<?php
/**
 * System      ERAS
 * Module      clear
 * Doel        Verwijderen sessie gegevens
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       29-08-2019
 * Licentie    Zie LICENSE.md
 */

 // Geen functies, classes, includes etc. gebruiken. Gewoon sessie verwijderen.
session_start();
session_destroy();
echo "Session cleared";
