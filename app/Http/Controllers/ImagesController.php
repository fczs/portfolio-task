<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{

    /**
     * Gets $num images with $offset from db
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
     * Gets new images on window scrolling, shift search if images were added in current session
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
            return $this->getImages($offset + $request["shift"], $num);
        } else {
            return "-1";
        }
    }

    /**
     * Gets random image
     *
     * @return object
     */
    public function random()
    {
        $imageNum = rand(0, Image::count() - 1);
        $image = $this->getImages($imageNum, 1);

        $url = "";
        foreach ($image as $i) {
            $url = $i["url"];
        }

        if ($url != "") {
            return response()->json(["url" => $url, "status" => "ok"]);
        } else {
            return response()->json(["status" => "error"]);
        }
    }
}
