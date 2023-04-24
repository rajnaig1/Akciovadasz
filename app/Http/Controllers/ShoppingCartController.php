<?php

namespace App\Http\Controllers;

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
            return back()->with('shoppingCartfailure', 'shoppingCartFailure')->withErrors($validator);
        }
        $this->shoppingCartService->addToShoppingCart($validator, $request->input('comment'));
        return redirect('/')->with('status', 'success');
    }
    public function getUserShoppingCart()
    {
        $shoppingCarts = $this->shoppingCartService->getUserShoppingCart();
        return view('shoppingcart.shoppingcart', compact('shoppingCarts'));
    }
    public function updateUserShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateEditShoppingCart($request);
        if ($validator->fails()) {
            return back()->with('shoppingCartfailure', 'shoppingCartFailure')->withErrors($validator);
        }
        $this->shoppingCartService->editUserShoppingCart($validator, $request->input('comment'), $request->input('productId'), $request->input('id'));
        return redirect('/getshoppingcart')->with('status', 'success');
    }
    public function deleteShoppingCart($id)
    {
        $this->shoppingCartService->deleteShoppingCart($id);
        return redirect('/getshoppingcart')->with('status', 'success');
    }
    public function addCustomShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateAddCustomShoppingCart($request);
        if ($validator->fails()) {
            return back()->with('shoppingCartfailure', 'shoppingCartFailure')->withErrors($validator);
        }
        $this->shoppingCartService->addCustomShoppingCart($validator, $request->input('comment'), $request->input('name'));
        return redirect('/getshoppingcart')->with('status', 'success');
    }
    public function updateCustomShoppingCart(Request $request)
    {
        $validator = $this->shoppingCartService->validateEditShoppingCart($request);
        if ($validator->fails()) {
            return back()->with('shoppingCartfailure', 'shoppingCartFailure')->withErrors($validator);
        }
        $this->shoppingCartService->editCustomShoppingCart($validator, $request->input('comment'), $request->input('id'));
        return redirect('/getshoppingcart')->with('status', 'success');
    }
}
