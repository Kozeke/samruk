<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LinksController extends SectionsController
{
    /** @var string */
    private $template;

    public function indexJson(Request $request)
    {
        if ($request->alias !== 'phone-numbers') {
            abort(403);
        }

        /** @var Collection $records */
        $records = $this->getRecords([
            'id',
            'title_ru',
            'title_kz',
            'title_en',
            'description_ru',
            'description_en',
            'description_kz',
            'class',
        ], false);

        $records->map(function ($record) {
            $record['phone'] = $record['title_ru'];
            $record['title_ru'] = strip_tags($record['description_ru']);
            $record['title_kz'] = strip_tags($record['description_kz']);
            $record['title_en'] = strip_tags($record['description_en']);
            $record['icon'] = url(sprintf('/site/img/icons/phone/ico-%s.png', $record['phone']));

            unset($record['description_ru']);
            unset($record['description_kz']);
            unset($record['description_en']);
            unset($record['class']);

            return $record;
        });

        return $records;
    }

    public function getRecords(array $fields = [], bool $paginate = true)
    {
        $query = $this->section->links()
            ->where('good_' . $this->lang, 1)
            ->orderBy('published_at', 'DESC');

        if (count($fields)) {
            $query = $query->select($fields);
        }

        return $paginate ? $query->paginate($this->section->current_template->records) : $query->get();
    }

    public function index(Request $request)
    {
        $records = $this->getRecords();

        return view($this->getTemplate(), [
            'records' => $records,
            'pagination' => $records->appends($_GET)->links()
        ]);
    }

    public function getTemplate(): string
    {
        return 'site.templates.links.short.' . $this->getTemplateFileName($this->section->current_template->file_short);
    }

    public function show($alias, $id)
    {
        //
    }
}
