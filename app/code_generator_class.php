<?php
/**
 * System      ERAS
 * Module      Codegenerator
 * Doel        Genereren en controleren van random codes voor vouchers en wachtwoord reset
 * Auteur      Hans de Rijck (apps@octet.nl)
 * Datum       23-09-2020
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

require_once 'constanten.php';
require_once 'utilities.php';

// Codegenerator voor vouchers en wachtwoord reset
class CodeBeheer
{
    private $lengte = 12;
    private $keyspace = '123456789BCDFGHJKLMNPQRSTVWXYZ';
    private $logger = null;

    public function __construct( )
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
    }

    public function setLengte( $lengte )
    {
        if ( $lengte % 4 == 0 )
        {
            $this->lengte = $lengte;
            return $lengte;
        }
        else
        {
            $this->logger->error( "setLengte moet een veelvoud van 4 zijn." );
            return null;
        }
    }

    /**
     * Losjes gebaseerd op:
     * https://stackoverflow.com/questions/4356289/php-random-string-generator/31107425#31107425
     */
    public function genereer( $dashes = true ): string
    {
        $pieces = [];
        $proef = 0;
        $max = mb_strlen( $this->keyspace, '8bit' ) - 1;
        for ( $i = 0; $i < $this->lengte - 1; ++$i )
        {
            if ( $dashes )
            {
                if ( $i > 0 && $i % 4 == 0 )
                {
                    $pieces[] = '-';
                }
            }
            $value = random_int( 0, $max );
            $pieces[] = $this->keyspace[$value];
            $proef += $i + 1 * ord( $this->keyspace[$value] );
        }
        // elfproef toevoegen
        $x = 0;
        while (  ( $x + $proef ) % 11 != 0 )
        {
            $x += 1;
        }

        if ( $x == 10)
        {
            $x = 'X';
        }

        $pieces[] = $x;
        $string = implode( '', $pieces );

        return $string;
    }

    public function check( $code, $autolengte=false )
    {
        // Controleer code met elfproef
        $proef = 0;
        $lengte = 0;

        $string = str_replace( "-", "", $code );

        if ( $autolengte )
        {
            $lengte = strlen( $string );
        }
        else
        {
            $lengte = $this->lengte;
        }

        for ( $i = 0; $i < $lengte - 1; ++$i )
        {
            $proef += $i + 1 * ord( $string[$i] );
        }

        if ( $string[$lengte - 1] == 'X' )
        {
            $proef += 10;
        }
        else
        {
            $proef += $string[$lengte - 1];
        }

        if ( $proef % 11 == 0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
