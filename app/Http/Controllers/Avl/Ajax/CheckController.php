<?php namespace App\Http\Controllers\Avl\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{

    public function index ()
    {
        $targetFolder = '/uploads/tmps'; // Relative to the root and should match the upload folder in the uploader script

        return (file_exists(public_path($targetFolder . '/' . $_POST['filename']))) ? 1 : 0;
    }
}
