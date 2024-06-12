<?php

namespace App\Http\Controllers;

use App\Models\ImageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageItemController extends Controller
{



    function generateRandomToken() {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < 5; $i++) {
            $index = rand(0, strlen($alphabet) - 1);
            $token .= $alphabet[$index];
        }

        return $token;
    }

    public function store(Request $request){
    $imagesData = [];
    // if (!ImageItem::where('table_name' , $request->table_name)->where('token' , $request->token_image)->exists()) {
                    $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    $imagesData = [];
                    $this->validate($request, [
                    'image.*' => 'required|mimes:' . implode(',', $allowedImageTypes),
                    ]);
                    foreach ($request->file('image') as $image) {
                        $original_name = $image->getClientOriginalName();
                        $imagesData[] = [
                            'url' => $this->uploadImage($image , $original_name, 'en', $request->table_name, $request->token_image ),
                            'language' => 'en',
                            'status' => 'all'
                        ];
          }
    // }
    return response()->json(['images' => $imagesData]);
}
    public function uploadImage($image, $original_name, $language, $table_name, $token) {

        $imageName = trim($this->generateRandomToken()  .'-'.now().'.'.$image->getClientOriginalExtension());
        $path = 'assets/' . $table_name;
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        $image->move($path, $imageName);
        // $imageSize = $image->getSize();
            $d =  ImageItem::create([
            'url' => $path . '/' . $imageName,
            'original_name' => $original_name,
            'language' => $language,
            'table_name' => $table_name,
            'token' => $token,
            'status' => 'all', // على سبيل المثال
            'image_size' => '1', // حقل لحفظ مساحة الصورة
        ]);

        return ('https://sweeta2z.com/back-end/' . $path . '/' . $imageName);
    }


    public function  delete (Request $request) {
        ImageItem::where('id' , $request->image_id)->delete();
        return 200 ;
    }
}

