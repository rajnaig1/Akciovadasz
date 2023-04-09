<?php

use Codeception\Codecept;
use Tests\TestUtilities;

class TescoServiceTest extends \Codeception\Test\Unit
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
    public function teststoreTescoIfHasNextIsTrueThenItThrowsException()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            [
                'tescoTotal' => function () {
                    return (object) array('hasNext' => 'true',);
                }
            ]
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            [
                'wipeProducts' => function () {
                    return 'wiped';
                },
                'storeProducts' => function () {
                    return 'stored';
                }
            ]
        );
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $exception = '';
        try {
            $tescoService->storeTesco();
        } catch (Exception $e) {
            $exception = $e;
        }
        //Then
        $this->assertEquals('There are more products than queried', $exception->getMessage());
    }
    public function teststoreTescoIfThereAreUnprocessedProductsThrowsException()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            [
                'tescoTotal' => function () {
                    return (object) array('hasNext' => 'false', 'nextProductsQty' => '10');
                }
            ]
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            [
                'wipeProducts' => function () {
                    return 'wiped';
                },
                'storeProducts' => function () {
                    return 'stored';
                }
            ]
        );
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $exception = '';
        try {
            $tescoService->storeTesco();
        } catch (Exception $e) {
            $exception = $e;
        }
        //Then
        $this->assertEquals('There are more products than queried', $exception->getMessage());
    }
    public function teststoreTescoIfThereIsNonExistingTemplateThrowsException()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            [
                'tescoTotal' => function () {
                    $type = 'NonExistentType';
                    $template = (object) array('type' => $type);
                    $data = (object) array('template' => $template);
                    $products = array((object) array('data' => $data, 'name' => 'testName', 'url' => 'testUrl', 'active' => false, 'offerbegin' => 'date', 'offerend' => 'date', 'imageurl' => 'image'));
                    return (object) array('hasNext' => false, 'nextProductsQty' => 0, 'products' => $products);
                }
            ]
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            [
                'wipeProducts' => function () {
                    return 'wiped';
                },
                'storeProducts' => function () {
                    return 'stored';
                }
            ]
        );
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $exception = '';
        try {
            $tescoService->storeTesco();
        } catch (Exception $e) {
            $exception = $e;
        }
        //Then
        $this->assertEquals('Tesco Ismeretlen termékkategória', $exception->getMessage());
    }
    public function testcheckIfNextProductQuantityIfNextProductquantityIsZeroReturnsTrue()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $tesco = (object) array('hasNext' => 'false', 'nextProductsQty' => '0');
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        $checkIfNextProductQuantityIsFalse = TestUtilities::getMethod($tescoService, 'checkIfNextProductQuantityIsFalse');
        //When
        $output = $checkIfNextProductQuantityIsFalse->invokeArgs($tescoService, array($tesco));

        //Then
        $this->assertEquals(true, $output);
    }
    public function testcheckIfNextProductQuantityIfNextProductquantityIsNotZeroReturnsFalse()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $tesco = (object) array('hasNext' => 'false', 'nextProductsQty' => '10');
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        $checkIfNextProductQuantityIsFalse = TestUtilities::getMethod($tescoService, 'checkIfNextProductQuantityIsFalse');
        //When
        $output = $checkIfNextProductQuantityIsFalse->invokeArgs($tescoService, array($tesco));

        //Then
        $this->assertEquals(false, $output);
    }
    public function testgeneralObjectProperties()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $product = (object) array('name' => 'testName', 'url' => 'testUrl', 'active' => false, 'offerbegin' => 'date', 'offerend' => 'date', 'imageurl' => 'image');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $generalObjectProperties = TestUtilities::getMethod($tescoService, 'generalObjectProperties');

        $generalObjectProperties->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('testName', $productObject->name);
        $this->assertEquals('testUrl', $productObject->url);
        $this->assertEquals(false, $productObject->active);
        $this->assertEquals('date', $productObject->offerBegin);
        $this->assertEquals('date', $productObject->offerEnd);
        $this->assertEquals('image', $productObject->imageURL);
    }
    public function testhandlexplusone()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $type = 'NonExistentType';
        $templateData = (object) array('unit' => 'testUnit', 'price' => 'testPrice');
        $template = (object) array('type' => $type, 'data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla,balbla,3292 Ft/1 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleXplusOne = TestUtilities::getMethod($tescoService, 'handleXPlusOne');

        $handleXplusOne->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('testUnit vásárlása esetén', $productObject->comment);
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('3292', $productObject->bestUnitPrice);
        $this->assertEquals('testPrice', $productObject->bestPrice);
    }
    public function testunitmatcherForKilogram()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $matches = array(array('50 kg'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $matches = array(array('50kg'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
    }
    public function testunitmatcherForLiter()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $matches = array(array('50 l'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $matches = array(array('50l'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
    }
    public function testunitmatcherForGramm()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $matches = array(array('50 g'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $matches = array(array('50g'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
    }
    public function testunitmatcherForDarab()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $matches = array(array('50 db'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $matches = array(array('50db'));
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitMatcher = TestUtilities::getMethod($tescoService, 'unitMatcher');

        $unitMatcher->invokeArgs($tescoService, array($matches, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
    }
    public function testunitPriceGrammMatcher()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $matches = array(array('250 g'));
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitPriceGrammMatcher = TestUtilities::getMethod($tescoService, 'unitPriceGrammMatcher');

        $conversionFactor = $unitPriceGrammMatcher->invokeArgs($tescoService, array($matches));
        //Then
        $this->assertEquals(4, $conversionFactor);
        $matches = array(array('500g'));
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitPriceGrammMatcher = TestUtilities::getMethod($tescoService, 'unitPriceGrammMatcher');

        $conversionFactor = $unitPriceGrammMatcher->invokeArgs($tescoService, array($matches));
        //Then
        $this->assertEquals(2, $conversionFactor);
    }
    public function testclubCardUnitPriceValNotEmpty()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $clubcard = array('si-unit-price' => (object)array('val' => 500, 'list' => ''), 'price' => 50);
        $data = array('unit' => 1);
        $product = array('description' => 'blabla');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $clubCardUnitPrice = TestUtilities::getMethod($tescoService, 'clubCardUnitPrice');

        $clubCardUnitPrice->invokeArgs($tescoService, array($clubcard, $data, $product, $productObject));
        //Then
        $this->assertEquals(500, $productObject->bestUnitPrice);
        $this->assertEquals(50, $productObject->bestPrice);
    }
    public function testclubCardUnitPriceListNotEmpty()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array('unit' => 1);
        $product = array('description' => 'blabla');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $clubCardUnitPrice = TestUtilities::getMethod($tescoService, 'clubCardUnitPrice');

        $clubCardUnitPrice->invokeArgs($tescoService, array($clubcard, $data, $product, $productObject));
        //Then
        $this->assertEquals(5000, $productObject->bestUnitPrice);
        $this->assertEquals(70, $productObject->bestPrice);
    }
    public function testhandleCheapestForFree()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $product = (object)array();
        $product->description = 'blabla';
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleCheapestForFree = TestUtilities::getMethod($tescoService, 'handleCheapestForFree');

        $output = $handleCheapestForFree->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals("Not implemented", $output->unit);
        $this->assertEquals("blabla", $output->comment);
    }
    public function testunitGivenInJsonClubcardWithKg()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        //$data = (array)($product->data->template->data);
        $templateData = (object) array('unit' => 'kg', 'price' => 'testPrice');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
    }
    public function testunitGivenInJsonClubcardWithDarabReturnsDb()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('unit' => 'db', 'price' => 'testPrice');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
    }
    public function testunitGivenInJsonClubcardWithDarabtolReturnsDb()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('unit' => 'db-tól', 'price' => 'testPrice');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
    }
    public function testunitGivenInJsonClubcardWithDarabtolUsesSiUnit()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('unit' => 'db-tól', 'price' => 'testPrice');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array('si-unit' => '1 l');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $data = array('si-unit' => '1l');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
    }
    public function testunitGivenInJsonClubcardWithCsomagUsesSiUnit()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('unit' => 'cs', 'price' => 'testPrice');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => '5000,blablabla'), 'price' => 70);
        $data = array('si-unit' => '1 l');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $data = array('si-unit' => '1l');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
    }
    public function testunitGivenInJsonClubcardWithCsomagPriceCalculatedForDarab()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('unit' => 'cs', 'price' => '900');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '30 db/cs';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => ''), 'price' => 900);
        $data = array('si-unit' => '');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $unitGivenInJsonClubcard = TestUtilities::getMethod($tescoService, 'unitGivenInJsonClubcard');

        $unitGivenInJsonClubcard->invokeArgs($tescoService, array($data, $clubcard, $product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('30', $productObject->bestUnitPrice);
    }
    public function testhandleBlueCardUnitSet()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('unit' => 'db', 'price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandleBlueCardSiUnitSetKg()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('si-unit' => 'kg', 'price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandleBlueCardSiUnitSetKgWith_1_KgFormat()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('si-unit' => '1 kg', 'price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandleBlueCardSiUnitNotSetKgSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1 kg', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10 kg', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10kg', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 kg', $productObject->comment);
    }
    public function testhandleBlueCardSiUnitNotSetLiterSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1 l', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10 l', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10l', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '5000');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 l', $productObject->comment);
    }
    public function testhandleBlueCardSiUnitNotSetGrammSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1 g', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10 g', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 g', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1000 g', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1g', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10g', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100g', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1000g', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testhandleBlueCardSiUnitNotSetDarabSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('1 db', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('10 db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '100');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('100 db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('100', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('1db', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('10db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '100');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('100db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('100', $productObject->bestPrice);
    }
    public function testhandleBlueCardNoUnitNoSIUNITGivenInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testhandleBlueCardSiUnitNotSetMilliliterSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1 ml', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10 ml', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 ml', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1000 ml', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1ml', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10ml', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100ml', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => 'testPrice', 'clubcard-price' => $clubcard);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleBlueCard');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1000ml', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testhandleNormalPriceUnitSet()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('unit' => 'db', 'price' => '5000', "si-unit-price" => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandlenormalpriceSiUnitSetKg()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('si-unit' => 'kg', 'price' => '5000', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandlenormalpriceSiUnitSetKgWith_1_KgFormat()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        //$clubcard=(object)array('si-unit-price'=>$siunitprice,'price'=>'5000');
        $templateData = (object) array('si-unit' => '1 kg', 'price' => '5000', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);
    }
    public function testhandlenormalpriceSiUnitNotSetKgSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        //$clubcard=(object)array('si-unit-price'=>$siunitprice,'price'=>'5000');
        $templateData = (object) array('price' => '5000', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1 kg', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => '5000', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10 kg', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => 'testPrice', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10kg', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => 'testPrice', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 kg', $productObject->comment);
    }
    public function testhandlenormalpriceSiUnitNotSetLiterSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => '5000', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1 l', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('5000', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => 'testPrice', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10 l', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => 'testPrice', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10l', $productObject->comment);

        $siunitprice = (object)array('val' => '10000');
        $templateData = (object) array('price' => 'testPrice', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 l', $productObject->comment);
    }
    public function testhandlenormalpriceSiUnitNotSetGrammSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1 g', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10 g', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 g', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000 g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1000 g', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1g', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('10g', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100g', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000g';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('1000g', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testhandlenormalpriceSiUnitNotSetDarabSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('1 db', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('10 db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '100', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('100 db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('100', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('1db', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('10db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '100', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100db';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('100db', $productObject->comment);
        $this->assertEquals('1', $productObject->bestUnitPrice);
        $this->assertEquals('100', $productObject->bestPrice);
    }
    public function testhandlenormalPriceSiUnitNotSetMilliliterSetInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleBlueCard = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleBlueCard->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1 ml', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10 ml', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 ml', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $clubcard = (object)array('si-unit-price' => $siunitprice, 'price' => '10');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000 ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1000 ml', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1ml', $productObject->comment);
        $this->assertEquals('10000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '10ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('10ml', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100ml', $productObject->comment);
        $this->assertEquals('100', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);

        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '1000ml';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('1000ml', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testhandlenormalpriceNoUnitNoSIUNITGivenInDescription()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('price' => '10', 'si-unit-price' => $siunitprice);
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handleNormalPrice = TestUtilities::getMethod($tescoService, 'handleNormalPrice');

        $handleNormalPrice->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('', $productObject->bestUnitPrice);
        $this->assertEquals('10', $productObject->bestPrice);
    }
    public function testnormalunitpriceWithCsomagPriceCalculatedForDarab()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $siunitprice = (object)array('val' => '', 'list' => '');
        $templateData = (object) array('unit' => 'cs', 'price' => '900', 'si-unit-price' => '');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '30 db/cs';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $clubcard = array('si-unit-price' => (object)array('val' => '', 'list' => ''), 'price' => 900);

        $data = array('si-unit' => '', 'si-unit-price' => $siunitprice, 'price' => '900', 'unit' => 'cs');
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $normalUnitPrice = TestUtilities::getMethod($tescoService, 'normalUnitPrice');

        $normalUnitPrice->invokeArgs($tescoService, array($data, $product, $productObject));
        //Then
        $this->assertEquals('30', $productObject->bestUnitPrice);
    }
    public function testhandle2TierWithKilo()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('price' => '1000');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 Ft/1kg 10 Ft/1kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handlehandle2Tier = TestUtilities::getMethod($tescoService, 'handle2Tier');

        $handlehandle2Tier->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 Ft/1kg 10 Ft/1kg', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('1000', $productObject->bestPrice);

        $templateData = (object) array('price' => '1000');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 Ft/kg 10 Ft/kg';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handlehandle2Tier = TestUtilities::getMethod($tescoService, 'handle2Tier');

        $handlehandle2Tier->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('kg', $productObject->unit);
        $this->assertEquals('100 Ft/kg 10 Ft/kg', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('1000', $productObject->bestPrice);
    }
    public function testhandle2TierWithLiter()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('price' => '1000');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 Ft/1l 10 Ft/1l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handlehandle2Tier = TestUtilities::getMethod($tescoService, 'handle2Tier');

        $handlehandle2Tier->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 Ft/1l 10 Ft/1l', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('1000', $productObject->bestPrice);

        $templateData = (object) array('price' => '1000');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = '100 Ft/l 10 Ft/l';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handlehandle2Tier = TestUtilities::getMethod($tescoService, 'handle2Tier');

        $handlehandle2Tier->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('l', $productObject->unit);
        $this->assertEquals('100 Ft/l 10 Ft/l', $productObject->comment);
        $this->assertEquals('10', $productObject->bestUnitPrice);
        $this->assertEquals('1000', $productObject->bestPrice);
    }
    public function testhandle2TierWithNoUnitGiven()
    {
        //Given
        $outSideResponse = $this->make(
            App\outside_resources\OutsideResponse::class,
            []
        );
        $tescoRepository = $this->make(
            App\Repositories\TescoRepository::class,
            []
        );
        $templateData = (object) array('price' => '1000');
        $template = (object) array('data' => $templateData);
        $data = (object) array('template' => $template);
        $description = 'blabla';
        $product = (object) array('description' => $description, 'data' => $data);
        $productObject = (object)array();
        $tescoService = new App\Services\TescoService($outSideResponse, $tescoRepository);
        //When
        $handlehandle2Tier = TestUtilities::getMethod($tescoService, 'handle2Tier');

        $handlehandle2Tier->invokeArgs($tescoService, array($product, $productObject));
        //Then
        $this->assertEquals('db', $productObject->unit);
        $this->assertEquals('blabla', $productObject->comment);
        $this->assertEquals('1000', $productObject->bestUnitPrice);
        $this->assertEquals('1000', $productObject->bestPrice);
    }
}
