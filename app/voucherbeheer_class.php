<?php
/**
 * System      Inschrijvingen
 * Module      Voucher class
 * Doel        Genereren, afhandelen en tonen van informatie betreffende vouchers
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

use fb_model\fb_model\Base\VoucherQuery;

require_once 'constanten.php';
require_once 'utilities.php';
require_once 'code_generator_class.php';

// HTML generatie voor betaalwijze
class VoucherBeheer
{
    private $logger = null;
    private $generator = null;

    public function __construct( )
    {
        $this->logger = new Logger();
        $this->logger->level( LOGLEVEL );
        $this->generator = new CodeBeheer();
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

    public function genereerCode(): string
    {
        return $this->generator->genereer();
    }

    public function genereerUniekeCode(): string
    {
        $code = $this->generator->genereer();

        while ( VoucherQuery::create()->filterByCode( $code ) ->findOne( ) != null )
        {
            $code = $this->generator->genereer();
        }
        return $code;
    }

    public function checkCode( $code )
    {
        // Zet autolengte op true
        return( $this->generator->check( $code, true ) );
    }
}
