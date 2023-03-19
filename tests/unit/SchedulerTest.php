<?php

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;

class SchedulerTest extends \Tests\TestCase
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
    public function testDownloadPennyProductIsScheduledForMondayMidnight()
    {
        $date = Carbon::today()->timezone('UTC')->startOfWeek()->setTime(0, 0);
        $dueEvents = $this->getScheduledEventsForCommand('command:download_pennyproducts', $date);

        $this->assertCount(1, $dueEvents, 'Command is not scheduled for expected time');

        /**
         * @var \Illuminate\Console\Scheduling\Event $event
         */
        $event = $dueEvents->first();

        $this->assertTrue($event->runsInEnvironment('production'));
    }
    private function getScheduledEventsForCommand(string $commandName, Carbon $atTime = null): Collection
    {
        # configure scheduled through Kernel

        /**
         * @var Schedule $schedule
         */
        $schedule = $this->app->get(Schedule::class);

        return collect($schedule->events())->filter(function (Event $event) use ($commandName, $atTime) {
            if (!str_contains($event->command, $commandName) && strcmp($event->description, $commandName) !== 0) {
                return false;
            }

            # optionally filter out events that are not due at the given time.
            if ($atTime !== null) {
                Carbon::setTestNow($atTime);
                return $event->isDue($this->app);
            } else {
                return true;
            }
        });
    }
}
