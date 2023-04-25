<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cron_Jobs\TescoCron;

class DownloadTescoProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:download_tescoproducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading Products From Tesco Server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * A Tesco feltöltése adatbázisba
     * Ha az adatbázisba írás sikeres volt azaz az uploadDatabase metódus Success-szel tér vissza,
     * akkor a logfile-ba infoként berakja az időpontot és a success message-t
     * 1-essel tér vissza
     * 
     * Ha sikertelen volt, akkor kiszedi a classt amiből a hiva jön, a sor számát, 
     * az exception message-ét és a Stacktrace-t
     * 0-val tér vissza
     * @return int
     */
    public function handle(TescoCron $tescoCron)
    {
        $this->info(\now());
        $this->info('Automatic');
        if ($tescoCron->uploadDataBase() == 'Success') {
            $this->info('Tesco');
            $this->info($tescoCron->uploadDataBase());
            $this->info('End');
            return 0;
        } else {
            $this->info('Tesco');
            $this->info('File');
            $this->error($tescoCron->uploadDataBase()->getFile());
            $this->info('Line');
            $this->error($tescoCron->uploadDataBase()->getLine());
            $this->info('Message');
            $this->error($tescoCron->uploadDataBase()->getMessage());
            $this->info('StackTrace');
            $this->error($tescoCron->uploadDataBase()->getTraceAsString());
            $this->info('End');
            return 1;
        }
        return 0;
    }
}
