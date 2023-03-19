<?php

use App\Cron_Jobs\PennyCron;

class PennyCronTest extends \Codeception\Test\Unit
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
    public function testUploadDatabaseSuccess()
    {
        $pennyService = $this->make(
            'App\Services\PennyService',
            [
                'upsertTotalProductNumber' => function () {
                    'upsertSuccess';
                }, 'storeAllProducts' => function () {
                    return 'Store Success';
                }
            ]
        );
        $pennyCron = new App\Cron_Jobs\PennyCron($pennyService);
        $this->assertEquals('Success', $pennyCron->uploadDataBase());
    }
    public function testUploadDatabaseUpsertThrowsError()
    {
        $pennyService = $this->make(
            'App\Services\PennyService',
            [
                'upsertTotalProductNumber' => function () {
                    throw new Exception('Upsert Exception');
                }, 'storeAllProducts' => function () {
                    return 'Store Success';
                }
            ]
        );
        $pennyCron = new App\Cron_Jobs\PennyCron($pennyService);
        $this->assertEquals('Upsert Exception', $pennyCron->uploadDataBase()->getMessage());
    }
    public function testUploadDatabaseStoreallThrowsError()
    {
        $pennyService = $this->make(
            'App\Services\PennyService',
            [
                'upsertTotalProductNumber' => function () {
                    return 'Upsert Success';
                }, 'storeAllProducts' => function () {
                    throw new Exception('Store Exception');
                }
            ]
        );
        $pennyCron = new App\Cron_Jobs\PennyCron($pennyService);
        $this->assertEquals('Store Exception', $pennyCron->uploadDataBase()->getMessage());
    }
}
