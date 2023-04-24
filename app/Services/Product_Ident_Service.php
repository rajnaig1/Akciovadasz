<?php

namespace App\Services;

use App\Repositories\Product_Ident_Repository;

class Product_Ident_Service
{
    protected $productIdents;
    public function __construct(Product_Ident_Repository $productIdents)
    {
        $this->productIdents = $productIdents;
    }
    private function timeformatter($time)
    {
        $time = strtotime($time);
        $newformat = date('Y-m-d', $time);
        return $newformat;
    }
    public function getProducts()
    {
        $products = $this->productIdents->getAllProducts();
        $returnArray = [];
        foreach ($products as $product) {
            foreach ($product->penny as $prod) {
                $returnArray = $this->iteratePennyProducts($returnArray, $prod);
            }
            foreach ($product->tesco as $prod) {
                $returnArray = $this->iterateTescoProducts($returnArray, $prod);
            }
        }
        \usort($returnArray, function ($a, $b) {
            return $a->priceScore <=> $b->priceScore;
        });
        return $returnArray;
    }
    private function iterateTescoProducts($returnArray, $prod)
    {
        $productObject = (object)array();
        $offerBegins = $this->timeformatter($prod->offerBegin);
        $offerEnds = $this->timeformatter($prod->offerEnd);
        if ($offerBegins <= \date('Y-m-d') && $offerEnds >= \date('Y-m-d') && $prod->active) {
            $productObject->shop = 'Tesco';
            $productObject->id = $prod->_id;
            $productObject->name = $prod->name;
            $productObject->unit = $prod->unit;
            $productObject->unitPrice = $prod->bestUnitPrice;
            $productObject->price = $prod->bestPrice;
            $productObject->offerBegins = $prod->offerBegin;
            $productObject->offerEnds = $prod->offerEnd;
            $productObject->comment = $prod->comment;
            $productObject->priceScore = $prod->priceScore;
            $imagestart = 'https://www.tesco-bst.com/';
            $productObject->images = $imagestart . $prod->imageURL;
            array_push($returnArray, $productObject);
        }
        return $returnArray;
    }
    private function iteratePennyProducts($returnArray, $prod)
    {
        $productObject = (object)array();
        $offerBegins = $this->timeformatter($prod->validityStart);
        $offerEnds = $this->timeformatter($prod->validityEnd);
        if ($offerBegins <= \date('Y-m-d') && $offerEnds >= \date('Y-m-d') && $prod->isPublished) {
            $productObject->shop = 'Penny';
            $productObject->id = $prod->_id;
            $productObject->name = $prod->name;
            $productObject->unit = $prod->unitShort;
            $productObject->unitPrice = ($prod->unitPrice / 100);
            $productObject->price = ($prod->price / 100);
            $productObject->offerBegins = $prod->validityStart;
            $productObject->offerEnds = $prod->validityEnd;
            $productObject->comment = '';
            $productObject->priceScore = $prod->priceScore;
            if (isset($prod->images)) {
                $productObject->images = $prod->images;
            } else {
                $productObject->images = '';
            }

            array_push($returnArray, $productObject);
        }
        return $returnArray;
    }
    public function identifyProduct($productObject)
    {
        $idents = $this->productIdents->getAllProductIdent();
        foreach ($idents as $ident) {
            if ($ident->regex != '') {
                if (\preg_match($ident->regex, mb_strtolower($productObject->name))) {
                    $productObject->product_ident_id = $ident->id;
                    $this->priceScoreCalculator($ident, $productObject);
                    return;
                }
            } else {
                $this->priceScoreCalculator($ident, $productObject);
            }
        }
        //Az egyéb termékkategória
        $productObject->product_ident_id = 1;
        return;
    }
    private function priceScoreCalculator($ident, $productObject)
    {
        if (isset($productObject->bestUnitPrice)) {
            if (is_numeric($productObject->bestUnitPrice)) {
                $productObject->priceScore = ($productObject->bestUnitPrice) / $ident->basePrice;
            } else {
                $productObject->priceScore = 1000000;
            }
        } else if (isset($productObject->price->regular->perStandardizedQuantity)) {
            $productObject->priceScore = ($productObject->price->regular->perStandardizedQuantity / 100) / $ident->basePrice;
        } else {
            $productObject->priceScore = 1000000;
        }
    }
}
