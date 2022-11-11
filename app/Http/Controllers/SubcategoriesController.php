<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Categories;
use App\Models\SubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;


class SubcategoriesController extends Controller
{

    public function getSubCategories(){
        $subcategories = SubCategories::where([])->with('categories')->get();
        return response()->json($subcategories);
   }

   public function addSubCategories(Request $request)
   {

       $payload = $request->all();
       $admin = auth()->user()->admin;

       $this->validate($request, [
           'name'=> 'required|string',
           'categories_id' => 'required'
       ]);

       if($admin == 1){
           $subcategories = new SubCategories($payload);
           $subcategories->save($payload);
           return response()->json($subcategories);
       }else{
           return response()->json([
               'status' => '401',
               'message' => 'Permission denied'
           ]);
       }

   }

   public function updateSubCategorie(Request $request, $id)
   {
       $payload = $request->all();
       $admin = auth()->user()->admin;

       $this->validate($request, [
           'name'=> 'required|string',
           'categories_id' => 'required|exists:categories,id'
       ]);

       $subcategorie = SubCategories::where(['id'=>$id])->first();

       if ($admin == 1){
           if ($subcategorie != null){
               $subcategorie->name = $request->name;
               $subcategorie->categories_id = $request->categories_id;
               $subcategorie->save();
           }else{
               return response()->json([
                   'status' => '404',
                   'message' => 'Sub Categorie dont exist'
               ]);
           }
           
           return response()->json("Sub Categorie updated successfully!");
       }else{
           return response()->json([
               'status' => '401',
               'message' => 'Permission denied'
           ]);
       }
   }

   public function removeSubCategorie($id){

    $admin = auth()->user()->admin;
    $subcategories = SubCategories::where(['categories_id'=>$id])->get();
    $products = Products::where(['sub_categories_id'=>$id])->get();

    if ($subcategories != null){

        if($admin == 1){

            if($products != null){
                foreach ($products as $product){
                    $product->sub_categories_id = null;
                    $product->save();
                }
            }

            if ($subcategories != null){

                foreach ($subcategories as $subcategorie) {
                    $subcategorie->delete();
                }
            }
        }else{
            return response()->json([
                'status' => '401',
                'message' => 'Unauthorized Request'
            ]);
        }

        return response()->json("Sub Categories deleted successfully");
    }else{

        return response()->json([
            'status' => '404',
            'message' => 'Not Found'
        ]);
    }
}





}
