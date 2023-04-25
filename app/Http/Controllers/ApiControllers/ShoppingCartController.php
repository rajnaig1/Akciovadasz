<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ShoppingCartService;
use ShoppingCart;

class ShoppingCartController extends Controller
{
    //
    protected $shoppingCartService;
    public function __construct(ShoppingCartService $shoppingCartService)
    {
        $this->shoppingCartService = $shoppingCartService;
    }

    public function addToShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateAddToShoppingCart($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $response = $this->shoppingCartService->addToShoppingCart($validator, $request->input('comment'));
        return \response()->json($response);
    }
    public function getUserShoppingCart()
    {
        $shoppingCarts = $this->shoppingCartService->getUserShoppingCart();
        return response()->json($shoppingCarts);
    }
    public function updateUserShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateEditShoppingCart($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $response = $this->shoppingCartService->editUserShoppingCart($validator, $request->input('comment'), $request->input('productId'), $request->input('id'));
        return response()->json($response);
    }
    public function deleteShoppingCart($id)
    {
        $response = $this->shoppingCartService->deleteShoppingCart($id);
        return response()->json($response);
    }
    public function addCustomShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateAddCustomShoppingCart($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $response = $this->shoppingCartService->addCustomShoppingCart($validator, $request->input('comment'));
        return response()->json($response);
    }
    public function updateCustomShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateEditShoppingCart($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $response = $this->shoppingCartService->editCustomShoppingCart($validator, $request->input('comment'), $request->input('id'));
        return response()->json($response);
    }
}
