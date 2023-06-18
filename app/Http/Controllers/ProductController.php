<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProductController extends Controller
{
    public function index(){
        return view('products.create');
    }
    public function store(Request $request){
      $validate= $request->validate([
        'name'=>'required',
        'price'=>'required'
      ]);

      
      $product = new Product();
      $product->name = $request->name;
      $product->price = $request->price;
      $product->save();

      if(!empty($request->image_id)){
        foreach($request->image_id as $key => $imageId){
            $tempImage = TempImage::find($imageId);
            $extArray = explode('.',$tempImage->name);
            $ext =last($extArray);

            $productImage = new ProductImage();
           
            $productImage->name ='NULL';
            $productImage->product_id = $product->id;
            $productImage->save();

            $newImageName = $productImage->id.'.'.$ext;
            $productImage->name = $newImageName;
            $productImage->save();

// Image Intervention
            $sourcePath = public_path('uploads/temp/'.$tempImage->name);
            $img = Image::make($sourcePath);
            $img->fit(350,300);
            $destPath = public_path('uploads/products/'.$tempImage->name);
            $img->save($destPath);

            
        }
      }

        
    }

    public function list(){
        $products = Product::all();
        return view('products.list',compact('products'));
    }

    public function edit($id){
        $product= Product::find($id);
        $productImages= ProductImage::where('product_id',$product->id)->get();
        return view('products.edit',compact('product','productImages'));
    }

    public function update($product_id, Request $request) {

        $product = Product::find($product_id);
        

        $validate= $request->validate([
            'name'=>'required',
            'price'=>'required|numeric'
          ]);

        

            $product->name = $request->name;
            $product->price = $request->price;
            $product->save();

            
    }
}
