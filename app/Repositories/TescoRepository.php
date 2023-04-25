<?php

namespace App\Repositories;

use App\Models\TescoModel;
use App\Models\ShoppingCartModel;

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
        $tescomodel->product_ident_id = $productObject->product_ident_id;
        $tescomodel->priceScore = $productObject->priceScore;
        $tescomodel->save();
    }
    public function wipeProducts()
    {
        $allProducts = TescoModel::All();
        foreach ($allProducts as $product) {
            $product->delete();
        }
    }
    public function wipeShoppingCarts()
    {
        ShoppingCartModel::where('shop', 'Tesco')->delete();
    }
}
