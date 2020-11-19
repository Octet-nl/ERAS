<?php
/**
 * System      ERAS
 * Module      clear inschrijving
 * Doel        Verwijderen sessie gegevens voor inschrijving
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       21-01-2020
 * Licentie    MIT
 */

$sessie = new Sessie();

unset($_SESSION['inschrijving']);
unset($_SESSION['opties']);
echo "Inschrijving verwijderd.";
