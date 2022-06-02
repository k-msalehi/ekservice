<?php

namespace App\Services\Helpers;

class Helper
{
    public function dateToTimestamp($date)
    {
        if ($date)
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->timestamp;
        return null;
    }
    /**
     * convert persian number to latin numbers and remove beginning '0'
     */
    public function prepareTel(?string $tel): ?string
    {
        if (empty($tel))
            return null;
        $tel = strpos($tel, '0') === 0 ? substr($tel, 1) :  $tel;
        if (strpos($tel, '9') === 0 && mb_strlen($tel) === 10)
            return $tel;

        return 'invalid';
    }

    public function faToEnNum(?string $string): ?string
    {
        if (empty($string))
            return null;
        $string = str_replace(
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $string
        );

        return $string;
    }

    public function calculatePercentage($originalPrice, $salePrice)
    {
        return ceil(100 - (($salePrice * 100) / $originalPrice));
    }

    public function e2pPrice(string $string)
    {
        if (empty($string))
            return null;
        $string = number_format($string);
        $string = str_replace(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            $string
        );
        return $string;
    }


    function isBot()
    {
        return (isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
        );
    }

    public function countWords(string $string) :int
    {
        return str_word_count($string);
    }

}
