<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{News};
use Carbon\Carbon;
use Hash;

class NewsController extends Controller
{

    public function getNews ($token = null)
    {
        $return = [];

        if ($token == '$2y$10$ffqT92SWHABx2ulBdscBy.b12bUTw6mauBQ.q2RvtB47nnmRBtLyW') {

          $records = News::where('section_id', 6)->orderBy('published_at', 'DESC')->limit(50)->get();

          foreach ($records as $record) {
            $images = [];
            $media = $record->media()->where('good', 1)->orderBy('main', 'desc')->orderBy('sind', 'desc')->get();
            if ($media->count() > 0) {
              foreach ($media as $image) {
                $images[] = $image->link;
              }
            }

            $return[] = [
              "published" => $record->published_at,
              "newsId" => $record->id,
              "category_id" => $record->rubric_id,
              "status" => "2",
              "subject_kk" => $record->title_kz,
              "text_kk" => $record->short_kz . ' ' . $record->full_kz,
              "subject_ru" => $record->title_ru,
              "text_ru" => $record->short_ru . ' ' . $record->full_ru,
              "subject_en" => $record->title_en,
              "text_en" => $record->short_en . ' ' . $record->full_en,
              "preview_photo" => isset($images[0]) ? 'image/resize/280/160/' . $images[0] : null,
              "header_photo" => $images[0] ?? null,
              "otherphoto" => $images,
            ];
          }
        }

        return $return;
    }
}
