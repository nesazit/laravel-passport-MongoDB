<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PassportMongoDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:passport {--rollback : Rollback the Passport change}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change passport model extend for mongoDB support';

    /**
     * MongoDB Model to use
     *
     * @var string
     */
    protected $mongoDBModel = 'MongoDB\Laravel\Eloquent\Model;';

    /**
     * Laravel Eloquent Model to Replace with
     *
     * @var string
     */
    protected $laravelModel = 'Illuminate\Database\Eloquent\Model';

    /**
     * Passport vendor files location
     *
     * @var string
     */
    protected $passport_path = 'vendor/laravel/passport/src/';

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
        if (!$this->option('rollback'))
        {
          	$this->changeFiles();
          	$this->info("Passport Files have been changed for MongoDB");
        } else {

            $this->rollBackFiles();
            $this->info("Passport Files have been rolled back for MongoDB");
        }
    }

    /**
     * Change the Passport files
     *
     * @return void
     */
    protected function changeFiles()
    {
    	foreach (glob(base_path($this->passport_path) . '*.php') as $fileName)
    	{
    	    $file = file_get_contents($fileName);

    	    file_put_contents($fileName, str_replace($this->laravelModel, $this->mongoDBModel, $file));
    	}
    }

    protected function rollBackFiles()
    {
    	foreach (glob(base_path($this->passport_path) . '*.php') as $fileName)
    	{
    	    $file = file_get_contents($fileName);

    	    file_put_contents($fileName, str_replace($this->mongoDBModel, $this->laravelModel, $file));
    	}
    }
}
