<?php

namespace App\Http\Controllers;
use App\order;
use App\cart;
use App\order_dtl;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request) {
        $data = cart::where('id', $request->cart_id)
			->get()->toJson(JSON_PRETTY_PRINT);
			// $k=$data->id;
        $r=json_decode($data);

 

        $ord = new order; 
         
        $ord->cart_id = $request->cart_id;
        $ord->user_id = $r[0]->user_id;
        $ord->total_amount = $r[0]->price;
        $ord->payment_id = $request->payment_id;
        
         $ord->save();

         $ord_dtl = new order_dtl; 
         
         $ord_dtl->order_id = $ord->id;
         $ord_dtl->product_id = $r[0]->product_id;
         $ord_dtl->user_id = $r[0]->user_id;
        //  $ord_dtl->delivery_status = $request->delivery_status;

         $ord_dtl->save(); 


        $cart = cart::find($request->cart_id);
        $cart->status = 3;
	    $cart->save();
    
        return response()->json([
            "status"=> 1,
            "message" => "New Order added Successfully",
            'orderId' => $ord->id
        ], 201);
    }
}
