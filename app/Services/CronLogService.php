<?php 
namespace App\Services;
use App\Wrappers\Wrappers;
class CronLogService{
   protected $wrapper;
   public function __construct(Wrappers $wrapper){
    $this->wrapper=$wrapper;
   }
    public function getCronLog(){
        $loglocation = env("CRON_LOG", "somedefaultvalue");
        $logCollection = [];
        if($this->wrapper->file_existsWrapper($this->wrapper->storage_pathWrapper().'/logs/'.$loglocation)){
        $logFile = $this->wrapper->fileWrapper($this->wrapper->storage_pathWrapper().'/logs/'.$loglocation);
        // Loop through an array, show HTML source as HTML source; and line numbers too.
        $singleLog=(object) [];
        $i=0;
        foreach ($logFile as $line_num => $line) {
           if(trim($line)=='End'){
            $logCollection[$i]=$singleLog;
            $singleLog=(object) [];
            $i++;
           }else if(($line_num>0&&trim($logFile[$line_num-1])=='End')||$line_num==0){
            $singleLog->time=htmlspecialchars($line);
           }else if(($line_num>1&&trim($logFile[$line_num-2])=='End')||$line_num==1){
            $singleLog->runner=htmlspecialchars($line);
           }else if(($line_num>2&&trim($logFile[$line_num-3])=='End')||$line_num==2){
            $singleLog->job=htmlspecialchars($line);
           }else if((trim($logFile[$line_num])=='Success')){
           $singleLog->success=htmlspecialchars($line);
           }else if(trim($logFile[$line_num])=='File'){
            $singleLog->success='failure';
            $singleLog->file=$logFile[$line_num+1];
           }else if(trim($logFile[$line_num])=='Line'){
            $singleLog->line=$logFile[$line_num+1];
           }else if(trim($logFile[$line_num])=='Message'){
            $singleLog->message=$logFile[$line_num+1];
            $singleLog->stackTrace='See in log';
           }
        }
    }
        return $logCollection;
    }
    public function writeManualLog($response,$shop){
        $loglocation = env("CRON_LOG", "somedefaultvalue");
        $logfile = $this->wrapper->fOpenWrapper($this->wrapper->storage_pathWrapper().'/logs/'.$loglocation, "a");
        $txt = $this->wrapper->nowWrapper()."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "Manual\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = $shop."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
        if($response=='Success'){
            $txt = $response."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "End\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
        }else{
            $txt = "File\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = $response->getFile()."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "Line\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = $response->getLine()."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "Message\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = $response->getMessage()."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "StackTrace\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = $response->getTraceAsString()."\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
            $txt = "End\n";
            $this->wrapper->fwriteWrapper($logfile,$txt);
        }
        $this->wrapper->fcloseWrapper($logfile);
        if($response=='Success'){
            return $response;
        }else{
            return 'failure';
        }
    }
}
