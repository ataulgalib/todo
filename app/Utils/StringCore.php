<?php

namespace App\Utils;
use Illuminate\Support\Str;

class StringCore extends Str{

    public static function replaceString($pattern, $replacement, $string){

        return str_replace($pattern, $replacement, $string);

    }

    public static function niddleContainsString($string, $niddle){
        return strpos($string, $niddle) !== false;
    }

}
