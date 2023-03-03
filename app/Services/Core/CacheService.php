<?php

namespace App\Services\Core;

use Cache;
use App\Services\Interfaces\CacheInterface;

class CacheService implements CacheInterface{
 

     const CACHE_STORE_TIME = CACHE_STORE_TIME; // in minutes

     public static function get($key){
          return Cache::get($key);
     }
     
     public static function set($key, $value, $minutes = Self::CACHE_STORE_TIME){

          if(empty($minutes)){
               $minutes = Self::CACHE_STORE_TIME;
          }

          return Cache::put($key, $value, $minutes);
     }
     
     public static function forget($key){
          return Cache::forget($key);
     }

     public static function has($key){
          return Cache::has($key);
     }

     public static function flush(){
          return Cache::flush();
     }

     /**
      * callback method used as a parameter
      */

     public static function remember($key, $minutes = Self::CACHE_STORE_TIME, $callback){

          if(empty($minutes)){
               $minutes = Self::CACHE_STORE_TIME;
          }

          return Cache::remember($key, $minutes, $callback);
     }

     /**
      * callback method used as a parameter
      */

     public static function rememberForever($key, $callback){
          return Cache::rememberForever($key, $callback);
     }

}