<?php
/**
 * System      ERAS
 * Module      Logout
 * Doel        Afmelden
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       19-09-2020
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

$sessie = new Sessie();

$doctitle = "Afmelden";
$logger = new Logger();
$logger->level( LOGLEVEL );


// DEEL 1
if ( $_SERVER["REQUEST_METHOD"] == "GET" )
{
    $logger->dump( $_SESSION );

    if ( $previous == "" )
    {
        $previous = "javascript:history.go(-1)";
        if ( isset( $_SESSION['referer'] ) )
        {
            $previous = $_SESSION['referer'];
            $logger->debug( "referer=" . $previous );
        }
        $logger->debug( "Previous=" . $previous );
    }
    else
    {
        $logger->debug( "Previous was al gevuld met " . $previous );
    }

    $autorisatie = new Autorisatie();
    $userid = $autorisatie->getUserId();
    $autorisatie->logout();

    $logger->debug( "Doorzetten naar Location:" . $previous );
    header( "Location:" . $previous );
    exit;
} // GET
