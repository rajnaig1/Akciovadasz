<?php 
namespace App\Cron_Jobs;
use App\Services\TescoService;
use Exception;

class TescoCron{
    protected $tescoService;
    public function __construct(TescoService $tescoService)
    {
        $this->tescoService = $tescoService;
    }
        /**
     * Define the application's command schedule.
     */
    public function uploadDataBase(){
        try{
            $this->tescoService->storeTesco();
            return 'Success';
        }catch(Exception $e){
            return $e;
        }
    }
}
