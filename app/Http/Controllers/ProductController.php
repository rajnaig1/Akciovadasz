<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Product_Ident_Service;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use ProductIdent;

class ProductController extends Controller
{
    protected $produtctIdentService;
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

    public function __construct(Product_Ident_Service $productIdentService)
    {
        $this->produtctIdentService = $productIdentService;
    }
    public function index()
    {
        $products = $this->produtctIdentService->getProducts();
        $products = $this->paginate($products);
        return view('products.index', compact('products'));
    }
    public function queryProducts(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $products = $this->produtctIdentService->getQueriedResults($query);
            $products = $this->paginate($products);
            return view('products.indexcontent', compact('products'));
        }
    }
    public function paginate($items, $perPage = 6, $page = null, $options = [])

    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
