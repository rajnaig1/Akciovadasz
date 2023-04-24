<?php

namespace App\Http\Controllers;

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
    public function tescoManualUpdate()
    {
        $response = $this->tescoCron->uploadDataBase();
        $response = $this->cronLogService->writeManualLog($response, 'Tesco');
        $formatted = (object)[];
        $formatted->response = $response;
        $formatted->Shop = "Tesco";
        return redirect('/admin')->with('status', $formatted);
    }
    //
    public function pennyManualUpdate()
    {
        $response = $this->pennyCron->uploadDataBase();
        $response = $this->cronLogService->writeManualLog($response, 'Penny');
        $formatted = (object)[];
        $formatted->response = $response;
        $formatted->Shop = "Penny";
        return redirect('/admin')->with('status', $formatted);
    }
    public function getUploadLogs()
    {
        $logCollection = $this->cronLogService->getCronLog();
        return view('admin.index', compact('logCollection'));
    }
    public function getPennyDatas(Request $request)
    {
        $paginator = 5;
        $products = $this->pennyService->getAllStoredPennyProducts($paginator, null, null, null);
        return view('admin.pennyeditor', compact('products'));
    }
    public function getPennyDatasOrdered(Request $request)
    {
        $paginator = 5;
        if ($request->ajax()) {
            $orderBy = $request->get('sortby');
            $sortDirection = $request->get('sorttype');
            $query = $request->get('query');
            $products = $this->pennyService->getAllStoredPennyProducts($paginator, $orderBy, $sortDirection, $query);
            return view('admin.pennyeditortabledatas', compact('products'));
        }
    }
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
    /**
     * Healthcheck
     *
     * Check that the service is up. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
     *
     * @response 400 scenario="Service is unhealthy" {"status": "down", "services": {"database": "up", "redis": "down"}}
     * @responseField status The status of this API (`up` or `down`).
     * @responseField services Map of each downstream service and their status (`up` or `down`).
     */
    public function pennyTestResponseController()
    {
        $testResponse = new Penny_TestResponse();
        return response()->json($testResponse->testResultsPlusTotal());
    }
    public function tescoTestResponseController()
    {
        $productObject = (object)array();
        $productObject->template = 'testTemplate';
        $productObject->name = 'testName';
        $productObject->url = 'testURL';
        $productObject->active = 'true';
        $productObject->offerBegin = 'testdate';
        $productObject->offerEnd = 'testDate';
        $productObject->imageURL = 'testImageURL';
        $productObject->unit = 'kg';
        $productObject->bestUnitPrice = 100;
        $productObject->bestPrice = 1000;
        $productObject->comment = 'testComment';
        return response()->json($productObject);
    }
}
