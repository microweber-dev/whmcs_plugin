<?php
/**
 * Created by PhpStorm.
 * User: Bojidar
 * Date: 1/20/2020
 * Time: 4:16 PM
 */


/**
 * Encode arbitrary data into base-62
 * Note that because base-62 encodes slightly less than 6 bits per character (actually 5.95419631038688), there is some wastage
 * In order to make this practical, we chunk in groups of up to 8 input chars, which give up to 11 output chars
 * with a wastage of up to 4 bits per chunk, so while the output is not quite as space efficient as a
 * true multiprecision conversion, it's orders of magnitude faster
 * Note that the output of this function is not compatible with that of a multiprecision conversion, but it's a practical encoding implementation
 * The encoding overhead tends towards 37.5% with this chunk size; bigger chunk sizes can be slightly more space efficient, but may be slower
 * Base-64 doesn't suffer this problem because it fits into exactly 6 bits, so it generates the same results as a multiprecision conversion
 * Requires PHP 5.3.2 and gmp 4.2.0
 * @param string $data Binary data to encode
 * @return string Base-62 encoded text (not chunked or split)
 */
if (!function_exists('base62_encode')) {
    function base62_encode($data) {
        $outstring = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i += 8) {
            $chunk = substr($data, $i, 8);
            $outlen = ceil((strlen($chunk) * 8)/6); //8bit/char in, 6bits/char out, round up
            $x = bin2hex($chunk);  //gmp won't convert from binary, so go via hex
            $w = gmp_strval(gmp_init(ltrim($x, '0'), 16), 62); //gmp doesn't like leading 0s
            $pad = str_pad($w, $outlen, '0', STR_PAD_LEFT);
            $outstring .= $pad;
        }
        return $outstring;
    }
}

/**
 * Decode base-62 encoded text into binary
 * Note that because base-62 encodes slightly less than 6 bits per character (actually 5.95419631038688), there is some wastage
 * In order to make this practical, we chunk in groups of up to 11 input chars, which give up to 8 output chars
 * with a wastage of up to 4 bits per chunk, so while the output is not quite as space efficient as a
 * true multiprecision conversion, it's orders of magnitude faster
 * Note that the input of this function is not compatible with that of a multiprecision conversion, but it's a practical encoding implementation
 * The encoding overhead tends towards 37.5% with this chunk size; bigger chunk sizes can be slightly more space efficient, but may be slower
 * Base-64 doesn't suffer this problem because it fits into exactly 6 bits, so it generates the same results as a multiprecision conversion
 * Requires PHP 5.3.2 and gmp 4.2.0
 * @param string $data Base-62 encoded text (not chunked or split)
 * @return string Decoded binary data
 */
if (!function_exists('base62_decode')) {
    function base62_decode($data) {
        $outstring = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i += 11) {
            $chunk = substr($data, $i, 11);
            $outlen = floor((strlen($chunk) * 6)/8); //6bit/char in, 8bits/char out, round down
            $y = gmp_strval(gmp_init(ltrim($chunk, '0'), 62), 16); //gmp doesn't like leading 0s
            $pad = str_pad($y, $outlen * 2, '0', STR_PAD_LEFT); //double output length as as we're going via hex (4bits/char)
            $outstring .= pack('H*', $pad); //same as hex2bin
        }
        return $outstring;
    }
}