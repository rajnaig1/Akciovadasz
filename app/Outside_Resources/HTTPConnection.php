<?php 
namespace App\Outside_Resources;
use Illuminate\Support\Facades\Http;
class HTTPConnection{
    public function get($url){
        return Http::get($url)->body();
    }
}
?>