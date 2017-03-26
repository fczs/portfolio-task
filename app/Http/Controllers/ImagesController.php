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
        $title = htmlspecialchars($request["title"]);
        $url = '/images/' . uniqid() . '_' . basename($_FILES["image"]["name"]);

        File::move($_FILES["image"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $url);
        Image::create(['title' => $title, 'url' => $url]);

        return response()->json(["title" => $title, "url" => $url]);
    }
}
