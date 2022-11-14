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

        if(isset($options['images'])){

            $productName = $options['name'];
            $imgs = $options['images'];

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

        return true;
    }
}



// private function save_images($file_array)
//     {  
//         $configs_path = $this->get_config_path();
//         foreach ($file_array as $file) {
//             $file_name = $file->new_name;
//             $new_file_path = $configs_path . "/" . $file_name;
//             $partial_url = $this->id . "/" . $file_name;
//             $ext = $file->extension();
//             move_uploaded_file($file->getPathname(), $new_file_path);
//             chmod($new_file_path, 0644);
//             $checksum =  hash_file('md5', $new_file_path);
//             $config = new PrinterConfig(['url' => $partial_url , 'printer_ticket_id' => $this->id, "checksum" => $checksum , "filetype" => $ext]);
//             $config->save();
//         }
//     }
