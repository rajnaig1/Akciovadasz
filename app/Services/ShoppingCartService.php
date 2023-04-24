<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ShoppingCartRepository;

class ShoppingCartService
{
    protected $shoppingCartRepository;
    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }
    public function validateAddToShoppingCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop' => ['required', 'regex:/Tesco|Penny/'],
            'amount' => 'required|numeric',
            'quantity' => ['required', 'regex:/db|kg|l/'],
            'product_id' => ['required', 'unique:ShoppingCart,product_id']
        ]);
        return $validator;
    }
    public function validateAddCustomShoppingCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop' => ['required', 'regex:/Tesco|Penny|Egyéb/'],
            'amount' => 'required|numeric',
            'quantity' => ['required', 'regex:/db|kg|l/'],
        ]);
        return $validator;
    }
    public function validateEditShoppingCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop' => ['required', 'regex:/Tesco|Penny|Egyéb/'],
            'amount' => 'required|numeric',
            'quantity' => ['required', 'regex:/db|kg|l/']
        ]);
        return $validator;
    }
    public function addToShoppingCart($validator, $comment)
    {
        $shoppingCart = $validator->validate();
        $shoppingCart["comment"] = $comment;
        $shoppingCart["user_id"] = Auth::user()->id;
        $this->shoppingCartRepository->addToShoppingCart($shoppingCart);
    }
    public function addCustomShoppingCart($validator, $comment, $name)
    {
        $shoppingCart = $validator->validate();
        $shoppingCart["comment"] = $comment;
        $shoppingCart["user_id"] = Auth::user()->id;
        $this->shoppingCartRepository->addToShoppingCart($shoppingCart);
    }
    public function getUserShoppingCart()
    {
        $shoppingCarts = Auth::user()->shoppingCarts;
        $shoppingCartsArray = array();
        foreach ($shoppingCarts as $shoppingCart) {
            $shoppingCartReturn = (object)array();
            if ($shoppingCart->shop == "Tesco" && $shoppingCart->product_id != null) {
                $tescoproduct = $shoppingCart->tescoProduct;
                if ($tescoproduct->offerBegin <= \date('Y-m-d') && $tescoproduct->offerEnd >= \date('Y-m-d')) {
                    $shoppingCartReturn->id = $shoppingCart->id;
                    $shoppingCartReturn->shop = 'Tesco';
                    $shoppingCartReturn->product_id = $shoppingCart->product_id;
                    $shoppingCartReturn->name = $tescoproduct->name;
                    $shoppingCartReturn->amount = $shoppingCart->amount;
                    $shoppingCartReturn->quantity = $shoppingCart->quantity;
                    $shoppingCartReturn->price = $tescoproduct->bestPrice;
                    $shoppingCartReturn->comment = $shoppingCart->comment;
                    $shoppingCartReturn->offerBegin = $tescoproduct->offerBegin;
                    $shoppingCartReturn->offerEnd = $tescoproduct->offerEnd;
                    $shoppingCartReturn->imageURL = 'https://www.tesco-bst.com/' . $tescoproduct->imageURL;
                }
            } else if ($shoppingCart->shop == "Penny" && $shoppingCart->product_id != null) {
                $pennyproduct = $shoppingCart->pennyProduct;
                if ($pennyproduct->validityStart <= \date('Y-m-d') && $pennyproduct->validityEnd >= \date('Y-m-d')) {
                    $shoppingCartReturn->id = $shoppingCart->id;
                    $shoppingCartReturn->shop = 'Penny';
                    $shoppingCartReturn->product_id = $shoppingCart->product_id;
                    $shoppingCartReturn->name = $pennyproduct->name;
                    $shoppingCartReturn->amount = $shoppingCart->amount;
                    $shoppingCartReturn->quantity = $shoppingCart->quantity;
                    $shoppingCartReturn->price = $pennyproduct->price / 100;
                    $shoppingCartReturn->comment = $shoppingCart->comment;
                    $shoppingCartReturn->offerBegin = $pennyproduct->validityStart;
                    $shoppingCartReturn->offerEnd = $pennyproduct->validityEnd;
                    if (isset($pennyproduct->images)) {
                        $shoppingCartReturn->imageURL = $pennyproduct->images;
                    }
                }
            } else if ($shoppingCart->shop == "Penny" && $shoppingCart->product_id == null) {
                $shoppingCartReturn->id = $shoppingCart->id;
                $shoppingCartReturn->shop = 'Penny';
                $shoppingCartReturn->product_id = null;
                $shoppingCartReturn->name = "Egyedi termék";
                $shoppingCartReturn->amount = $shoppingCart->amount;
                $shoppingCartReturn->quantity = $shoppingCart->quantity;
                $shoppingCartReturn->price = "";
                $shoppingCartReturn->comment = $shoppingCart->comment;
                $shoppingCartReturn->offerBegin = "";
                $shoppingCartReturn->offerEnd = "";
                $shoppingCartReturn->imageURL = "";
            } else if ($shoppingCart->shop == "Tesco" && $shoppingCart->product_id == null) {
                $shoppingCartReturn->id = $shoppingCart->id;
                $shoppingCartReturn->shop = 'Tesco';
                $shoppingCartReturn->product_id = null;
                $shoppingCartReturn->name = "Egyedi termék";
                $shoppingCartReturn->amount = $shoppingCart->amount;
                $shoppingCartReturn->quantity = $shoppingCart->quantity;
                $shoppingCartReturn->price = "";
                $shoppingCartReturn->comment = $shoppingCart->comment;
                $shoppingCartReturn->offerBegin = "";
                $shoppingCartReturn->offerEnd = "";
                $shoppingCartReturn->imageURL = "";
            } else if ($shoppingCart->shop == "Egyéb" && $shoppingCart->product_id == null) {
                $shoppingCartReturn->id = $shoppingCart->id;
                $shoppingCartReturn->shop = 'Egyéb';
                $shoppingCartReturn->product_id = null;
                $shoppingCartReturn->name = "Egyedi termék";
                $shoppingCartReturn->amount = $shoppingCart->amount;
                $shoppingCartReturn->quantity = $shoppingCart->quantity;
                $shoppingCartReturn->price = "";
                $shoppingCartReturn->comment = $shoppingCart->comment;
                $shoppingCartReturn->offerBegin = "";
                $shoppingCartReturn->offerEnd = "";
                $shoppingCartReturn->imageURL = "";
            }
            array_push($shoppingCartsArray, $shoppingCartReturn);
        }
        return $shoppingCartsArray;
    }
    public function editUserShoppingCart($validator, $comment, $productId, $id)
    {
        $shoppingCart = $validator->validate();
        //$shoppingCart["_id"]=$id;
        $shoppingCart["comment"] = $comment;
        $shoppingCart["product_id"] = $productId;
        $shoppingCart["user_id"] = Auth::user()->id;
        $this->shoppingCartRepository->updateShoppingCart($shoppingCart, $id);
    }
    public function editCustomShoppingCart($validator, $comment, $id)
    {
        $shoppingCart = $validator->validate();
        //$shoppingCart["_id"]=$id;
        $shoppingCart["comment"] = $comment;
        $shoppingCart["user_id"] = Auth::user()->id;
        $this->shoppingCartRepository->updateShoppingCart($shoppingCart, $id);
    }
    public function deleteShoppingCart($id)
    {
        $this->shoppingCartRepository->deleteShoppingCart($id);
    }
}
