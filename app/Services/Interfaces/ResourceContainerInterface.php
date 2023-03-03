<?php

namespace App\Services\Interfaces;

interface ResourceContainerInterface{

    /**
     * Constructor function bind the class excepted class for laravel service container.
     *  
     */

    public function __construct();

    /**
     * getResource() method to get the resource from the service container.
     */
    
    public function getResource();

}