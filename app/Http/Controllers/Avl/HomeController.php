<?php namespace App\Http\Controllers\Avl;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;

class HomeController extends AvlController
{

    public function index (Request $request)
    {
      // dd(menu());
        return view('avl.index');
    }
}
