<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
