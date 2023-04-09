<?php

namespace App\Repositories;

use App\Models\TescoModel;

class TescoRepository
{

    public function storeProduct($productObject)
    {
        $tescomodel = new TescoModel();
        $tescomodel->template = $productObject->template;
        $tescomodel->name = $productObject->name;
        $tescomodel->url = $productObject->url;
        $tescomodel->active = $productObject->active;
        $tescomodel->offerBegin = $productObject->offerBegin;
        $tescomodel->offerEnd = $productObject->offerEnd;
        $tescomodel->imageURL = $productObject->imageURL;
        $tescomodel->unit = $productObject->unit;
        $tescomodel->bestUnitPrice = $productObject->bestUnitPrice;
        $tescomodel->bestPrice = $productObject->bestPrice;
        $tescomodel->comment = $productObject->comment;
        $tescomodel->save();
    }
    public function wipeProducts()
    {
        $allProducts = TescoModel::All();
        foreach ($allProducts as $product) {
            $product->delete();
        }
    }
}
