<?php

namespace App\Outside_Resources;

use App\Services\URLService;
use App\Outside_Resources\HTTPConnection;
use App\Parsers\JSONParser;

class OutsideResponse
{
    protected $url;
    protected $json;
    protected $http;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(URLService $url,JSONParser $json, HttpConnection $http)
    {
        $this->url = $url;
        $this->json=$json;
        $this->http=$http;
    }
    public function pennyTotal()
    {       
        $response= $this->http->get($this->url->getPenny(1,1));
        return $this->json->pennyTotal($response);
    }
    public function pennyAllProducts($pageSize,$batchSize){
        $response= $this->http->get($this->url->getPenny($pageSize,$batchSize));
        return $this->json->pennyProductParser($response);
    }
    public function tescoTotal()
    {       
        $response= $this->http->get($this->url->getTesco());
        return $this->json->tescoParser($response);
    }
}
