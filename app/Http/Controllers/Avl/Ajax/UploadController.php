<?php namespace App\Http\Controllers\Avl\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use Image;
use File;
Use App\Models\User;

class UploadController extends AvlController
{
  protected $fileTypes = ['jpg', 'jpeg', 'gif', 'png', 'JPEG', 'JPG', 'PNG', 'GIF'];

  protected $file;

  protected $fileName;

  public function __construct(Request $request)
  {
    if (!empty($_FILES)) {

    	$tempFile   = $_FILES['Filedata']['tmp_name'];

    	$this->file = $_FILES['Filedata'];

    	$this->fileName = pathinfo($_FILES['Filedata']['name']);

    	if (!in_array(strtolower($this->fileName['extension']), $this->fileTypes)) {
        abort(404);
      }
    }
  }

  public function profile ()
  {
    if($this->file['size'] < config('avl.picMaxSize')) {
      $name = $this->fileName['filename'];

      $ext = '.'.strtolower($this->fileName['extension']);
      $user_id = (int)$_POST['user_id'];

      $user = User::find($user_id);

      $fileD = '/data/profile/profile-'. $user->id . $ext;

      if (File::exists($this->file['tmp_name'])) {


        if (File::exists(public_path($user->photo))){
          File::delete(public_path($user->photo));
        }

        if (File::exists(public_path($fileD))) {
          File::delete(public_path($fileD));
        }
        $this->removeThumbsProfile($user->id);

        if (File::copy($this->file['tmp_name'], public_path($fileD))) {
          File::delete($this->file['tmp_name']);

          $img = Image::make(public_path($fileD));

          $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
          $img->save(public_path($fileD));

          $user->photo  = $fileD;
          $user->save();
          return [
            'errors' => false,
            'file' => [
              'id'    => $user->id,
              'image' => $fileD
            ]
          ];
        }
      }
      return ['errors' => true];
     }
    return ['errors' => true, 'messages'=>['Размер фотографии превышает <b>'.config('avl.picMaxSize').'кб</b>']];
  }


  public function removeThumbsProfile ($id)
  {
    $filepath = public_path('data/profile/_thumbs/');
    foreach(glob($filepath . 'thumb_*-profile-'.$id.'.*') as $file) {
      File::delete($file);
    }
    return true;
  }
}
