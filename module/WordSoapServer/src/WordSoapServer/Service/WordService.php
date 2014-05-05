<?php

namespace WordSoapServer\Service;

/**
 * Class WordService is responsible for:
 *  - Knows how to reverse given string
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 * @package WordSoapServer
 */
class WordService
{

    /**
     * Flips given word symbols in reverse order
     *
     * @param string $string String to reverse (max 64 characters)
     * @return string Reversed string
     */
    public function wordFlip($string)
    {
        if( strlen($string)>64 ) {
            throw new \InvalidArgumentException('Hey, You give too long string, I allow max 64 symbols');
        }

        return strrev($string);
    }

    /**
     * My own implementation of string reversal
     *
     * @param string $string String to reverse
     * @return string Reversed string
     */
    protected function _reverseString($string)
    {
        $stringReversed = '';
        $length = strlen($string);
        for($i=$length-1;$i >=0;$i--){
            echo $stringReversed .= $string[$i];
        }

        return $stringReversed;
    }
}