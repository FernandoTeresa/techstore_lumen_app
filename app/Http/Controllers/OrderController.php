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
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{

    public function getOrder(){
        $userId = auth()->user()->id;

        $orders = Order::where(['user_id'=> $userId])->with('order_items')->get();
        return response()->json($orders);
    }

    public function addOrder(Request $request){
        $payload = $request->all();

        $this->validate($request,[
            //Order table
            'user_id' => 'required',
            'total' => 'required',
        ]);

        $order = new Order ($payload);
        $order->save($payload);

        return response()->json($order);
    
    }

    public function getOrderById($id){
        $orders = Order::where(['id'=>$id])->with('order_items')->first();
        return response()->json($orders);
    }

    public function addOrderItems(Request $request){

        $payload = $request->all();

        $this->validate($request, [
            'count' => 'required',
            'unitprice' => 'required',
            'product_id'=> 'required',
            'order_id' => 'required'
        ]);

        $orderItems = new OrderItem($payload);
        
        if ($orderItems->save($payload)){

        }

        return response()->json($orderItems);

    }



}