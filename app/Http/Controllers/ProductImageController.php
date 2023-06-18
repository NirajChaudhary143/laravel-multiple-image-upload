<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ProductImageController extends Controller
{
    public function store(Request $request){
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();

            $productImage = new ProductImage();
            $productImage->name = 'NULL';
            $productImage->product_id =$request->product_id;
            $productImage->save();

            $imageName = $productImage->id.'.'.$ext;

            $productImage->name = $imageName;
            $productImage->save();

            $sourcePath = $image->getPathName();
            $img = Image::make($sourcePath);
            $img->fit(350,300);
            $destPath = public_path('uploads/products/'.$imageName);
            $img->save($destPath);


            return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'name' => $imageName,
            'imagePath' => asset('uploads/products/'.$imageName)
]);
        }
    }
}
