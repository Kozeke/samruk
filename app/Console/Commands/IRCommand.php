<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class IRCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ir:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'IROptimeze for local envoronment';

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
      $this->call('route:clear');
      $this->call('view:clear');
      $this->call('cache:clear');
      $this->call('config:clear');
      exec('rm -rf vendor/composer/autoload_*');
      exec('composer dump-autoload');
    }

}
