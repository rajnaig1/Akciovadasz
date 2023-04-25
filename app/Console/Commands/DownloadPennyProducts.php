<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cron_Jobs\PennyCron;

class DownloadPennyProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:download_pennyproducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading Products From Penny Server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    //protected $pennyCron;
    public function __construct()
    {
        //$this->pennyCron=$pennyCron;
        parent::__construct();
    }

    /**
     * Execute the console command.
     * A Penny feltöltése adatbázisba
     * Ha az adatbázisba írás sikeres volt azaz az uploadDatabase metódus Success-szel tér vissza,
     * akkor a logfile-ba infoként berakja az időpontot és a success message-t
     * 1-essel tér vissza
     * 
     * Ha sikertelen volt, akkor kiszedi a classt amiből a hiva jön, a sor számát, 
     * az exception message-ét és a Stacktrace-t
     * 0-val tér vissza
     *
     * @return int
     */
    public function handle(PennyCron $pennyCron)
    {
        $this->info(\now());
        $this->info('Automatic');
        if ($pennyCron->uploadDataBase() == 'Success') {
            $this->info('Penny');
            $this->info($pennyCron->uploadDataBase());
            $this->info('End');
            return 0;
        } else {
            $this->info('Penny');
            $this->info('File');
            $this->error($pennyCron->uploadDataBase()->getFile());
            $this->info('Line');
            $this->error($pennyCron->uploadDataBase()->getLine());
            $this->info('Message');
            $this->error($pennyCron->uploadDataBase()->getMessage());
            $this->info('StackTrace');
            $this->error($pennyCron->uploadDataBase()->getTraceAsString());
            $this->info('End');
            return 1;
        }
        return 0;
    }
    private function checkPennyCronJob(PennyCron $pennyCron)
    {
    }
}
