<?php

use Codeception\Codecept;

class PennyServiceTest extends \Codeception\Test\Unit
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
    public function testUpsertTotalProductNumberUpdatesTotalRecord()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make('App\Repositories\Penny_General_Repository', [
            'updateTotal' => function () {
                return 'updated';
            },
            'getTotal' => function () {
                $testObject = (object)[];
                $testObject->_id = 1;
                $testObject->Total = 'Total';
                return [$testObject];
            },
            'createTotal' => function () {
                return 'created';
            }
        ]);
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->upsertTotalProductNumber();
        //Then
        $this->assertEquals('updated', $output);
    }
    public function testUpsertTotalProductNumberCreatesTotalRecord()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make('App\Repositories\Penny_General_Repository', [
            'updateTotal' => function () {
                return 'updated';
            },
            'getTotal' => function () {
                return null;
            },
            'createTotal' => function () {
                return 'created';
            }
        ]);
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->upsertTotalProductNumber();
        //Then
        $this->assertEquals('created', $output);
    }
    public function testUpsertTotalProductNumberCreatesTotalRecordEmptyParameters()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make('App\Repositories\Penny_General_Repository', [
            'updateTotal' => function () {
                return 'updated';
            },
            'getTotal' => function () {
                $testObject = (object)[];
                return [$testObject];
            },
            'createTotal' => function () {
                return 'created';
            }
        ]);
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->upsertTotalProductNumber();
        //Then
        $this->assertEquals('created', $output);
    }
    public function testGetTotal()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make('App\Repositories\Penny_General_Repository', ['getTotal' => function () {
            return [(object) array('Total' => 'Response1'), 'Response2'];
        }]);
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->getTotal();
        //Then
        $this->assertEquals('Response1', $output);
    }
    public function testStoreAllProducts()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make(
            'App\Repositories\Penny_General_Repository',
            [
                'getTotal' => function () {
                    return [(object) array('Total' => '3'), 'Response2'];
                }, 'wipeProducts' => function () {
                    return 'database deleted';
                }, 'storeAllProducts' => function () {
                    return 'database created';
                },
                'wipeShoppingCarts' => function () {
                    return 'Shoppingcarts wiped';
                }
            ]
        );
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->storeAllProducts();
        //Then
        $this->assertEquals('done', $output);
    }
    public function testBatchPennyProductCalls100()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make(
            'App\Repositories\Penny_General_Repository',
            [
                'getTotal' => function () {
                    return [(object) array('Total' => '3'), 'Response2'];
                }, 'wipeProducts' => function () {
                    return 'database deleted';
                }, 'storeAllProducts' => function () {
                    return 'database created';
                }
            ]
        );
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->batchPennyProductCalls100(549);
        //Then
        $this->assertEquals('49', $output['Remaining100']);
        $this->assertEquals('5', $output['stepSize']);
        $this->assertEquals('0', $output['startsFrom']);
        //When
        $output = $pennyService->batchPennyProductCalls100(500);
        //Then
        $this->assertEquals('0', $output['Remaining100']);
        $this->assertEquals('5', $output['stepSize']);
        $this->assertEquals('0', $output['startsFrom']);
        //When
        $output = $pennyService->batchPennyProductCalls100(99);
        //Then
        $this->assertEquals('99', $output['Remaining100']);
        $this->assertEquals('0', $output['stepSize']);
        $this->assertEquals('0', $output['startsFrom']);
    }
    public function testBatchPennyProductCalls10()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make(
            'App\Repositories\Penny_General_Repository',
            [
                'getTotal' => function () {
                    return [(object) array('Total' => '3'), 'Response2'];
                }, 'wipeProducts' => function () {
                    return 'database deleted';
                }, 'storeAllProducts' => function () {
                    return 'database created';
                }
            ]
        );
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->batchPennyProductCalls10(549, ['Remaining100' => 49]);
        //Then
        //549%10
        $this->assertEquals('9', $output['Remaining10']);
        //Pagenumber 540/10=54
        $this->assertEquals('54', $output['stepSize']);
        //50-54 page listed
        $this->assertEquals('50', $output['startsFrom']);
        //When
        $output = $pennyService->batchPennyProductCalls10(500, ['Remaining100' => 0]);
        //Then
        //549%10
        $this->assertEquals('0', $output['Remaining10']);
        //Pagenumber 540/10=54
        $this->assertEquals('50', $output['stepSize']);
        //50-54 page listed
        $this->assertEquals('50', $output['startsFrom']);
        //When
        $output = $pennyService->batchPennyProductCalls10(560, ['Remaining100' => 60]);
        //Then
        //549%10
        $this->assertEquals('0', $output['Remaining10']);
        //Pagenumber 540/10=54
        $this->assertEquals('56', $output['stepSize']);
        //50-54 page listed
        $this->assertEquals('50', $output['startsFrom']);
    }
    public function testPennyProductCalls1()
    {
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make(
            'App\Repositories\Penny_General_Repository',
            [
                'getTotal' => function () {
                    return [(object) array('Total' => '3'), 'Response2'];
                }, 'wipeProducts' => function () {
                    return 'database deleted';
                }, 'storeAllProducts' => function () {
                    return 'database created';
                }
            ]
        );
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->batchPennyProductCalls1(549, ['Remaining10' => 9]);
        //Then
        //549%10
        $this->assertEquals('0', $output['Remaining10']);
        //Pagenumber 540/10=54
        $this->assertEquals('549', $output['stepSize']);
        //50-54 page listed
        $this->assertEquals('540', $output['startsFrom']);
    }
    public function testCheckHealth()
    {
        //Given
        $outsideResponse = $this->makeEmpty(App\outside_resources\OutsideResponse::class, ['pennyTotal' => function () {
            return 'Repo success';
        }]);
        $pennyGeneralRepository = $this->make('App\Repositories\Penny_General_Repository', ['getTotal' => function () {
            return [(object) array('Total' => 'Response1'), 'Response2'];
        }]);
        $pennyService = new \App\Services\PennyService($outsideResponse, $pennyGeneralRepository);
        //When
        $output = $pennyService->checkHealth();
        //Then
        $this->assertEquals('Service alive', $output);
    }
}
