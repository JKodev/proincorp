<?php

namespace App\Console\Commands;

use App\Helpers\MigrateHelper;
use Illuminate\Console\Command;
use Log;

class MigrateInfomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proincorp:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra la información de una BD MySQL a SQLServer cada intervalo de tiempo.';

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
     *
     * @return mixed
     */
    public function handle()
    {
	    $messages = MigrateHelper::migrate();
	    foreach ($messages as $message) {
	    	Log::notice($message);
		    $this->info($message);
	    }
    	/*
        $time = intval($this->argument('time'));
	    while (true) {
			$messages = MigrateHelper::migrate();
		    foreach ($messages as $message) {
		    	$this->info($message);
		    }
		    sleep($time*60);
	    }
    	*/
    }
}
