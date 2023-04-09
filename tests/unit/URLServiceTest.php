<?php

class URLServiceTest extends \Codeception\Test\Unit
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
    public function testGetPenny()
    {
        //Given
        $urlRepo = $this->make(App\Repositories\URLRepository::class, [
            'getPenny' => function () {
                return 'penny%uRL%u';
            }
        ]);
        $url = new App\Services\URLService($urlRepo);
        //When
        $pennyURL = $url->getPenny(2, 3);
        //Then
        $this->assertEquals('penny2RL3', $pennyURL);
    }
    public function testGetTesco()
    {
        //Given
        $urlRepo = $this->make(App\Repositories\URLRepository::class, [
            'getTesco' => function () {
                return 'tescoURL';
            }
        ]);
        $url = new App\Services\URLService($urlRepo);
        //When
        $pennyURL = $url->getTesco();
        //Then
        $this->assertEquals('tescoURL', $pennyURL);
    }
}
