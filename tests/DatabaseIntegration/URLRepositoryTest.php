<?php

class URLRepositoryTest extends \Tests\TestCase
{
    //HASZNÁLD A TESTS/TESTCASET
    /**
     * @var \Database_Integration_Tester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGetPennyURL()
    {
        $urlRepo=new \App\Repositories\URLRepository();
        $output=$urlRepo->getPenny();
        $this->assertEquals('http://localhost/Mestermunka/Git/laravel_mongoCRUD/public/api/pennytestresponse',$output->URL);
    }
}