<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class OrderItem extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'count','unitprice','product_id','order_id'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product(){
        return $this->hasOne(Products::class, 'id', 'product_id')->with('products_images');
    }

    protected $table='order_items';


}