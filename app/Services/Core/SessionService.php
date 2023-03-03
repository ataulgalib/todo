<?php

namespace App\Services\Core;

use App\Services\Interfaces\SessionServiceInterface;
use Session;

class SessionService implements SessionServiceInterface
{
    
    public static function set($key, $value)
    {
        
        if(!empty($key) && !empty($value))
        {

            if(self::has($key))
            {
                self::forget($key);
                return Session::put($key, $value);
            }

            return Session::put($key, $value);
           
        }
        
        return false;
    }
    
    public static function get($key)
    {
        if(self::has($key))
        {
            return Session::get($key);
        }
        return false;
    }
    
    public static function forget($key)
    {
        if(self::has($key))
        {
            return Session::forget($key);
        }
       
        return false;
    }
    
    public static function has($key)
    {
        return Session::has($key);
    }

    public static function flash($level, $value)
    {
        return Session::flash($level, $value);
    }
}

