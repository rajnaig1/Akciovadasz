<?php
class TescoCronTest extends \Codeception\Test\Unit
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
        $tescoService = $this->make(
            App\Services\TescoService::class,
            [
                'storeTesco' => function () {
                    'upsertSuccess';
                }
            ]
        );
        $tescoCron = new App\Cron_Jobs\TescoCron($tescoService);
        $this->assertEquals('Success', $tescoCron->uploadDataBase());
    }
    public function testUploadDatabaseUpsertThrowsError()
    {
        $tescoService = $this->make(
            App\Services\TescoService::class,
            [
                'storeTesco' => function () {
                    throw new Exception('Upsert Exception');
                }
            ]
        );
        $tescoCron = new App\Cron_Jobs\TescoCron($tescoService);
        $this->assertEquals('Upsert Exception', $tescoCron->uploadDataBase()->getMessage());
    }
}
