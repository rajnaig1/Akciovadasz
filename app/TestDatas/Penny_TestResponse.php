<?php
namespace App\TestDatas;
class Penny_TestResponse{
    public function testResultsPlusTotal(){
        $testArray=['total'=>2,'results'=>$this->createTestProducts()];
        return $testArray;
    }
    public function createTestProducts(){
        $testArray=[];
        $price=(object)[];
        $regular=(object)[];
        $product=(object)[];
        $product->price=$price;
        $product->price->regular=$regular;
        $product->category='testCategory';
        $product->images=['testimage'];
        $product->name='testName';
        $product->price->baseUnitLong='kilogram';
        $product->price->baseUnitShort='kg';
        $product->price->regular->perStandardizedQuantity=10000;
        $product->price->regular->value=1000;
        $product->price->validityStart='testdate';
        $product->price->validityEnd='testEndDate';
        $product->isPublished=true;
        $product->volumeLabelLong='testVolumeLabel';
        $product->weight=0.1;
        $product->published=true;
        $product->productMarketing='';
        array_push($testArray,$product);
        
        $price=(object)[];
        $regular=(object)[];
        $product=(object)[];
        $product->price=$price;
        $product->price->regular=$regular;
        $product->category='testCategory2';
        $product->images=[];
        $product->name='testName2';
        $product->price->baseUnitLong='kilogram';
        $product->price->baseUnitShort='kg';
        $product->price->regular->perStandardizedQuantity=20000;
        $product->price->regular->value=2000;
        $product->price->validityStart='testdate2';
        $product->price->validityEnd='testEndDate2';
        $product->isPublished=true;
        $product->volumeLabelLong='testVolumeLabel2';
        $product->weight=0.2;
        $product->published=true;
        $product->productMarketing='2';
        array_push($testArray,$product);
        return $testArray;
    }
}
?>