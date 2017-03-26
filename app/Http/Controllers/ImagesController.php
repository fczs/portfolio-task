<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{

    /**
     * Gets $num image rows with $offset from db
     *
     * @param number $offset
     * @param number $num
     *
     * @return array
     */
    private function getImages($offset, $num)
    {
        return Image::orderByDesc("created_at")->skip($offset)->take($num)->get();
    }

    /**
     * Shows main page with number of images in a grid
     *
     */
    public function show()
    {
        $images = $this->getImages(0, config('app.firstPage'));
        return view('app', compact('images'));
    }

    /**
     * Stores image in "/images" folder and image information in db
     *
     * @param Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        $title = htmlspecialchars($request["title"]);
        $url = '/images/' . uniqid() . '_' . basename($_FILES["image"]["name"]);

        File::move($_FILES["image"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $url);
        Image::create(['title' => $title, 'url' => $url]);

        return ["title" => $title, "url" => $url];
        
    }

    /**
     * Gets new images on window scrolling
     *
     * @param Request $request
     *
     * @return array or string
     */
    public function scroll(Request $request)
    {
        $num = config('app.scrollingPages');
        $offset = $num + $num * $request["page"];
        if ($offset < Image::count()) {
            return $this->getImages($offset, $num);
        } else {
            return "-1";
        }
    }
}
