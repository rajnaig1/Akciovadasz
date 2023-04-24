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
        $productIdent = $this->mock(App\Services\Product_Ident_Service::class, function ($mock) {
            $mock->shouldReceive('identifyProduct')
                ->withArgs([])
                ->andReturn('Identified');
        });
        $repo = new App\Repositories\Penny_General_Repository($productIdent);
        $output = $repo->getTotal();
        $this->assertEquals(1, count($output));
        $this->assertEquals(543, $output[0]->Total);
    }
    public function testUpdateTotal()
    {
        $productIdent = $this->mock(App\Services\Product_Ident_Service::class, function ($mock) {
            $mock->shouldReceive('identifyProduct')
                ->withArgs([])
                ->andReturn('Identified');
        });
        $repo = new App\Repositories\Penny_General_Repository($productIdent);
        $total = $repo->getTotal();
        $repo->updateTotal($total[0], 10);
        $output = $repo->getTotal();
        $this->assertEquals(1, count($output));
        $this->assertEquals(10, $output[0]->Total);
    }
    public function testCreateTotal()
    {
        $productIdent = $this->mock(App\Services\Product_Ident_Service::class, function ($mock) {
            $mock->shouldReceive('identifyProduct')
                ->withArgs([])
                ->andReturn('Identified');
        });
        $repo = new App\Repositories\Penny_General_Repository($productIdent);
        $total = $repo->getTotal();
        $total[0]->delete();
        $repo->createTotal(20);
        $output = $repo->getTotal();
        $this->assertEquals(1, count($output));
        $this->assertEquals(20, $output[0]->Total);
    }
    public function testWipeProducts()
    {
        $productIdent = $this->mock(App\Services\Product_Ident_Service::class, function ($mock) {
            $mock->shouldReceive('identifyProduct')
                ->withArgs([])
                ->andReturn('Identified');
        });
        $repo = new App\Repositories\Penny_General_Repository($productIdent);
        $repo->wipeProducts();
        $output = App\Models\PennyProductModel::All();
        $this->assertEquals(0, count($output));
    }
    public function testStoreProducts()
    {
        $testResponse = new App\TestDatas\Penny_TestResponse();
        $productIdent = $this->mock(App\Services\Product_Ident_Service::class, function ($mock) {
            $mock->shouldReceive('identifyProduct')
                //->withArgs(['testResponse'])
                ->andReturn('identified');
        });
        $testArray = [];
        $price = (object)[];
        $regular = (object)[];
        $product = (object)[];
        $product->price = $price;
        $product->price->regular = $regular;
        $product->category = 'testCategory';
        $product->images = ['testimage'];
        $product->name = 'testName';
        $product->price->baseUnitLong = 'kilogram';
        $product->price->baseUnitShort = 'kg';
        $product->price->regular->perStandardizedQuantity = 10000;
        $product->price->regular->value = 1000;
        $product->price->validityStart = 'testdate';
        $product->price->validityEnd = 'testEndDate';
        $product->isPublished = true;
        $product->volumeLabelLong = 'testVolumeLabel';
        $product->weight = 0.1;
        $product->published = true;
        $product->productMarketing = '';
        $product->product_ident_id = '1';
        $product->priceScore = '1';
        array_push($testArray, $product);

        $price = (object)[];
        $regular = (object)[];
        $product = (object)[];
        $product->price = $price;
        $product->price->regular = $regular;
        $product->category = 'testCategory2';
        $product->images = [];
        $product->name = 'testName2';
        $product->price->baseUnitLong = 'kilogram';
        $product->price->baseUnitShort = 'kg';
        $product->price->regular->perStandardizedQuantity = 20000;
        $product->price->regular->value = 2000;
        $product->price->validityStart = 'testdate2';
        $product->price->validityEnd = 'testEndDate2';
        $product->isPublished = true;
        $product->volumeLabelLong = 'testVolumeLabel2';
        $product->weight = 0.2;
        $product->published = true;
        $product->productMarketing = '2';
        $product->product_ident_id = '2';
        $product->priceScore = '2';
        array_push($testArray, $product);
        $repo = new App\Repositories\Penny_General_Repository($productIdent);
        $repo->wipeProducts();
        $repo->storeAllProducts($testArray);
        $output = App\Models\PennyProductModel::All();
        $this->assertEquals(2, count($output));
    }
}
