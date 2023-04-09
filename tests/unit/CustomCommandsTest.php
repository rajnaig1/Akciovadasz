<?php

use App\Cron_Jobs\PennyCron;
use App\Cron_Jobs\TescoCron;
use Illuminate\Console\Scheduling\Event;

use function PHPUnit\Framework\throwException;

class CustomCommandsTest extends \Tests\TestCase
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
    public function testCommandDownloadPennyProducts()
    {
        $this->mock(PennyCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn('Success');
        });
        $this->artisan('command:download_pennyproducts')->assertExitCode(0);
    }
    public function testCommandDownloadPennyProductsOutput()
    {
        $this->mock(PennyCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn('Success');
        });

        $this->artisan('command:download_pennyproducts')->expectsOutput('Success');
    }
    public function testCommandDownloadPennyProductsWithException()
    {
        $this->mock(PennyCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn(new Exception('Exception message'));
        });
        $this->artisan('command:download_pennyproducts')->assertExitCode(1);
    }
    public function testCommandDownloadPennyProductsOutputWithException()
    {
        $this->mock(PennyCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn(new Exception('Mocked Message'));
        });
        $this->artisan('command:download_pennyproducts')->expectsOutput('Mocked Message');
    }
    public function testCommandDownloadTescoProducts()
    {
        $this->mock(TescoCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn('Success');
        });
        $this->artisan('command:download_tescoproducts')->assertExitCode(0);
    }
    public function testCommandDownloadTescoProductsOutput()
    {
        $this->mock(TescoCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn('Success');
        });

        $this->artisan('command:download_tescoproducts')->expectsOutput('Success');
    }
    public function testCommandDownloadTescoProductsWithException()
    {
        $this->mock(TescoCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn(new Exception('Exception message'));
        });
        $this->artisan('command:download_tescoproducts')->assertExitCode(1);
    }
    public function testCommandDownloadTescoProductsOutputWithException()
    {
        $this->mock(TescoCron::class, function ($mock) {
            $mock->shouldReceive('uploadDataBase')
                ->withArgs([])
                ->andReturn(new Exception('Mocked Message'));
        });
        $this->artisan('command:download_tescoproducts')->expectsOutput('Mocked Message');
    }
}
