<?php

namespace App\Services\Interfaces;

interface CurlRequestServiceInterface{

    /*
    * You need to describ your method properly here if possible use return type also.
    */

    public $url;
    public $method;
    public $headers;
    public $request_data;
    public $response;

    public function __construct($params = []);

    public function curlRequest();

    
}
