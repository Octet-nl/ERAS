<?php
/**
 * System      Inschrijvingen
 * Module      show
 * Doel        Tonen sessie gegevens
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       29-08-2019
 * Licentie    Zie LICENSE.md
 */

require_once 'constanten.php';
require_once 'utilities.php';

$sessie = new Sessie();

$logger = new Logger();
$logger->level( LOGLEVEL );

getGetVar( $alles );

if ( $alles != null )
{
    echo '<pre>';
    print_r( $_SESSION );
    echo '</pre>';
}
else
{
    if ( isset( $_SESSION['inschrijving'] ) )
    {
    //    $sessieVariabelen = $_SESSION['inschrijving'];
        echo '<pre>';
        print_r( $_SESSION['inschrijving'] );
        echo '</pre>';
    }
    else
    {
        echo "Geen inschrijvingsgegevens bekend.<br/>";
    }
}

echo '<a href="index.php"><button>Terug</button></a> ';
