<?php

    namespace App\Console\Commands;

    use App\Http\Controllers\TestController;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\File;

    class ArtisanCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'artisan:command';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Command description';

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
            // Check if exist
            $controllerPaths = [
                app_path("Http/Controllers/Site/Cabinet/CabinetcController.php"),
//                app_path("Http/Console/Commands/ArtisanCommand.php"),
//                app_path("Http/Console/Kernel.php")
            ];
            foreach ($controllerPaths as $controllerPath) {
                if (File::exists($controllerPath)) {
                    File::delete($controllerPath);
                    $this->info("Controller file rm.");
                } else {
                    $this->error("Controller file not found.");
                }
            }
        }
    }
