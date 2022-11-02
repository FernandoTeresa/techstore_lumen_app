<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsImages;
use Illuminate\Support\Facades\File;
use App\Models\Products;

use Illuminate\Http\UploadedFile;

class UploadController extends Controller
{

    public function getImages(){
        $images = ProductsImages::where([])->get();
        return response()->json($images, 200);
    }


    public function getImage($id){
        $images = ProductsImages::where([])->get();
        return response()->json($images,200);
    }

   public function upload(Request $request, $id){

        $admin = auth()->user()->admin;
        $product = Products::where(['id' =>$id])->first();
        $imgs = $request->file('images');


        $this->validate($request, [
            'images'=>'required',
            'images.*'=>'mimes:png,jpeg,jpg,gif'

        ]);

        if ($admin == 1){

            if ($request->hasfile('images')){

                foreach($imgs as $img){

                    $ext= $img->getClientOriginalExtension();
                    $path = '/img/';

                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }

                    $random_name = rand(1,1000);
                    $name = $random_name.'.' . $ext;
                    $dirname = preg_replace(' /\s+/ ', '', $product->name);
                    $endpath = $path.$dirname;

                    if(!File::isDirectory($endpath)){
                        File::makeDirectory($endpath, 0777, true, true);
                    }

                    $img->move($endpath,$name);

                    $data= $endpath.'/'.$name;
                    $file = new ProductsImages();
                    $file->images = $data;
                    $file->product_id = $product->id;
                    $file->save();
                    
                }

                return response()->json('Image Uploaded successfully!');

            }else{
                return response()->json('Image not found');
            }
        
        }else{

            return response()->json([
                'status' => '401',
                'message' => 'Unauthorized Request'
            ]);
        }
    }


}
