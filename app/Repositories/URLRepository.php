<?php 
namespace App\Repositories;
use App\Models\URLModel;
class URLRepository{
    
    public function getPenny(){
        return URLModel::Where('Shop','penny')->first();
    }
    public function getTesco(){
        return URLModel::Where('Shop','tesco')->first();
    }
}
?>