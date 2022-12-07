<?php

// echo '<pre>' . print_r(,true) . '<pre>'; die;

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\SubCategories;
use App\Models\Categories;
use App\Models\ProductsImages;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;


class ProductsController extends Controller
{

   public function getProducts()
   {
    $products = Products::where([])->with('products_images')->get();
    return response()->json($products);
   }

   public function addProducts(Request $request)
   {

    $payload = $request->all();
    $admin = auth()->user()->admin;

    $this->validate($request,[
        'name' => 'required|string|unique:products',
        'desc' => 'required|string',
        'price' => 'required|regex:/^\d*(\.\d{2})?$/',
        'stock' => 'required|integer',
        'sub_categories_id' => 'required'
    ]);

    if ($admin == 1){
        $product = new Products($payload);
        if ($product->save($payload)){

        }

        return response()->json($product);
    }else{
        return response()->json([
            'status' => '401',
            'message' => 'Permission denied'
        ]);
    }
   }

   public function getProduct($id)
   {    

    $product = Products::where(['id'=>$id])->with('sub_categories')->with('products_images')->first();
    return response()->json($product);

   }

   public function updateProduct(Request $request, $id)
   {
        $admin = auth()->user()->admin;
        $payload = $request->all();

        $this->validate($request,[
            'name' => 'required|string',
            'desc' => 'required|string',
            'price' => 'required',
            'stock' => 'required|integer',
            'sub_categories_id' => 'required'
        ]);

        if ($admin == 1){

            $product = Products::where(['id'=>$id])->update($payload);

            return response()->json("Product updated successfully!");
        }else{
            return response()->json([
                'status' => '401',
                'message' => 'Unauthorized Request'
            ]);
        }
   }


   public function filter(Request $request){

        $data = [];

        $this->validate($request,[
            'search' => 'string',
            'min' => 'string',
            'max' => 'string',
            'sub_categories_id'=> 'string'
        ]);

        $min = $request->min;
        $max = $request->max;

        if ($min < 1){
            return response()->json(['message'=>'cannot have numbers minus 1€']);
        }

        $products = Products::where('name', 'like', '%' . request('search') . '%')
                ->get();

        foreach($products as $product){

            if (($product->price >= $min && $product->price <= $max) || $product->sub_categories_id == $request->sub_categories_id){
                $data[] = $product;
            }
        }            
        
       
        return response()->json(['Products'=>$data]);

   }

   
}