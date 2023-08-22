<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Gb;
use Carbon\Carbon;

class GbMigrations extends Command
{

		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'gb:migration';

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Перенос гостевой книги с одного сайта на другой';

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

			$lang = $this->ask('Выберите язык: [ru|kz]');

			if ($lang == 'ru'){
				$table = 'rus_gb';
			}elseif($lang == 'kz'){
				$table = 'kaz_gb';
			}else{
				throw new \Exception('Неверно выбран язык');
			}

        if (!env('OLD_DB_HOST'))
        {
          throw new \Exception('Old database credentials are not set.');
        }

        $connection = 'mysql_old';

        echo "start \n";
        $i = 1;
        $gbs = DB::connection($connection)->table($table)->orderBy('id', 'asc')->chunk(10, function ($gbs) use($i, $lang) {

                    $bar = $this->output->createProgressBar($gbs->count());

                    $bar->setFormat('%current%/%max% [%bar%] %percent:3s%% ');
                    $bar->setBarCharacter('<comment>=</comment>');

                    $bar->setEmptyBarCharacter('-');
                    $bar->setProgressCharacter('>');
                    $bar->setBarWidth(100);

                    foreach ($gbs as $gb) {

                            $gb_new = new Gb();

                            $gb_new->section_id = 112;
                            $gb_new->lang = $lang;
                            $gb_new->good = $gb->good;
                            $gb_new->surname = $gb->surname;
                            $gb_new->name = $gb->name;
                            $gb_new->theme = $gb->theme;
                            $gb_new->email = $gb->email;
                            $gb_new->message = $gb->txt;
                            $gb_new->answer = $gb->reply;
                            $gb_new->ip = $gb->ip;
                            $gb_new->published_at = $gb->dt;
                            $gb_new->created_at = $gb->dt;
                            $gb_new->updated_at = $gb->dt;

                            $gb_new->save();

                      $bar->advance();
                    }

                    $bar->finish();

                    echo "\n";
            });

		}

}
