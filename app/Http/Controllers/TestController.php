<?php

namespace App\Http\Controllers;

use App\Services\PennyService;
use App\Services\TescoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\URLRepository;
use App\Repositories\Penny_General_Repository;
use App\Services\Product_Ident_Service;
use ProductIdent;

class TestController extends Controller
{
    protected $pennyService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */

    public function __construct(Product_Ident_Service $pennyService)
    {
        $this->pennyService = $pennyService;
    }


    public function index()
    {

        //dd(\date('Y-m-d'));
        $productArray = [];
        $products = $this->pennyService->getProducts();
        foreach ($products as $product) {
            array_push($productArray, $product);
            //foreach($product->storage as $prod){


            //}
            /*foreach($product->Union as $prod){
            //array_push($productArray,$prod);
            
            }*/
            //array_push($productArray,$product);
        }
        dd($productArray);
        //$output= $repo->createTotal(15);
        //dd($output);
    }
    public function uploadProducts()
    {
        //dd($this->pennyService->storeAllProducts());
    }
}
