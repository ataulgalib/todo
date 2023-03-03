<?php

namespace App\Services\Interfaces;

interface BreadCrumInfoInterface{


    /**
     * Constructor function inisilaize the current route name.
     */
    public function __construct();

    /**
     * breadCrumInfoGenerate() method get the current menu list and return the breadcrum info.
     */ 

    public function breadCrumInfoGenerate();
    
}