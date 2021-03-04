<?php
/**
 * 04-03-2021 Hans de Rijck.
 * Class volledig gestript, en alleen voor Nederlands en Euro aangepast.
 * Nederlandse versie sterk verbeterd t.o.v. origineel, dat was buggy.
 * Class renamed naar Zegge
 *
 * Numbers_Words
 *
 * PHP version 5
 *
 * Copyright (c) 1997-2006 The PHP Group
 *
 * This source file is subject to version 3.01 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/3_01.txt
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Authors: Piotr Klaban <makler@man.torun.pl>
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 * @since    PHP 4.2.3
 * @access   public
 */
class Zegge
{
    /**
     * Locale name
     * @var string
     * @access public
     */
    public $locale = 'nl';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    public $lang = 'Dutch';

    /**
     * Native language name
     * @var string
     * @access public
     */
    public $lang_native = 'Nederlands';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    public $_minus = 'min '; // minus sign

    /**
     * The sufixes for exponents (singular and plural)
     * Names partly based on:
     * http://nl.wikipedia.org/wiki/Quadriljoen
     * @var array
     * @access private
     */
    public $_exponent = array(
        0 => array( '' ),
        3 => array( 'duizend', 'duizend' ),
        6 => array( 'miljoen', 'miljoen' ),
        9 => array( 'miljard', 'miljard' ),
        12 => array( 'biljoen', 'biljoen' ),
        15 => array( 'biljard', 'biljard' ),
        18 => array( 'triljoen', 'triljoen' ),
        21 => array( 'triljard', 'triljard' ),
    );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    public $_digits = array(
        0 => 'nul', 'een', 'twee', 'drie', 'vier',
        'vijf', 'zes', 'zeven', 'acht', 'negen',
    );

    /**
     * The word separator
     * @var string
     * @access private
     */
    public $_sep = '';
    public $_sep1 = ' ';

    /**
     * The exponent word separator
     * @var string
     * @access private
     */
    public $_sep2 = ' ';

    /**
     * Default decimal mark
     * @var string
     * @access public
     */
    public $decimalPoint = ',';

    /**
     * Converts a number to its word representation
     *
     * @param integer $num     An integer between -infinity and infinity inclusive :)
     *                         that should be converted to a words representation
     * @param string  $locale  Language name abbreviation. Optional. Defaults to
     *                         current loaded driver or en_US if any.
     * @param array   $options Specific driver options
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     * @return string  The corresponding word representation
     */
    public function toWords( $num, $locale = 'nl_NL', $options = array() )
    {
        if ( strlen( strval( $num ) ) > strlen( strval( PHP_INT_MAX ) ) - 1 )
        {
            return "Overflow";
        }

        if ( empty( $locale ) )
        {
            $locale = 'nl_NL';
        }

        if ( !is_int( $num ) )
        {
            $num = $this->normalizeNumber( $num );

            // cast (sanitize) to int without losing precision
            $num = preg_replace( '/(.*?)(' . preg_quote( $this->decimalPoint ) . '.*?)?$/', '$1', $num );
        }

        if ( empty( $options ) )
        {
            $ret = trim( $this->_toWords( $num ) );
        }
        else
        {
            $ret = trim( $this->_toWords( $num, $options ) );
        }

        if ( substr( $ret, 0, 10 ) === "eenduizend" )
        {
            $ret = substr( $ret, 3 );
        }

        return $ret;
    }
    // }}}

    // {{{ toCurrency()
    /**
     * Converts a currency value to word representation (1.02 => one dollar two cents)
     * If the number has not any fraction part, the "cents" number is omitted.
     *
     * @param float  $num      A float/integer/string number representing currency value
     *
     * @param string $locale   Language name abbreviation. Optional. Defaults to en_US.
     *
     * @param string $intCurr  International currency symbol
     *                         as defined by the ISO 4217 standard (three characters).
     *                         E.g. 'EUR', 'USD', 'PLN'. Optional.
     *                         Defaults to $def_currency defined in the language class.
     *
     * @param string $decimalPoint  Decimal mark symbol
     *                         E.g. '.', ','. Optional.
     *                         Defaults to $decimalPoint defined in the language class.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     * @return string
     */
    public function toCurrency( $num, $locale = 'nl_NL', $intCurr = '', $decimalPoint = null )
    {
        if ( strlen( strval( $num ) ) > strlen( strval( PHP_INT_MAX ) ) - 1 )
        {
            return "Overflow";
        }
        $ret = $num;

        if ( is_null( $decimalPoint ) )
        {
            $decimalPoint = $this->decimalPoint;
        }

        // round if a float is passed, use Math_BigInteger otherwise
        if ( is_float( $num ) )
        {
            $num = round( $num, 2 );
        }

        $num = $this->normalizeNumber( $num, $decimalPoint );

        if ( strpos( $num, $decimalPoint ) === false )
        {
            return trim( $this->toCurrencyWords( $intCurr, $num ) );
        }

        $currency = explode( $decimalPoint, $num, 2 );

        $len = strlen( $currency[1] );

        if ( $len == 1 )
        {
            // add leading zero
            $currency[1] .= '0';
        }
        elseif ( $len > 2 )
        {
            // get the 3rd digit after the comma
            $round_digit = substr( $currency[1], 2, 1 );

            // cut everything after the 2nd digit
            $currency[1] = substr( $currency[1], 0, 2 );

            if ( $round_digit >= 5 )
            {
                // round up without losing precision
                $int = $currency + 1;
                $int_str = strval( $int );

                $currency[0] = substr( $int_str, 0, -2 );
                $currency[1] = substr( $int_str, -2 );

                // check if the rounded decimal part became zero
                if ( $currency[1] == '00' )
                {
                    $currency[1] = false;
                }
            }
        }

        $ret = trim( $this->toCurrencyWords( $intCurr, $currency[0], $currency[1] ) );
        if ( substr( $ret, 0, 10 ) === "eenduizend" )
        {
            $ret = substr( $ret, 3 );
        }
        return $ret;
    }
    // }}}

