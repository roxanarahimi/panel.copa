<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class ImageController extends Controller
{
    public function uploadImage($base64_str, $name, $folderPath)
    {
        //base64_encode($base64_str);
        //base64_decode($base64_str);

        $image_parts = explode(";base64,", $base64_str);
//        $image_type_aux = explode("image/", $image_parts[0]);
//        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
//        $file = $folderPath . $name . '.' . $image_type;

        file_put_contents($folderPath . $name, $image_base64);
        $file = $folderPath . $name;
        return $file;


    }
    public function uploadEditorImage(Request $request)
    {

//        return $request;
        $image_parts = explode(";base64,", $request['code']);
        $image_base64 = base64_decode($image_parts[1]);
        $name = str_replace('.jpg', uniqid().'.jpg',$request['name']);
        file_put_contents($request['path'] . $name, $image_base64);
        $file = '/'.$request['path'] . $name;
//        $this->resizeImage($request['path'],$name);
        return response($file,200);

    }

    function resizeImage($path, $name)
    {
        $image_name = $path . $name;

        //main
        $image = imagecreatefromjpeg($image_name);
        $imgResized = imagescale($image, 1000, 563);
        imagejpeg($imgResized, $image_name);
        //thumb
        $imgResized = imagescale($image, 400, 225);
        $image_name = str_replace('.jpg', '_thumb.jpg', $image_name);
        imagejpeg($imgResized, $image_name);
        $image = imagecreatefromjpeg($image_name);
//            if ($width>0){
//                $imgResized = imagescale($image, $width, $width);
//            }

        imagejpeg($imgResized, $image_name);
    }
    public function uploadIcon($base64_str, $name, $folderPath)
    {
        //base64_encode($base64_str);
        //base64_decode($base64_str);

        $image_parts = explode(";base64,", $base64_str);
//        $image_type_aux = explode("image/", $image_parts[0]);
//        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
//        $file = $folderPath . $name . '.' . $image_type;

        file_put_contents($folderPath . $name, $image_base64);
        $file = $folderPath . $name;
        return $file;


    }

    function resizeIcon($path, $name,$newName, $width = 0)
    {
        $image_name = $path . $name;

        //main
        $image = imagecreatefrompng($image_name);
        $imgResized = imagescale($image, $width, $width);
        imagepng($imgResized, $image_name);

    }


    function makeIconPack(Request $request)
    {
        $name = 'icon_' . uniqid() . '.png';
        $this->uploadIcon($request['image'], $name, 'images/icons/');
        $this->resizeIcon('images/icons/', $name, 100);

        $this->resizeIcon('images/icons/', 'android-chrome-192x192.png', 192);
        $this->resizeIcon('images/icons/', 'android-chrome-512x512.png', 512);
        $this->resizeIcon('images/icons/', 'android-chrome-maskable192x192.png', 192);
        $this->resizeIcon('images/icons/', 'android-chrome-maskable-512x512.png', 512);
        $this->resizeIcon('images/icons/', 'apple-touch-icon.png', 180);
        $this->resizeIcon('images/icons/', 'apple-touch-icon-60x60.png', 60);
        $this->resizeIcon('images/icons/', 'apple-touch-icon-76x76.png', 76);
        $this->resizeIcon('images/icons/', 'apple-touch-icon-120x120.png', 120);
        $this->resizeIcon('images/icons/', 'apple-touch-icon-152x152.png', 152);
        $this->resizeIcon('images/icons/', 'apple-touch-icon-180x180.png', 180);
        $this->resizeIcon('images/icons/', 'favicon-16x16.png', 16);
        $this->resizeIcon('images/icons/', 'favicon-32x32.png', 32);
        $this->resizeIcon('images/icons/', 'msapplication-icon-144x144.png', 144);
        $this->resizeIcon('images/icons/', 'mstile-150x150.png', 150);
//       $this->resizeIcon('images/icons/', 'safari-pinned-tab.svg');


    }

}
