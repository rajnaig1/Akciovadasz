<?php

namespace App\Repositories;

use App\Models\Product_IdentModel;
use App\Models\PennyProductModel;
use App\Models\TescoModel;
use App\Models\ShoppingCartModel;
use Illuminate\Support\Facades\DB;

class Product_Ident_Repository
{
  public function getAllProductIdent()
  {
    return Product_IdentModel::All();
  }
  public function getAllProducts()
  {
    $products = DB::collection('Product_Ident')->raw((function ($collection) {
      return $collection->aggregate([
        [
          '$lookup' => [
            'from' => 'Penny_Products',
            'localField' => '_id',
            'foreignField' => 'product_ident_id',
            'as' => 'penny',
          ]
        ], [

          '$lookup' => [
            'from' => 'Tesco_Products',
            'localField' => '_id',
            'foreignField' => 'product_ident_id',
            'as' => 'tesco'
          ]
        ],
      ]);
    }));

    return $products;
  }
  public function getshoppingCartForUser($productId, $userId)
  {
    return ShoppingCartModel::where('product_id', 'Like', $productId)
      ->where('user_id', 'Like', $userId)
      ->get();
  }
  public function getQueriedPennyProducts($query)
  {
    return PennyProductModel::OrderBy('priceScore', 'asc')
      ->where('name', 'Like', $query)
      ->orWhere('validityStart', 'Like', $query)
      ->orWhere('validityEnd', 'Like', $query)
      ->get();
  }
  public function getQueriedTescoProducts($query)
  {
    return TescoModel::OrderBy('priceScore', 'asc')
      ->where('name', 'Like', $query)
      ->orWhere('offerBegin', 'Like', $query)
      ->orWhere('offerEnd', 'Like', $query)
      ->get();
  }
}
