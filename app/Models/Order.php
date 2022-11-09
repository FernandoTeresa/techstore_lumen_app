<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Order extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'total'
    ];

    public function user(){
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class)->with('product');
    }

    public function save(array $options =[])
    {

        if(!parent::save($options)){
            return false;
        }

        if (isset($options['order_items'])){

          foreach ($options['order_items'] as $item) {

                $order_item = [
                    'count' => $item['count'],
                    'unitprice' => $item['unitprice'],
                    'product_id' => $item['product_id'],
                    'order_id' => $this->id
                ];

                $orderItem = new OrderItem($order_item); 
                $orderItem->save();
          }
        }
        return true;
    }

   

}
