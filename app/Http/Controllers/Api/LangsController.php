<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Langs;

class LangsController extends Controller
{

    public function getLangs ()
    {
        return Langs::all()->toArray() ?? [];
    }
}
