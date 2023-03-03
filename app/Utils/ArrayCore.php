<?php


namespace App\Utils;

use Illuminate\Support\Arr;

class ArrayCore extends Arr
{

    public static function InArray($niddle ='', $array = [], $status = false)
    {
        return in_array($niddle, $array, $status);
    }

    public static function isArray($value)
    {
        return is_array($value);
    }

}
