<?php

namespace App\Services\Interfaces;

interface CacheInterface{

    // NOT CHECKED YET
        
    /**
     * get method to get the data from cache
     */
    public static function get($key);

    /**
     * put method to put the data in cache
     */
    
    public static function set($key, $value, $minutes = CACHE_STORE_TIME);

    /**
     * forget method to flush the cache
     */
    
    public static function forget($key);

    /**
     * has method check the key is exist or not
     */
    
    public static function has($key);

    /**
     * flush method to flush the cache
     */
    
    public static function flush();

    /**
     * remember method chache remember forever
     */
    
    public static function remember($key, $minutes = CACHE_STORE_TIME, $callback);

    /**
     * rememberForever method chache remember forever
     */
    
    public static function rememberForever($key, $callback);
        
}