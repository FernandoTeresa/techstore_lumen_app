<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Products extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'desc', 'price', 'stock', 'sub_categories_id'
    ];

    public function sub_categories(){
        return $this->belongsTo(SubCategories::class, 'sub_categories_id');
    }

    public function products_images(){
        return $this->hasMany(ProductsImages::class, 'product_id');
    }

    protected $table = "products";

    public function save(array $options = []){

       
        if(!parent::save($options)){
            return false;
        }

        if(isset($options['images']) && is_array($options['images'])){

            $this->save_images($options['images']);

        }

        return true;
    }

    private function save_images($file_array)
    {  
        $productName = $this->name;
        $imgs =$file_array;

        foreach($imgs as $img){

            $ext= $img->getClientOriginalExtension();
            $path = 'img/';

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $random_name = rand(1,1000);
            $name = $random_name.'.' . $ext;
            $dirname = preg_replace(' /\s+/ ', '', $productName);
            $endpath = $path.$dirname;

            if(!File::isDirectory($endpath)){
                File::makeDirectory($endpath, 0777, true, true);
            }

            $img->move($endpath,$name);

            $data= $endpath.'/'.$name;
            $file = new ProductsImages();
            $file->images = $data;
            $file->product_id = $this->id;
            $file->save();
        }
    }
}