<?php

namespace App\Repositories;

use App\Models\Penny_GeneralModel;
use App\Models\PennyProductModel;
use App\Models\Product_IdentModel;
use App\Services\Product_Ident_Service;
use App\Models\ShoppingCartModel;

class Penny_General_Repository
{
    protected $productIdent;
    public function __construct(Product_Ident_Service $productIdent)
    {
        $this->productIdent = $productIdent;
    }

    public function updateTotal($total, $totalResponse)
    {
        $total->update(['_id' => 1, 'Total' => $totalResponse]);
        return $total;
    }
    public function createTotal($totalRespone)
    {
        $pennyGeneralModel = new Penny_GeneralModel();
        $pennyGeneralModel->_id = 1;
        $pennyGeneralModel->Total = $totalRespone;
        $pennyGeneralModel->save();
    }
    public function getTotal()
    {
        $total = Penny_GeneralModel::All();
        return $total;
    }
    public function storeAllProducts($results)
    {
        foreach ($results as $product) {
            $productmodel = new PennyProductModel();
            $productmodel->Category = $product->category;
            if (count($product->images) > 0) {
                $productmodel->images = $product->images[0];
            }
            $productmodel->name = $product->name;
            $productmodel->unitLong = $product->price->baseUnitLong;
            $productmodel->unitShort = $product->price->baseUnitShort;
            $productmodel->unitPrice = $product->price->regular->perStandardizedQuantity;
            $productmodel->price = $product->price->regular->value;
            if (isset($product->price->validityStart)) {
                $productmodel->validityStart = $product->price->validityStart;
            }
            if (isset($product->price->validityEnd)) {
                $productmodel->validityEnd = $product->price->validityEnd;
            }
            $productmodel->isPublished = $product->isPublished;
            $productmodel->volumeLabelLong = $product->volumeLabelLong;
            $productmodel->weight = $product->weight;
            $productmodel->published = $product->published;
            $productmodel->productMarketing = $product->productMarketing;
            $this->productIdent->identifyProduct($product);
            $productmodel->product_ident_id = $product->product_ident_id;
            $productmodel->priceScore = $product->priceScore;
            $productmodel->save();
        }
    }
    public function wipeProducts()
    {
        $allProducts = PennyProductModel::All();
        foreach ($allProducts as $product) {
            $product->delete();
        }
    }
    public function getAllProducts($paginator)
    {
        return PennyProductModel::paginate($paginator);
    }
    public function getAllProductsOrdered($paginator, $orderBy, $sortDirection, $query)
    {
        return PennyProductModel::OrderBy($orderBy, $sortDirection)
            ->where('name', 'Like', $query)
            ->orWhere('unitLong', 'Like', $query)
            ->orWhere('unitShort', 'Like', $query)
            ->orWhere('Category', 'Like', $query)
            ->orWhere('validityStart', 'Like', $query)
            ->orWhere('validityEnd', 'Like', $query)
            ->paginate($paginator);
    }
    public function getProduct($id)
    {
        return PennyProductModel::where('_id', 'Like', $id)->get();
    }
    public function updatePennyProduct($id, $product)
    {
        PennyProductModel::where('_id', $id)->update($product);
    }
    public function deleteShoppingCarts($productId)
    {
        ShoppingCartModel::where('product_id', $productId)->delete();
    }
    public function wipeShoppingCarts()
    {
        ShoppingCartModel::where('shop', 'Penny')->delete();
    }
    public function deletePennyProduct($id)
    {
        PennyProductModel::where('_id', $id)->delete();
    }
    public function checkHealth()
    {
        return "Repo alive";
    }
}
