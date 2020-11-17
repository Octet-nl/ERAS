<?php
/**
 * System      Inschrijvingen
 * Module      Check voucher
 * Doel        Controleer of vouchercode correct is en wat het saldo is.
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       09-06-2020
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

use fb_model\fb_model\VoucherQuery;

$logger = new Logger();
$logger->level( LOGLEVEL );

$sessie = new Sessie();

// DEEL 1
// Opbouwen inschrijvingslijst
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_GET );
    $logger->dump( $_SESSION );

    if ( isset( $_SESSION['chkv'] ) )
    {
        if ( $_SESSION['chkv'] != 'ChEcKvOuChEr' )
        {
            $logger->debug( $_SESSION['chkv'] . " is niet gelijk aan " . 'ChEcKvOuChEr' );
            unset( $_SESSION['inschrijving'] );
            unset( $_SESSION['chkv'] );
            die( "<h2>403 Forbidden</h2>" );
        }
        //unset( $_SESSION['chkv'] );
    }
    else
    {
        $logger->debug( "Sessievariabele niet gezet" );
        die( "<h2>403 Forbidden</h2>" );
    }

    if ( isset( $_GET['id'] ) )
    {
        $code = $_GET['id'];

        $evt = null;

        if ( isset( $_GET['evt'] ) )
        {
            $evt = $_GET['evt'];
        }

        require_once 'voucherbeheer_class.php';

        $vouchercheck = new VoucherBeheer();
        if ( $vouchercheck->checkCode( $code ) )
        {
            $vandaag = date( "Y-m-d" );
            $voucher = VoucherQuery::create()->
                filterByCode( $code )->
                filterByIsActief(1)->
                findOne();

            if ( $voucher == null )
            {
                echo "02|Geen actieve tegoed- of kortingsbon met deze code gevonden";
            }
            else
            {
                $naam = "voucher";
                $email = "";
                if ( $voucher->getVoucherType() == VOUCHERTYPE_KORTING )
                {
                    $naam = "kortingsbon";
                    if ( $voucher->getEvenementId() != null && $voucher->getEvenementId() != $evt )
                    {
                        echo "05|Deze kortingsbon is niet geldig voor dit evenement.";
                        exit;
                    }
                }
                else if ( $voucher->getVoucherType() == VOUCHERTYPE_VOUCHER)
                {
                    $naam = "voucher";
                    $email = $voucher->getEmail();
                }

                if ( datumVerschil( $voucher->getGeldigTot()->format('Y-m-d H:i:s') , $vandaag ) > 0 )
                {
                    echo "04|Geldigheid " . $naam . " is verstreken. De " . $naam . " was geldig tot " . $voucher->getGeldigTot()->format('d-m-Y');
                }
                else
                {
                    $logger->debug( "03|" . $voucher->getId() . "|" . $voucher->getRestWaarde() . "|" . $voucher->getVerbruikt() . "|" . $email . "|" . $voucher->getVoucherType() );
                    echo "03|" . $voucher->getId() . "|" . (float)$voucher->getRestWaarde() . "|" . (float)$voucher->getVerbruikt() . "|" . $email . "|" . $voucher->getVoucherType();
                }
            }
        }
        else
        {
            echo "01|Onjuiste tegoed- of kortingsbon";
        }
    }
}
