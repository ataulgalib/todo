<?php

namespace App\Services\Core;

use App\Services\Interfaces\CurlRequestServiceInterface;
use App\Services\BaseService;

class CurlRequestService extends BaseService implements CurlRequestServiceInterface
{

   public $url;
   public $method;
   public $headers;
   public $request_data;
   public $response;

    public function __construct($params =[])
    {
        $this->url = $params['url'];
        $this->method = $params['method'];
        $this->headers = $params['headers'];
        $this->request_data = $params['request_data'];
    }

    
    public function curlRequest()
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_POSTFIELDS => $this->request_data,
            CURLOPT_HTTPHEADER => $this->headers,
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        $this->response = $response;

        $logData = [
            'url' => $this->url,
            'method' => $this->method,
            'headers' => $this->headers,
            'request_data' => $this->request_data,
            'response' => $this->response,
        ];

        logCreate($logData,CURL_REQUEST);
        
        return $this->response;
    }

}

