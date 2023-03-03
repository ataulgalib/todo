<?php 

namespace App\Services\Core;

class ResourceContainerService implements ResourceContainerInterface
{

    /**
     * When you need to bind some class with laravel services you can bind it here.
     * Besically when you need to avoid loop whice select query you can manage with this class with one REQUEST
     * 
     * In helper class you find to method setResource() for set resource class object (for query it is Eloquent object) and 
     * for getResource for get the resource class. 
     */
    private $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
}