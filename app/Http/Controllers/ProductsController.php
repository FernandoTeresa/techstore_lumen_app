<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\SubCategories;
use App\Models\ProductsImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;


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

   public function removeProduct($id){

        $admin = auth()->user()->admin;

        $product = Products::where(['id'=>$id])->first();
        $productImages = ProductsImages::where(['product_id'=>$id])->first();
        $orderItems = OrderItem::where(['product_id'=>$id])->get();

        if ($product != null){
            if ($admin == 1){
                $product->delete();
            }else{
                return response()->json([
                    'status' => '401',
                    'message' => 'Unauthorized Request'
                ]);

            }
            return response()->json('Product deleted successfully!'); 
            
        }else{

            return response()->json([
                'status' => '404',
                'message' => 'Product not found !!'
            ]);

        }

   }

   public function updateProduct(Request $request, $id)
   {
        $admin = auth()->user()->admin;
        $payload = $request->all();

        $this->validate($request,[
            'name' => 'required|string|unique:products',
            'desc' => 'required|string',
            'price' => 'required',
            'stock' => 'required|integer',
            'sub_categories_id' => 'required'
        ]);

        $product = Products::where(['id'=>$id])->first();

        if ($admin == 1){
            $product = $payload;
            $product->save();

            return response()->json("Product updated successfully!");
        }else{
            return response()->json([
                'status' => '401',
                'message' => 'Unauthorized Request'
            ]);
        }
   }

   
}