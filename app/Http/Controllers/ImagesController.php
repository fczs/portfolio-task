<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{
    public function show()
    {
        return view('app');
    }

    public function store(Request $request)
    {
        return "0";
    }
}
