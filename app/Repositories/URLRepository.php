<?php 
namespace App\Repositories;
use App\Models\URLModel;
class URLRepository{
    
    public function getPenny(){
        return env("PENNY_URL", "somedefaultvalue");
    }
    public function getTesco(){
        return env("TESCO_URL", "somedefaultvalue");
    }
}
