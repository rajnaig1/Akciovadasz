<?php
namespace App\Parsers;
class JSONParser{
    public function pennyTotal($response)
    {
        $obj=\json_decode($response);
        return $obj->total;
    }
    public function pennyProductParser($response){
        $obj=\json_decode($response);
        return $obj->results;
    }
    public function tescoParser($response)
    {
        $obj=\json_decode($response);
        return $obj;
    }
}