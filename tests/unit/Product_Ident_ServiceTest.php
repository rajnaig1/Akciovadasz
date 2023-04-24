<?php

use Codeception\Codecept;

class Product_Ident_ServiceTest extends \Codeception\Test\Unit
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
    public function testidentifyproductWithEmpyRegex()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->regex = '';
                return [
                    $testObject,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(1, $productObject->product_ident_id);
        $this->assertEquals(1000000, $productObject->priceScore);
    }
    public function testidentifyproductWithNotMatchingRegex()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->regex = '';
                $testObject2 = (object)[];
                $testObject2->regex = '/testRegex/';
                return [
                    $testObject, $testObject2,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(1, $productObject->product_ident_id);
        $this->assertEquals(1000000, $productObject->priceScore);
    }
    public function testidentifyproductWithMatchingRegex()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->id = 2;
                $testObject->regex = '/testname/';
                return [
                    $testObject,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(2, $productObject->product_ident_id);
        $this->assertEquals(1000000, $productObject->priceScore);
    }
    public function testidentifyproductWithMatchingRegexMagyarCharactersInCapital()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->id = 2;
                $testObject->regex = '/árvíztűrő tükörfúrógép/';
                return [
                    $testObject,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'ÁRVÍZTŰRŐ TÜKÖRFÚRÓGÉP';
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(2, $productObject->product_ident_id);
        $this->assertEquals(1000000, $productObject->priceScore);
    }
    public function testidentifyproductWithMatchingRegexTescoBestUnitPriceEmpty()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->id = 2;
                $testObject->regex = '/testname/';
                $testObject->basePrice = 1000;
                return [
                    $testObject,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productObject->bestUnitPrice = '';
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(2, $productObject->product_ident_id);
        $this->assertEquals(1000000, $productObject->priceScore);
    }
    public function testidentifyproductWithMatchingRegexTesco()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->id = 2;
                $testObject->regex = '/testname1/';
                $testObject->basePrice = 10;

                $testObject2 = (object)[];
                $testObject2->id = 2;
                $testObject2->regex = '/testname2/';
                $testObject2->basePrice = 100;
                $testObject3 = (object)[];
                $testObject3->id = 3;
                $testObject3->regex = '/testname/';
                $testObject3->basePrice = 1000;

                $testObject4 = (object)[];
                $testObject4->id = 4;
                $testObject4->regex = '/testname4/';
                $testObject4->basePrice = 10000;
                return [
                    $testObject, $testObject2, $testObject3, $testObject4,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productObject->bestUnitPrice = 100;
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(3, $productObject->product_ident_id);
        $this->assertEquals(0.1, $productObject->priceScore);
    }
    public function testidentifyproductWithNotMatchingRegexTesco()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->regex = '';
                $testObject->basePrice = 10;
                $testObject2 = (object)[];
                $testObject2->regex = '/testRegex/';
                return [
                    $testObject, $testObject2,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $productObject->name = 'testName';
        $productObject->bestUnitPrice = 100;
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(1, $productObject->product_ident_id);
        $this->assertEquals(10, $productObject->priceScore);
    }
    public function testidentifyproductWithMatchingRegexPenny()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->id = 2;
                $testObject->regex = '/testname1/';
                $testObject->basePrice = 10;

                $testObject2 = (object)[];
                $testObject2->id = 2;
                $testObject2->regex = '/testname2/';
                $testObject2->basePrice = 100;
                $testObject3 = (object)[];
                $testObject3->id = 3;
                $testObject3->regex = '/testname/';
                $testObject3->basePrice = 1000;

                $testObject4 = (object)[];
                $testObject4->id = 4;
                $testObject4->regex = '/testname4/';
                $testObject4->basePrice = 10000;
                return [
                    $testObject, $testObject2, $testObject3, $testObject4,
                ];
            }]
        );
        //$productObject->priceScore = ($productObject->price->regular->perStandardizedQuantity
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $regular = (object)['perStandardizedQuantity' => 10000];
        $price = (object)['regular' => $regular];
        $productObject->name = 'testName';
        $productObject->price = $price;
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(3, $productObject->product_ident_id);
        $this->assertEquals(0.1, $productObject->priceScore);
    }
    public function testidentifyproductWithNotMatchingRegexPenny()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProductIdent' => function () {
                $testObject = (object)[];
                $testObject->regex = '';
                $testObject->basePrice = 10;
                $testObject2 = (object)[];
                $testObject2->regex = '/testRegex/';
                return [
                    $testObject, $testObject2,
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);
        $productObject = (object)array();
        $regular = (object)['perStandardizedQuantity' => 10000];
        $price = (object)['regular' => $regular];
        $productObject->name = 'testName';
        $productObject->price = $price;
        $productIdentService->identifyProduct($productObject);
        $this->assertEquals(1, $productObject->product_ident_id);
        $this->assertEquals(10, $productObject->priceScore);
    }
    public function testgetproductsPenny()
    {
        $productIdents = $this->make(
            App\Repositories\Product_Ident_Repository::class,
            ['getAllProducts' => function () {
                $testArray = [];
                $productObject = (object)array();
                $productIdentObject = (object)array();

                $productObject->name = 'testPenny';
                $productObject->unitShort = 'kg';
                $productObject->unitPrice = 10000; //($prod->unitPrice/100);
                $productObject->price = 1000; //($prod->price/100);
                $productObject->validityStart = \date('Y-m-d');
                $productObject->validityEnd = \date('Y-m-d');
                $productObject->priceScore = 0;
                $productObject->images = 'testImage';

                $union = (object)['union' => $productObject];
                $productIdentObject->union = $union;
                array_push($testArray, $productObject);
                return [
                    $productIdentObject
                ];
            }]
        );
        $productIdentService = new App\Services\Product_Ident_Service($productIdents);

        $result = $productIdentService->getProducts();
        $this->assertEquals(1, $productObject->product_ident_id);
        $this->assertEquals(10, $productObject->priceScore);
    }
    private function original()
    {
        /* $idents = $this->productIdents->getAllProductIdent();
        foreach ($idents as $ident) {
            if ($ident->regex != '') {
                if (\preg_match($ident->regex, mb_strtolower($productObject->name))) {
                    $productObject->product_ident_id = $ident->id;
                    $this->priceScoreCalculator($ident, $productObject);
                    return;
                }
            } else {
                $this->priceScoreCalculator($ident, $productObject);
            }
        }
        //Az egyéb termékkategória
        $productObject->product_ident_id = 1;
        return;*/
    }
}
