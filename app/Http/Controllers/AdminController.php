<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CronLogService;
use App\Cron_Jobs\PennyCron;
use App\TestDatas\Penny_TestResponse;

class AdminController extends Controller
{
    protected $cronLogService;
    protected $pennyCron;
    public function __construct(CronLogService $cronLogService,PennyCron $pennyCron){
        $this->cronLogService=$cronLogService;
        $this->pennyCron=$pennyCron;
    }
    
    //
    public function pennyManualUpdate(){
        $response=$this->pennyCron->uploadDataBase();
        $response=$this->cronLogService->writeManualLog($response,'Penny');
        $formatted=(object)[];
        $formatted->response=$response;
        $formatted->Shop="Penny";
        return redirect('/admin')->with('status', $formatted);
    }
    public function getUploadLogs(){
        $logCollection=$this->cronLogService->getCronLog();
        return view('admin.index',compact('logCollection'));
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
    public function pennyTestResponseController(){
        $testResponse=new Penny_TestResponse();
        return response()->json($testResponse->testResultsPlusTotal());
    }
}
