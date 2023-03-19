<?php

namespace App\Http\Controllers;

use App\Services\PennyService;
use App\Services\TescoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\URLRepository;
use App\Repositories\Penny_General_Repository;


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

    public function __construct(TescoService $pennyService)
    {
        $this->pennyService = $pennyService;
    }


    public function index()
    {
        $repo= new Penny_General_Repository();
        $output= $repo->createTotal(15);
        dd($output);
    }
    public function uploadProducts()
    {
        //dd($this->pennyService->storeAllProducts());
    }
}
