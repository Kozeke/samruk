<?php namespace App\Http\Controllers\Site\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Mail;
use File;

class ProfileController extends Controller
{
  protected $fileTypes = ['jpg', 'jpeg', 'gif', 'png', 'JPEG', 'JPG', 'PNG', 'GIF'];

  protected $file;

  protected $maxFileSize = 3145728;   // размер загружаемого файла не более 3-х мб

  protected $fileName;

  /**
   * Загрузка фото профиля
   *
   * @param  Request $request
   * @return json
   */
  public function profilePhoto (Request $request)
  {
      // if (!empty($_FILES)) {
      //     $tempFile   = $_FILES['Filedata']['tmp_name'];
      //
      //     $this->file = $_FILES['Filedata'];
      //
      //     $this->fileName = pathinfo($_FILES['Filedata']['name']);
      //
      //     if (!in_array(strtolower($this->fileName['extension']), $this->fileTypes)) {
      //         abort(404);
      //     }
      // }
      // dd($request->user());
      if ($request->hasFile('Filedata')) {

        $file = $request->file('Filedata');
        $file_name = $file->getClientOriginalName();
        $file_size = $file->getClientSize();
        $file_extension = $file->extension();

        $fileName = md5(time() . $request->user()->id) . "." . $file->extension();

        if ($file->move(public_path('data/profile'), $fileName)) {

          $user = $request->user();

          if (!is_null($user->photo)) {
            File::delete(public_path($user->photo));
          }

          $user->photo = '/data/profile/' . $fileName;

          if ($user->save()) {
            return [
              'success' => 'Файл успешно загружен',
              'data' => [
                'id' => $user->id,
                'photo' => $user->photo
              ]
            ];
          }

        }
      }
      return ['errors' => 'Ошибка загрузки файла'];

  }

}
