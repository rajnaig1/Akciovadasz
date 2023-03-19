<?php
class CronLogServiceTest extends \Codeception\Test\Unit
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
    public function testIfLogFileDoesnotExist(){
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {
                $testArray = ['Date', 'Automatic', 'Shop', 'Success', 'End'];
                return $testArray;
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return false;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals(0, count($result));
    }
    public function testIfWithoutEndMarksTheFileIsNotRead()
    {
        $testArray = [now(), 'second', 'third'];
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {

                return [now(), 'second', 'third', 'fourth'];
            },
            'storage_pathWrapper' => function () {
                $testArray = [now(), 'second', 'third'];
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return true;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals(0, count($result));
    }
    public function testIfWithEndMarksTheFileIsRead()
    {
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {
                $testArray = ['Date', 'Automatic', 'Shop', 'Success', 'End'];
                return $testArray;
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return true;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals(1, count($result));
    }
    public function testReadWithMultipleSuccessMessages()
    {
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {
                $testArray = ['Date', 'Automatic', 'Shop', 'Success', 'End', 'Date', 'Automatic', 'Shop', 'Success', 'End', 'Date', 'Automatic', 'Shop', 'Success', 'End'];
                return $testArray;
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return true;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals(3, count($result));
        $this->assertEquals('Date', $result[0]->time);
        $this->assertEquals('Automatic', $result[0]->runner);
        $this->assertEquals('Shop', $result[0]->job);
        $this->assertEquals('Success', $result[0]->success);
        $this->assertEquals('Date', $result[1]->time);
        $this->assertEquals('Automatic', $result[1]->runner);
        $this->assertEquals('Shop', $result[1]->job);
        $this->assertEquals('Success', $result[1]->success);
        $this->assertEquals('Date', $result[2]->time);
        $this->assertEquals('Automatic', $result[2]->runner);
        $this->assertEquals('Shop', $result[2]->job);
        $this->assertEquals('Success', $result[2]->success);
    }
    public function testReadWithFailureMessages()
    {
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {
                $testArray = ['Date', 'Automatic', 'Shop', 'File', 'filepath', 'Line', 'LineNumber', 'Message', 'TestMessage', 'StackTrace', 'Test', 'End'];
                return $testArray;
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return true;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals(1, count($result));
        $this->assertEquals('Date', $result[0]->time);
        $this->assertEquals('Automatic', $result[0]->runner);
        $this->assertEquals('Shop', $result[0]->job);
        $this->assertEquals('filepath', $result[0]->file);
        $this->assertEquals('LineNumber', $result[0]->line);
        $this->assertEquals('TestMessage', $result[0]->message);
        $this->assertEquals('See in log', $result[0]->stackTrace);
        $this->assertEquals('failure', $result[0]->success);
    }
    public function testReadWithSuccessAndFailureMessagesReadOut()
    {
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fileWrapper' => function () {
                $testArray = ['Date', 'Automatic', 'Shop', 'Success', 'End', 'Date', 'Automatic', 'Shop', 'File', 'filepath', 'Line', 'LineNumber', 'Message', 'TestMessage', 'StackTrace', 'Test', 'End', 'Date', 'Automatic', 'Shop', 'Success', 'End'];
                return $testArray;
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'file_existsWrapper'=>function(){
                return true;
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->getCronLog();
        $this->assertEquals('Date', $result[0]->time);
        $this->assertEquals('Automatic', $result[0]->runner);
        $this->assertEquals('Shop', $result[0]->job);
        $this->assertEquals('Success', $result[0]->success);
        $this->assertEquals('Date', $result[1]->time);
        $this->assertEquals('Automatic', $result[1]->runner);
        $this->assertEquals('Shop', $result[1]->job);
        $this->assertEquals('filepath', $result[1]->file);
        $this->assertEquals('LineNumber', $result[1]->line);
        $this->assertEquals('TestMessage', $result[1]->message);
        $this->assertEquals('See in log', $result[1]->stackTrace);
        $this->assertEquals('failure', $result[1]->success);
        $this->assertEquals('Date', $result[2]->time);
        $this->assertEquals('Automatic', $result[2]->runner);
        $this->assertEquals('Shop', $result[2]->job);
        $this->assertEquals('Success', $result[2]->success);
    }
    public function testWriteToFile()
    {
        $testData = 1;
        $file = '';
        $testArray = [];
        $wrapper = $this->make(App\Wrappers\Wrappers::class, [
            'fopenWrapper' => function () {

                return 'File';
            },
            'storage_pathWrapper' => function () {
                return 'Path to storage returned';
            },
            'nowWrapper' => function () {
                return 'now';
            },
            'fwriteWrapper' => function () {
                return 'Written';
            }, 'fcloseWrapper' => function () {
                return 'Closed';
            }
        ]);
        $object = new App\Services\CronLogService($wrapper);
        $result = $object->writeManualLog('Success', 'Penny');
        $this->assertEquals('Success', $result);
        $result = $object->writeManualLog(new Exception('Custom Exception'), 'Penny');
        $this->assertEquals('failure', $result);
    }
}
