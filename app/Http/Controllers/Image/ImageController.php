<?php namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use File;
use Image;

class ImageController extends Controller
{
  private $path;
  private $w;
  private $h;

  public function resize($w, $h, $path)
  {
    if (File::exists(public_path($path))) {
      if (in_array(strtolower($this->getExtension($path)), ['jpg', 'jpeg', 'png'])) {
        $srcArray = explode('/', $path);
        $imageName = array_pop ($srcArray);

        $thumbPath = public_path(@implode('/', $srcArray) . '/_thumbs');
        $thumb = $thumbPath . '/thumb_' . $w . 'x' . $h . '-' . $imageName;

        if (!File::exists($thumbPath)) {
          $result = File::makeDirectory($thumbPath, 0775);
          if (!$result) {
            abort(404);
          }
        }

        if (!File::exists($thumb)) {

          $img = Image::make(public_path($path));
          if ($img->height() > $h) {
            $img->fit($w, $h, function ($constraint) {
              $constraint->upsize();
              // $constraint->aspectRatio();
            });
          }

          $img->save($thumb, 75);
        } else {
          $img = Image::make($thumb);
        }

        return $img->response();
      }

      $originalImg = Image::make(public_path($path));

      return $originalImg->response();
    }

    return "";
  }

  public function save($id)
  {
    $media = Media::find($id);

    if (!is_null($media)) {

      if (File::exists(public_path($media->link))) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
          ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');

        $file = pathinfo(public_path($media->link));
        $fileName = $media->title_ru . '.' . $file['extension'];
        if (!is_null($media->lang)) {
          $lang = 'title_' .$media->lang;
          $fileName = $media->$lang . '.' . $file['extension'];
        }
        // dd($fileName);
        header('Content-Disposition: attachment; filename="' . $fileName . '".' . $file['extension']);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(public_path($media->link)));
        // читаем файл и отправляем его пользователю
        readfile(public_path($media->link));
        exit;
      }
    }

    abort(404);
  }

  protected function getExtension ($fileName) {
    return substr($fileName, strrpos($fileName, '.') + 1);
  }

}
