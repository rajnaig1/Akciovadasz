<?php
class TescoRepositoryTest extends \Tests\TestCase
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

    public function testStoreProducts()
    {
        $productObject = (object)array();
        $productObject->template = 'testTemplate';
        $productObject->name = 'testName';
        $productObject->url = 'testURL';
        $productObject->active = 'true';
        $productObject->offerBegin = 'testdate';
        $productObject->offerEnd = 'testDate';
        $productObject->imageURL = 'testImageURL';
        $productObject->unit = 'kg';
        $productObject->bestUnitPrice = 100;
        $productObject->bestPrice = 1000;
        $productObject->comment = 'testComment';
        $productObject->product_ident_id = 1;
        $productObject->priceScore = 1;
        $repo = new App\Repositories\TescoRepository();
        $repo->wipeProducts();
        $repo->storeProduct($productObject);
        $output = App\Models\TescoModel::All();
        $this->assertEquals(1, count($output));
        $this->assertEquals('testURL', $output[0]->url);
    }
    public function testWipeProducts()
    {
        $repo = new App\Repositories\TescoRepository();
        $repo->wipeProducts();
        $output = App\Models\TescoModel::All();
        $this->assertEquals(0, count($output));
    }
}
