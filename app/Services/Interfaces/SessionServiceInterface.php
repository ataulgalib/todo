<?php

namespace App\Services\Interfaces;

interface SessionServiceInterface{

    /*
    * You need to describ your method properly here if possible use return type also.
    */

    /*
    * setSession() is used to set session value.
    */

    public static function set($key, $value);

    /*
    * getSession() is used to get session value.
    */

    public static function get($key);

    /*
    * forgetSession() is used to forget session value.
    */

   public static function forget($key);
   
    /*
    * hasSession() is used to check session key exits.
    */

   public static function has($key);

    /*
    * flashSession() is used to flash session value.
    */

    public static function flash($level, $value);

}