    /**
     * Removes redundant spaces, thousands separators, etc.
     *
     * @param string $num            Some number
     * @param string $decimalPoint   The decimal mark, e.g. "." or ","
     *
     * @return string Number
     */
    public function normalizeNumber( $num, $decimalPoint = null )
    {
        if ( is_null( $decimalPoint ) )
        {
            $decimalPoint = $this->decimalPoint;
        }

        return preg_replace( '/[^-' . preg_quote( $decimalPoint ) . '0-9]/', '', $num );
    }

    public $_currency_names = array(
        'EUR' => array( array( ' euro ' ), array( ' cent ' ) ),
    );

    public $def_currency = 'EUR';

    // }}}
    // {{{ _toWords()

    /**
     * Converts a number to its word representation
     * in Dutch language.
     *
     * @param integer $num       An integer between -infinity and infinity inclusive :)
     *                           that need to be converted to words
     * @param integer $power     The power of ten for the rest of the number to the right.
     *                           Optional, defaults to 0.
     * @param integer $powsuffix The power name to be added to the end of the return string.
     *                            Used internally. Optional, defaults to ''.
     *
     * @return string  The corresponding word representation
     *
     * @access protected
     * @author Piotr Klaban <makler@man.torun.pl>
     * @author WHAM van Dinter <willem@fkkc.nl>
     * @since  Numbers_Words 0.16.3
     */
    public function _toWords( $num, $power = 0, $powsuffix = '' )
    {
        $ret = '';

        // add a minus sign
        if ( substr( $num, 0, 1 ) == '-' )
        {
            $ret = $this->_sep1 . $this->_minus;
            $num = substr( $num, 1 );
        }

        // strip excessive zero signs and spaces
        $num = trim( $num );
        $num = preg_replace( '/^0+/', '', $num );

        if ( strlen( $num ) > 3 )
        {
            $maxp = strlen( $num ) - 1;
            $curp = $maxp;
            for ( $p = $maxp; $p > 0; --$p )
            { // power

                // check for highest power
                if ( isset( $this->_exponent[$p] ) )
            {
                    // send substr from $curp to $p
                    $snum = substr( $num, $maxp - $curp, $curp - $p + 1 );
                    $snum = preg_replace( '/^0+/', '', $snum );
                    if ( $snum !== '' )
                {
                        $cursuffix = $this->_exponent[$power][count( $this->_exponent[$power] ) - 1];
                        if ( $powsuffix != '' )
                    {
                            $cursuffix .= $this->_sep1 . $powsuffix;
                        }
                    else
                    {
                            $cursuffix .= $this->_sep2;
                        }

                        $ret .= $this->_toWords( $snum, $p, $cursuffix );
                    }
                    $curp = $p - 1;
                    continue;
                }
            }
            $num = substr( $num, $maxp - $curp, $curp - $p + 1 );
            if ( $num == 0 )
            {
                return $ret;
            }
        }
        elseif ( $num == 0 || $num == '' )
        {
            return $this->_sep . $this->_digits[0];
        }

        $h = $t = $d = 0;
        switch ( strlen( $num ) )
        {
            case 3:
                $h = (int) substr( $num, -3, 1 );
                // fallthrough
            case 2:
                $t = (int) substr( $num, -2, 1 );
                // fallthrough
            case 1:
                $d = (int) substr( $num, -1, 1 );
                break;
            case 0:
                return;
                break;
        }

        if ( $h )
        {
            if ( $h == 1 )
            {
                $ret .= $this->_sep . 'honderd';
            }
            else
            {
                $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'honderd';
            }
        }

        // add digits only in <0>,<1,9> and <21,inf>
        if ( $t != 1 && $d > 0 )
        {
            if ( $t > 0 )
            {
                $ret .= $this->_digits[$d] . 'en';
            }
            else
            {
                $ret .= $this->_digits[$d];
                if ( $d == 1 )
                {
                    if ( $power == 0 )
                    {
                        $ret .= ''; // fuer eins
                    }
                    else
                    {
                        if ( $power != 3 )
                        { // tausend ausnehmen
                            $ret .= ''; // fuer eine
                        }
                    }
                }
            }
        }

        // ten, twenty etc.
        switch ( $t )
        {
            case 8:
                $ret .= $this->_sep . 'tachtig';
                break;
            case 9:
            case 7:
            case 6:
            case 5:
                $ret .= $this->_sep . $this->_digits[$t] . 'tig';
                break;

            case 4:
                $ret .= $this->_sep . 'veertig';
                break;

            case 3:
                $ret .= $this->_sep . 'dertig';
                break;

            case 2:
                $ret .= $this->_sep . 'twintig';
                break;

            case 1:
                switch ( $d )
                {
                    case 0:
                        $ret .= $this->_sep . 'tien';
                        break;

                    case 1:
                        $ret .= $this->_sep . 'elf';
                        break;

                    case 2:
                        $ret .= $this->_sep . 'twaalf';
                        break;

                    case 3:
                        $ret .= $this->_sep . 'dertien';
                        break;

                    case 4:
                        $ret .= $this->_sep . 'veertien';
                        break;

                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                        $ret .= $this->_sep . $this->_digits[$d] . 'tien';
                        break;

                }
                break;
        }

        if ( $power > 0 )
        {
            if ( isset( $this->_exponent[$power] ) )
            {
                $lev = $this->_exponent[$power];
            }

            if ( !isset( $lev ) || !is_array( $lev ) )
            {
                return null;
            }

            if ( $power == 3 )
            {
                $ret .= $this->_sep . $lev[0];
            }
            elseif ( $d == 1 && ( $t + $h ) == 0 )
            {
                $ret .= $this->_sep2 . $lev[0] . $this->_sep2;
            }
            else
            {
                $ret .= $this->_sep2 . $lev[1] . $this->_sep2;
            }
        }

        if ( $powsuffix != '' )
        {
            $ret .= $this->_sep . $powsuffix;
        }

        $ret = str_replace( "tweeen", "tweeën", $ret );
        $ret = str_replace( "drieen", "drieën", $ret );
        return $ret;
    }

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in English language
     *
     * @param integer $int_curr         An international currency symbol
     *                                  as defined by the ISO 4217 standard (three characters)
     * @param integer $decimal          A money total amount without fraction part (e.g. amount of dollars)
     * @param integer $fraction         Fractional part of the money amount (e.g. amount of cents)
     *                                  Optional. Defaults to false.
     * @param integer $convert_fraction Convert fraction to words (left as numeric if set to false).
     *                                  Optional. Defaults to true.
     *
     * @return string  The corresponding word representation for the currency
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  Numbers_Words 0.4
     */
    public function toCurrencyWords( $int_curr, $decimal, $fraction = false, $convert_fraction = true )
    {
        $int_curr = strtoupper( $int_curr );
        if ( !isset( $this->_currency_names[$int_curr] ) )
        {
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];

        $ret = trim( $this->_toWords( $decimal ) );
        $lev = ( $decimal == 1 ) ? 0 : 1;
        if ( $lev > 0 )
        {
            if ( count( $curr_names[0] ) > 1 )
            {
                $ret .= $this->_sep . $curr_names[0][$lev];
            }
            else
            {
                $ret .= $this->_sep . $curr_names[0][0] . ' ';
            }
        }
        else
        {
            $ret .= $this->_sep . $curr_names[0][0];
        }

        if ( $fraction !== false )
        {
            if ( $convert_fraction )
            {
                // onderdruk 0 cent
                if ( $fraction != 0 )
                {
                    $ret .= " en " . trim( $this->_toWords( $fraction ) );
                }
            }
            else
            {
                $ret .= $this->_sep . $fraction;
            }
            $lev = ( $fraction == 1 ) ? 0 : 1;
            if ( $lev > 0 )
            {
                if ( count( $curr_names[1] ) > 1 )
                {
                    $ret .= $this->_sep . $curr_names[1][$lev];
                }
                else
                {
                    // onderdruk 0 cent
                    if ( $fraction != 0 )
                    {
                        $ret .= $this->_sep . $curr_names[1][0] . ' ';
                    }
                }
            }
            else
            {
                $ret .= $this->_sep . $curr_names[1][0];
            }
        }
        return $ret;
    }
}
