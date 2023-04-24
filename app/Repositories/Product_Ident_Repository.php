<?php

namespace App\Repositories;

use App\Models\Product_IdentModel;
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
        ['$project' =>
        [
          "Union" => ['$concatArrays' => ['$penny', '$tesco']]

        ]]
      ]);
    }));

    return $products;
  }
}
