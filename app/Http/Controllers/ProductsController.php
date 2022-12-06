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

        $this->validate($request,[
            'search' => 'string'
        ]);

        $products = Products::where('name', 'like', '%' . request('search') . '%')
                ->with('products_images')
                ->get();
       
        return response()->json(['Products'=>$products]);

   }

   public function filterByPrice(Request $request){

        $this->validate($request, [
            'min' => 'required',
            'max' => 'required|regex:/^\d*(\.\d{2})?$/'
        ]);

        $min = $request->min;
        $max = $request->max;

        if ($min < 0){
            return response()->json(['message'=>'cannot have numbers minus 0']);
        }

        $products = Products::where('price', '>=', $min)
            ->where('price','<=', $max)
            ->get();

        return response()->json(['Price'=>$products]);

   }

   public function filterByCategories(Request $request){
        $data = [];
        $this->validate($request, [
            'categories_id'=> 'required'
        ]);


        $subcategories= SubCategories::where('categories_id', request('categories_id'))
            ->get();

        foreach ($subcategories as $key => $subcategorie) {

            $products = Products::where('sub_categories_id', $subcategorie->id)
                ->get();

            $data[] = $products;
        }
        return response()->json([$data]);
   }

   public function filterBySubcategories(Request $request){
        $this->validate($request, [
            'sub_categories_id'=> 'required'
        ]);

        $products = Products::where('sub_categories_id', request('sub_categories_id'))
                ->get();
            
        return response()->json([$products]);
    
   }
   
}