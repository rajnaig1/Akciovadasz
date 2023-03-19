<?php 
namespace App\Cron_Jobs;
use App\Services\PennyService;
use Exception;

class PennyCron{
    protected $pennyService;
    public function __construct(PennyService $pennyService)
    {
        $this->pennyService = $pennyService;
    }
        /**
     * Define the application's command schedule.
     */
    public function uploadDataBase(){
        try{
            $this->pennyService->upsertTotalProductNumber();
            $this->pennyService->storeAllProducts();
            return 'Success';
        }catch(Exception $e){
            return $e;
        }
    }
}
?>