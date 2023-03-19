<?php

class JSONParserTest extends \Codeception\Test\Unit
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
    public function testJSONParserPennyTotal()
    {
        //given
        $testObject = (object)array('test1' => '1', 'test2' => '2', 'total' => 3);
        $testJSON = json_encode($testObject);
        $jsonParser = new App\Parsers\JSONParser();
        $result = $jsonParser->pennyTotal($testJSON);
        $this->assertEquals(3, $result);
    }
    public function testPennyProductParser()
    {
        //given
        $testObject = (object)array('test1' => '1', 'results' => '2', 'test3' => 3);
        $testJSON = json_encode($testObject);
        $jsonParser = new App\Parsers\JSONParser();
        $result = $jsonParser->pennyProductParser($testJSON);
        $this->assertEquals(2, $result);
    }
    public function testTescoParser(){
        $testObject = (object)array('test1' => '1', 'test2' => '2', 'test3' => 3);
        $testJSON = json_encode($testObject);
        $jsonParser = new App\Parsers\JSONParser();
        $result = $jsonParser->tescoParser($testJSON);
        $this->assertEquals(1, $result->test1);
        $this->assertEquals(2, $result->test2);
        $this->assertEquals(3, $result->test3);
    }
}
