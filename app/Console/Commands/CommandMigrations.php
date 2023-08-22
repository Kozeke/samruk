<?php namespace App\Console\Commands;

use App\Models\Media;
use App\Models\News;
use App\Models\Pages;
use App\Models\Sections;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Gb;

class CommandMigrations extends Command
{

		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'command:migration';

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Перенос данных с одной базы на другую';

        protected $connection = 'mysql_old';

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

			$section = $this->ask('Выберите раздел для переноса: [users|news|gbs|media|sections|pages]');

            switch ($section) {
                case "users":
                    $this->migrateUsers();
                    break;
                case "news":
                    $this->migrateNews();
                    break;
                case "gbs":
                    $this->migrateGbs();
                    break;
                case "media":
                    $this->migrateMedia();
                    break;
                case "sections":
                    $this->migrateSections();
                    break;
                case "pages":
                    $this->migratePages();
                    break;
                default:
                    throw new \Exception('Неверно выбран раздел');
            }
        }


    /**
     * @return void
     * @throws \Exception
     */
    protected function migrateUsers()
        {
            $this->_checkDb();

            $i = 1;
            $users = DB::connection($this->connection)->table('users')->orderBy('id', 'asc')->chunk(10, function ($users) use($i) {

                foreach ($users as $user) {

                    $findUser = User::where('id', $user->id)->first();

                    if (!is_null($findUser)) {
                        $this->info('Users found '.$user->id . "\n");
                        continue;
                    } else {
                        $i++;
                        $this->info('Start Add user '.$user->id . "\n");

                        $user_new = new User();

                        $user_new->id = $user->id;
                        $user_new->good = $user->good;
                        $user_new->admin = $user->admin;
                        $user_new->role_id = $user->role_id;
                        $user_new->email = $user->email;
                        $user_new->iin = $user->iin;
                        $user_new->surname = $user->surname;
                        $user_new->name = $user->name;
                        $user_new->patronymic = $user->patronymic;
                        $user_new->last_login = $user->last_login;
                        $user_new->locked = $user->locked;
                        $user_new->address = $user->address;
                        $user_new->homephone = $user->homephone;
                        $user_new->mobile = $user->mobile;
                        $user_new->language = $user->language;
                        $user_new->password = $user->password;
                        $user_new->password_requested_at = $user->password_requested_at;
                        $user_new->remember_token = $user->remember_token;
                        $user_new->verify = $user->verify;
                        $user_new->verify_at = $user->verify_at;
                        $user_new->created_at = $user->created_at;
                        $user_new->updated_at = $user->updated_at;
                        $user_new->photo = $user->photo;

                        $user_new->save();

                        $this->info('Success Add user '.$user->id . "\n");
                    }
                }

            });
            $this->info('All users update'. "\n");
        }

    /**
     * @return void
     * @throws \Exception
     */
    protected function migrateNews()
        {
            $this->_checkDb();

            $i = 1;
            $news = DB::connection($this->connection)->table('news')->orderBy('id', 'asc')->chunk(10, function ($news) use($i) {

                foreach ($news as $new) {

//                    $findNew = News::where('id', $new->id)->first();
                    $findNew = News::where('title_ru', 'like', '%'.$new->title_ru.'%')->first();

                    if (!is_null($findNew)) {
                        $this->info('News found '.$new->id . "\n");
                        continue;
                    } else {
                        $i++;
                        $this->info('Start Add news '.$new->id . "\n");

                        $news_new = new News();

                        $news_new->section_id = $new->section_id;
                        $news_new->rubric_id = $new->rubric_id;
                        $news_new->fixed = $new->fixed;
                        $news_new->good_ru = $new->good_ru;
                        $news_new->good_en = $new->good_en;
                        $news_new->good_kz = $new->good_kz;
                        $news_new->title_ru = $new->title_ru;
                        $news_new->title_en = $new->title_en;
                        $news_new->title_kz = $new->title_kz;
                        $news_new->short_ru = $new->short_ru;
                        $news_new->short_en = $new->short_en;
                        $news_new->short_kz = $new->short_kz;
                        $news_new->full_ru = $new->full_ru;
                        $news_new->full_en = $new->full_en;
                        $news_new->full_kz = $new->full_kz;
                        $news_new->update_user = $new->update_user;
                        $news_new->created_user = $new->created_user;
                        $news_new->published_at = $new->published_at;
                        $news_new->view = $new->view;
                        $news_new->created_at = $new->created_at;
                        $news_new->updated_at = $new->updated_at;
                        $news_new->material_id = $new->material_id;

                        $news_new->save();

                        $this->info('Success Add news '.$new->id . "\n");
                    }
                }

            });
            $this->info('All news update'. "\n");
        }

    /**
     * @return void
     * @throws \Exception
     */
    protected function migrateGbs()
        {
            $this->_checkDb();

            $i = 1;
            $gbs = DB::connection($this->connection)->table('gbs')->orderBy('id', 'asc')->chunk(10, function ($gbs) use($i) {

                foreach ($gbs as $gb) {

                    $findGb= Gb::where('id', $gb->id)->first();

                    if (!is_null($findGb)) {
                        $this->info('Gb found '.$gb->id . "\n");
                        continue;
                    } else {
                        $i++;
                        $this->info('Start Add gb '.$gb->id . "\n");

                        $gbs_new = new Gb();

                        $gbs_new->id = $gb->id;
                        $gbs_new->section_id = $gb->section_id;
                        $gbs_new->lang = $gb->lang;
                        $gbs_new->good = $gb->good;
                        $gbs_new->surname = $gb->surname;
                        $gbs_new->name = $gb->name;
                        $gbs_new->theme = $gb->theme;
                        $gbs_new->email = $gb->email;
                        $gbs_new->message = $gb->message;
                        $gbs_new->answer = $gb->answer;
                        $gbs_new->ip = $gb->ip;
                        $gbs_new->published_at = $gb->published_at;
                        $gbs_new->created_at = $gb->created_at;
                        $gbs_new->updated_at = $gb->updated_at;

                        $gbs_new->save();

                        $this->info('Success Add gb '.$gb->id . "\n");
                    }
                }

            });
            $this->info('All gbs update'. "\n");
        }

    /**
     * @return void
     * @throws \Exception
     */
    protected function migrateMedia()
        {
            $this->_checkDb();

            $i = 1;
            $medias = DB::connection($this->connection)->table('media')->orderBy('id', 'asc')->chunk(10, function ($medias) use($i) {

                foreach ($medias as $media) {

//                    $findMedia= Media::where('id', $media->id)->first();

                    $findMedia= Media::where('link', 'like', '%'.$media->link.'%')->first();

                    if (!is_null($findMedia)) {
                        $this->info('Media found '.$media->id . "\n");
                        continue;
                    } else {
                        $i++;
                        $this->info('Start Add media '.$media->id . "\n");

                        $media_new = new Media();

                        $media_new->section_id = $media->section_id;
                        $media_new->rubric_id = $media->rubric_id;
                        $media_new->news_id = $media->news_id;
                        $media_new->object_id = $media->object_id;
                        $media_new->gallery_id = $media->gallery_id;
                        $media_new->good = $media->good;
                        $media_new->switch_ru = $media->switch_ru;
                        $media_new->switch_kz = $media->switch_kz;
                        $media_new->switch_en = $media->switch_en;
                        $media_new->main = $media->main;
                        $media_new->type = $media->type;
                        $media_new->lang = $media->lang;
                        $media_new->sind = $media->sind;
                        $media_new->link = $media->link;
                        $media_new->title_ru = $media->title_ru;
                        $media_new->title_en = $media->title_en;
                        $media_new->title_kz = $media->title_kz;
                        $media_new->publish_at = $media->publish_at;
                        $media_new->created_at = $media->created_at;
                        $media_new->updated_at = $media->updated_at;

                        $media_new->save();

                        $this->info('Success Add media '.$media_new->id . "\n");
                    }
                }

            });
            $this->info('All medias update'. "\n");
        }

    /**
     * @return void
     * @throws \Exception
     */
    protected function migrateSections()
    {
        $this->_checkDb();

        $i = 1;
        $sections = DB::connection($this->connection)->table('sections')->orderBy('id', 'asc')->chunk(10, function ($sections) use($i) {

            foreach ($sections as $section) {

//                $findSections = Sections::where('id', $section->id)->first();
                $findSections = Sections::where('name_ru', 'like', '%'.$section->name_ru.'%')->first();

                if (!is_null($findSections)) {
                    $this->info('Sections found '.$section->id . "\n");
                    continue;
                } else {
                    $i++;
                    $this->info('Start Add sections '.$section->id . "\n");
                    $sections_new = new Sections();

                    $sections_new->area_id = $section->area_id;
                    $sections_new->parent_id = $section->parent_id;
                    $sections_new->rubric = $section->rubric;
                    $sections_new->good = $section->good;
                    $sections_new->menu = $section->menu;
                    $sections_new->order = $section->order;
                    $sections_new->type = $section->type;
                    $sections_new->link = $section->link;
                    $sections_new->name_ru = $section->name_ru;
                    $sections_new->name_en = $section->name_en;
                    $sections_new->name_kz = $section->name_kz;
                    $sections_new->template = $section->template;
                    $sections_new->col = $section->col;
                    $sections_new->alias = $section->alias;
                    $sections_new->classes = $section->classes;
                    $sections_new->created_at = $section->created_at;
                    $sections_new->updated_at = $section->updated_at;
                    $sections_new->submenu = $section->submenu;

                    $sections_new->save();

                    $this->info('Success Add sections '.$sections_new->id . "\n");
                }
            }

        });
        $this->info('All sections update'. "\n");
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function migratePages()
    {
        $this->_checkDb();

        $i = 1;
        $pages = DB::connection($this->connection)->table('pages')->orderBy('id', 'asc')->chunk(10, function ($pages) use($i) {

            foreach ($pages as $page) {

//                $findPages = Pages::where('id', $section->id)->first();
                $findPages = Pages::where('description_ru', 'like', '%'.$page->description_ru.'%')->first();

                if (!is_null($findPages)) {
                    $this->info('Pages found '.$page->id . "\n");
                    continue;
                } else {
                    $i++;
                    $this->info('Start Add pages '.$page->id . "\n");

                    $pages_new = new Pages();

                    $pages_new->section_id = $page->section_id;
                    $pages_new->description_ru = $page->description_ru;
                    $pages_new->description_en = $page->description_en;
                    $pages_new->description_kz = $page->description_kz;
                    $pages_new->created_at = $page->created_at;
                    $pages_new->updated_at = $page->updated_at;

                    $pages_new->save();

                    $this->info('Success Add pages '.$pages_new->id . "\n");
                }
            }

        });
        $this->info('All pages update'. "\n");
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function _checkDb()
        {
        if (!env('OLD_DB_HOST'))
            {
              throw new \Exception('Old database credentials are not set.');
            }
        }

}
