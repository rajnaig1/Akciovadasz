<?php

class PennyGeneralRepositoryTest extends \Tests\TestCase
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
    public function testGetTotal()
    {
        $repo=new App\Repositories\Penny_General_Repository();
        $output=$repo->getTotal();
        $this->assertEquals(1,count($output));
        $this->assertEquals(543,$output[0]->Total);
    }
    public function testUpdateTotal(){

        $repo=new App\Repositories\Penny_General_Repository();
        $total=$repo->getTotal();
        $repo->updateTotal($total[0],10);
        $output=$repo->getTotal();
        $this->assertEquals(1,count($output));
        $this->assertEquals(10,$output[0]->Total);
    }
    public function testCreateTotal(){
        $repo=new App\Repositories\Penny_General_Repository();
        $total=$repo->getTotal();
        $total[0]->delete();
        $repo->createTotal(20);
        $output=$repo->getTotal();
        $this->assertEquals(1,count($output));
        $this->assertEquals(20,$output[0]->Total);
    }
    public function testWipeProducts(){
        $repo=new App\Repositories\Penny_General_Repository();
        $repo->wipeProducts();
        $output=App\Models\PennyProductModel::All();
        $this->assertEquals(0,count($output));
    }
    public function testStoreProducts(){
        $repo=new App\Repositories\Penny_General_Repository();
        $repo->wipeProducts();
        $testResponse=new App\TestDatas\Penny_TestResponse();
        $repo->storeAllProducts($testResponse->createTestProducts());
        $output=App\Models\PennyProductModel::All();
        $this->assertEquals(2,count($output));
    }
}
