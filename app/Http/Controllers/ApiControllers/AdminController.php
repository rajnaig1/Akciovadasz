<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CronLogService;
use App\Cron_Jobs\PennyCron;
use App\Cron_Jobs\TescoCron;
use App\TestDatas\Penny_TestResponse;
use App\Services\PennyService;

class AdminController extends Controller
{
    protected $cronLogService;
    protected $pennyCron;
    protected $tescoCron;
    protected $pennyService;
    public function __construct(CronLogService $cronLogService, PennyCron $pennyCron, TescoCron $tescoCron, PennyService $pennyService)
    {
        $this->cronLogService = $cronLogService;
        $this->pennyCron = $pennyCron;
        $this->tescoCron = $tescoCron;
        $this->pennyService = $pennyService;
    }


    public function getUploadLogs()
    {
        $logCollection = $this->cronLogService->getCronLog();
        return response()->json($logCollection);
    }
    public function getPennyDatas(Request $request)
    {
        $paginator = 5;
        $products = $this->pennyService->getAllStoredPennyProducts($paginator, null, null, null);
        return response()->json($products);
    }
    public function getPennyDatasOrdered(Request $request)
    {
        $paginator = 5;
        $orderBy = $request->get('sortby');
        $sortDirection = $request->get('sorttype');
        $query = $request->get('query');
        $products = $this->pennyService->getAllStoredPennyProducts($paginator, $orderBy, $sortDirection, $query);
        return response()->json($products);
    }
    //Ezeket nem lenne még szerencsé endpointon keresztül felülírni
    public function updatePennyProduct(Request $request)
    {
        $validator = $this->pennyService->validateUpdatePennyProduct($request);
        if ($validator->fails()) {
            return back()->with('pennyUpdatefailure', 'pennyUpdateFailure')->withErrors($validator);
        }
        $this->pennyService->updatePennyProduct($request->input('id'), $validator);
        return redirect('/admin/getpennydatas')->with('status', 'success');
    }
    public function deletePennyProduct($id)
    {
        $this->pennyService->deleteProduct($id);
        return redirect('/admin/getpennydatas')->with('status', 'success');
    }
}
