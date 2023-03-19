<?php 
namespace App\Repositories;
use App\Models\Penny_GeneralModel;
use App\Models\PennyProductModel;
class Penny_General_Repository{
    /*public function storeTotal($total){
        Penny_GeneralModel::updateOrcreate(['_id'=>1,'Total'=>$total]);
        return $total;  
    }*/
    public function updateTotal($total,$totalResponse){
        $total->update(['_id'=>1,'Total'=>$totalResponse]);
        return $total;
    }
    public function createTotal($totalRespone){
        $pennyGeneralModel=new Penny_GeneralModel();
        $pennyGeneralModel->_id=1;
        $pennyGeneralModel->Total=$totalRespone;
        $pennyGeneralModel->save();
    }
    public function getTotal(){
        $total=Penny_GeneralModel::All();
        return $total;  
    }
    public function storeAllProducts($results){
        foreach($results as $product){
            $productmodel=new PennyProductModel();
            $productmodel->Category=$product->category;
            if(count($product->images)>0){
                $productmodel->images=$product->images[0];
            }
            $productmodel->name=$product->name;
            $productmodel->unitLong=$product->price->baseUnitLong;
            $productmodel->unitShort=$product->price->baseUnitShort;
            $productmodel->unitPrice=$product->price->regular->perStandardizedQuantity;
            $productmodel->price=$product->price->regular->value;
            $productmodel->validityStart=$product->price->validityStart;
            $productmodel->validityEnd=$product->price->validityEnd;
            $productmodel->isPublished=$product->isPublished;
            $productmodel->volumeLabelLong=$product->volumeLabelLong;
            $productmodel->weight=$product->weight;
            $productmodel->published=$product->published;
            $productmodel->productMarketing=$product->productMarketing;
            $productmodel->save();
        }
    }
    public function wipeProducts(){
        $allProducts=PennyProductModel::All();
        foreach($allProducts as $product){
            $product->delete();
        }
    }
    public function checkHealth(){
        return "Repo alive";
    }
}
