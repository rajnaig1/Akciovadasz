<?php 
namespace App\Services;
use App\Outside_Resources\OutsideResponse;
use Exception;

class TescoService{
    protected $outsideResponse;
    public function __construct(OutsideResponse $outsideResponse)
    {
        $this->outsideResponse=$outsideResponse;
    }
    public function getTesco(){
        $tesco=$this->outsideResponse->tescoTotal();
        if(!$tesco->hasNext&&$this->checkIfNextProductQuantityIsFalse($tesco)){
            return $this->iterateProducts($tesco);
            return 'entered';
        }else{
            throw new Exception('There are more products than queried');
        }
    }
    public function checkIfNextProductQuantityIsFalse($tesco){
        if($tesco->nextProductsQty==0){
            return true;
        }
        return false;
    }
    public function iterateProducts($tesco){
        $productArray=$tesco->products;
        foreach($productArray as $product){
            return $product;
        }
    }
}
