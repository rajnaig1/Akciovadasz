<?php 
namespace App\Wrappers;
class Wrappers{
    public function fileWrapper($path){
        return file($path);
    }
    public function storage_pathWrapper(){
        return storage_path();
    }
    public function fOpenWrapper($path,$writeMode){
        $logfile=fopen($path,$writeMode)or die("Unable to open file!");
    return $logfile;
    }
    public function nowWrapper(){
        return \now();
    }
    public function fwriteWrapper($file,$text){
        fwrite($file, $text);
    }
    public function fcloseWrapper($file){
        fclose($file);
    }
    public function file_existsWrapper($file){
        return \file_exists($file);
    }
}
?>