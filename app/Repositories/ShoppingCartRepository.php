<?php

namespace App\Repositories;

use App\Models\ShoppingCartModel;

class ShoppingCartRepository
{
  public function addToShoppingCart($validatedResults)
  {
    ShoppingCartModel::create($validatedResults);
  }
  public function updateShoppingCart($validatedResults, $id)
  {
    ShoppingCartModel::where('_id', $id)->update($validatedResults);
  }
  public function deleteShoppingCart($id)
  {
    ShoppingCartModel::where('_id', $id)->delete();
  }
}
