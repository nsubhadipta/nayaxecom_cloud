<?php

namespace App\Http\Controllers;
use App\cart;
use DB;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(Request $request) {
		// User::with('Permissons')->whereRaw('LENGTH(name) > 50')->get();
		$user = cart::where('user_id', $request->user_id)
		->where('product_id', $request->product_id)
		->where('status', 1)
		->get()->count();

 
		// print_r($user);exit;

	


        if ($user>0) {
			$data = cart::where('user_id', $request->user_id)
			->where('product_id', $request->product_id)
			->where('status', 1)
			->get(); //->toJson(JSON_PRETTY_PRINT) 
			// $k=$data->id;
			// $r=json_decode($data);
			$r=$data;
			$rk=$r[0]->id;

			// print_r($r[0]->id);exit;
			 
			$scats = cart::find($rk); 
			$ry=$scats->qty;
			// print_r($ry+$request->qty);exit;
            $scats->qty = $scats->qty + $request->qty;
            $scats->price = $scats->price + $request->price;
			// print_r($scats);exit;
			$scats->save();
    
            return response()->json([
                "status"=> 1,
                "message" => "records updated successfully"
            ], 200);
		}else{
			$cart = new cart; 
         
			$cart->user_id = $request->user_id;
			$cart->product_id = $request->product_id;
			$cart->qty = $request->qty;
			$cart->price = $request->price;
			
			

			$cart->save();
		
			return response()->json([
				"status"=> 1,
				"message" => "New Product added to Cart"
			], 201);
		}
    }


    public function getCart($uid) {
	    if (cart::where('user_id', $uid)->exists() && cart::where('status', 1)->count()>0) {
			$user = cart::where('user_id', $uid)
			->where('status', 1)
			->get();  //->toJson(JSON_PRETTY_PRINT)
			$output ['status']=1;
	        $output ['message']='Data Fetched Successfully';
	        $output ['result']=$user;
	        return response($output, 200);
		} else { 
	        return response()->json([ 
				"status"=>0,	
	          "message" => "Product Not Available in your Cart"
	        ], 404);

		}
  	}

}
