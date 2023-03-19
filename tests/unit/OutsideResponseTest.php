<?php

class OutsideResponseTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testPennyTotal()
    {
        //Given
        $url = $this->make(App\Services\URLService::class, ['getPenny' => function () {
            return 'Url success';
        }]);
        $http = $this->make(App\Outside_Resources\HTTPConnection::class, ['get' => function () {
            $testObject = (object) array('test1' => '1', 'total' => 2, 'test3' => 3);
            $testJSON = json_encode($testObject);
            return $testJSON;
        }]);
        $json = new App\Parsers\JSONParser();
        $outsideResponse = new App\Outside_Resources\OutsideResponse($url, $json, $http);
        //when
        $result = $outsideResponse->pennyTotal();
        //then
        $this->assertEquals('2', $result);
    }
    public function testPennyAllProducts()
    {
        //Given
        $url = $this->make(App\Services\URLService::class, ['getPenny' => function () {
            return 'Url success';
        }]);
        $http = $this->make(App\Outside_Resources\HTTPConnection::class, ['get' => function () {
            $testObject = (object) array('results' => '1', 'test2' => 2, 'test3' => 3);
            $testJSON = json_encode($testObject);
            return $testJSON;
        }]);
        $json = new App\Parsers\JSONParser();
        $outsideResponse = new App\Outside_Resources\OutsideResponse($url, $json, $http);
        $pagesize = 1;
        $batchSize = 100;
        //when
        $result = $outsideResponse->pennyAllProducts($pagesize, $batchSize);
        //then
        $this->assertEquals('1', $result);
    }
    public function testTescoTotal(){
        $url = $this->make(App\Services\URLService::class, ['getTesco' => function () {
            return 'Url success';
        }]);
        $http = $this->make(App\Outside_Resources\HTTPConnection::class, ['get' => function () {
            $testObject = (object) array('test1' => '1', 'test2' => 2, 'test3' => 3);
            $testJSON = json_encode($testObject);
            return $testJSON;
        }]);
        $json = new App\Parsers\JSONParser();
        $outsideResponse = new App\Outside_Resources\OutsideResponse($url, $json, $http);
        //when
        $result = $outsideResponse->tescoTotal();
        //then
        $this->assertEquals('1', $result->test1); 
        $this->assertEquals('2', $result->test2);
        $this->assertEquals('3', $result->test3);  
    }
}
