<?php namespace App\Http\Controllers\Avl\Ajax;

use App\Http\Controllers\Avl\AvlController;
use Illuminate\Http\Request;
use App\Models\{News, Media, Rubrics, Objects};
use Carbon\Carbon;
use File;

class FilesController extends AvlController
{

  protected $fileTypes = ['jpg', 'jpeg', 'zip', 'pdf', 'xls', 'doc', 'docx', 'xlsx', 'rar', 'txt', 'ppt', 'pptx'];

  protected $file;

  protected $fileName;

  protected $errors = [];

  public function __construct(Request $request)
  {
      if (!empty($_FILES)) {
          $tempFile   = $_FILES['Filedata']['tmp_name'];

          $this->file = $_FILES['Filedata'];

          $this->fileName = $this->__pathinfo($_FILES['Filedata']['name']);

          if (!in_array(strtolower($this->fileName['extension']), $this->fileTypes)) {
              $this->errors = ['errors' => ['Формат файла не подходит. ('. implode (', ', $this->fileTypes) .')'] ];
          }
      }
  }

  public function newsFiles()
  {

    if (count($this->errors) == 0) {
      $name = $this->fileName['filename'];

      $ext = '.' . strtolower($this->fileName['extension']);

      $section_id = (int)$_POST['section_id'];
      $news_id    = (int)$_POST['news_id'];
      $lang       = $_POST['lang'];

      $path = public_path('data/media/news/files/');

      $news = News::where('section_id', $section_id)->find($news_id);

      if ($news) {
          $sind = $news->media('file')->orderBy('sind', 'DESC')->first();
          $item = ($sind) ? ++$sind->sind : 1 ;

          $media = new Media();

          $title = 'title_' . $lang;
          $media->section_id = $section_id;
          $media->news_id = $news->id;
          $media->good = 1;
          $media->type = 'file';
          $media->sind = $item;
          $media->lang = $lang;
          $media->$title = $name;
          $media->publish_at = Carbon::now();

          if ($media->save()) {
              $newFile = 'data/media/news/files/'. md5(Carbon::now() . $media->id) . $ext;

              if (File::exists($this->file['tmp_name'])) {
                  if (File::exists(public_path($newFile))) {
                      File::delete(public_path($newFile));
                  }

                  if (File::copy($this->file['tmp_name'], public_path($newFile))) {
                      File::delete($this->file['tmp_name']);
                      $media->link = $newFile;

                      if ($media->save()) {

                          return [
                             'success' => true,
                             'file' => $media->toArray()
                         ];
                      } else {
                          $media->delete();
                      }
                  }
              }
          }
      }

      return ['errors' => ['Ошибка загрузки, обратитесь к администратору.']];
    }

    return $this->errors;
  }

	public function objectFiles()
  {
    if (count($this->errors) == 0) {
      $name = $this->fileName['filename'];

      $ext = '.' . strtolower($this->fileName['extension']);

      $section_id = (int)$_POST['section_id'];
      $object_id  = (int)$_POST['object_id'];
      $lang       = $_POST['lang'];

      $path = public_path('data/media/objects/files/');

      $object = Objects::where('section_id', $section_id)->find($object_id);

      if ($object) {
          $sind = $object->media('file')->orderBy('sind', 'DESC')->first();
          $item = ($sind) ? ++$sind->sind : 1 ;

          $media = new Media();

          $media->section_id = $section_id;
          $media->object_id = $object->id;
          $media->good = 1;
          $media->type = 'file';
          $media->sind = $item;
          $media->lang = $lang;
          $media->{'title_' . $lang} = $name;
          $media->publish_at = Carbon::now();

          if ($media->save()) {
              $newFile = 'data/media/objects/files/'. md5(Carbon::now() . $media->id) . $ext;

              if (File::exists($this->file['tmp_name'])) {
                  if (File::exists(public_path($newFile))) {
                      File::delete(public_path($newFile));
                  }

                  if (File::copy($this->file['tmp_name'], public_path($newFile))) {
                      File::delete($this->file['tmp_name']);
                      $media->link = $newFile;

                      if ($media->save()) {

                          return [
                             'success' => true,
                             'file' => $media->toArray()
                         ];
                      } else {
                          $media->delete();
                      }
                  }
              }
          }
      }

      return ['errors' => ['Ошибка загрузки, обратитесь к администратору.']];
    }

    return $this->errors;
  }

  public function saveFileName ($id, Request $request)
  {
    $title = $request->input('title');

    $media = Media::find($id);

    if (!is_null($media)) {
      $column = 'title_' . $media->lang ?? 'ru';

      $media->$column = $title;

      if ($media->save()) {
        return ['success' => ['Сохранено!!!']];
      }
    }

    return ['errors' => ['Ошибка, файл не найден.']];
  }

  /**
   * Upload files to rubrics
   *
   * @return array file data
   */
  public function rubricsFiles()
  {
    if (count($this->errors) == 0) {
      $name = $this->fileName['filename'];

      $ext = '.' . strtolower($this->fileName['extension']);

      $rubric_id    = (int)$_POST['rubric_id'];
      $lang       = $_POST['lang'];

      $path = public_path('data/media/rubrics/');

      $rubric = Rubrics::find($rubric_id);

      if ($rubric) {
          $sind = $rubric->files()->orderBy('sind', 'DESC')->first();
          $item = ($sind) ? ++$sind->sind : 1 ;

          $file = new Media();

          $title = 'title_' . $lang;
          $file->good = 1;
          $file->rubric_id = $rubric_id;
          $file->type = 'file';
          $file->sind = $item;
          $file->lang = $lang;
          $file->$title = $name;
          $file->publish_at = Carbon::now();

          if ($file->save()) {
              $newFile = 'data/media/rubrics/'. md5(Carbon::now() . $file->id) . $ext;

              if (File::exists($this->file['tmp_name'])) {
                  if (File::exists(public_path($newFile))) {
                      File::delete(public_path($newFile));
                  }

                  if (File::copy($this->file['tmp_name'], public_path($newFile))) {
                      File::delete($this->file['tmp_name']);
                      $file->link = $newFile;

                      if ($file->save()) {
                        return [
                          'success' => true,
                          'file' => $file->toArray()
                       ];
                      } else {
                          $file->delete();
                      }
                  }
              }
          }
      }

      return ['errors' => ['Ошибка загрузки, обратитесь к администратору.']];
    }

    return $this->errors;
  }

  protected function __pathinfo ($path, $options = null)
  {
      $path = urlencode($path);
      $parts = null === $options ? pathinfo($path) : pathinfo($path, $options);
      foreach ($parts as $field => $value) {
          $parts[$field] = urldecode($value);
      }
      return $parts;
  }

}
