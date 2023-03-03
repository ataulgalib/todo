<?php

namespace App\Services\Interfaces;

interface MecrosInterface{
    
    /**
     * multi dimentional array to collection convert
     */
    public function arrayToCollection();

    /**
     * collection keys forget by relation 
     */

    public function forgetByRelationsLast();

    /**
     * collection paginate
     *
     */

    public function collectionPaginate();


    /**
     * collection object 
     *
     */

    public function collectionToObject();

}