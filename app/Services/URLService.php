<?php
namespace App\Services;
use App\Repositories\URLRepository;
class URLService{
    protected $urlRepo;
    public function __construct(URLRepository $urlRepo){
        $this->urlRepo=$urlRepo;
    }
    public function getPenny($pageNumber,$pageSize){
        $pennyURL=$this->urlRepo->getPenny()->URL;
        return sprintf($pennyURL,$pageNumber,$pageSize);
    }
    public function getTesco(){
        $tescoURL=$this->urlRepo->getTesco()->URL;
        return $tescoURL;
    }
}
