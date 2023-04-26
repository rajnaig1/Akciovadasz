<?php

namespace App\Repositories;

use App\Models\ShoppingCartModel;

class ShoppingCartRepository
{
  public function addToShoppingCart($validatedResults)
  {
    return ShoppingCartModel::create($validatedResults);
  }
  public function updateShoppingCart($validatedResults, $id)
  {
    return ShoppingCartModel::where('_id', $id)->update($validatedResults);
  }
  public function deleteShoppingCart($id)
  {
    return ShoppingCartModel::where('_id', $id)->delete();
  }
}
