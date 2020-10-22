<?php

namespace App\Http\Controllers;
use App\payment;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPayment(Request $request) {
        $payment = new payment;     
        $payment->method = $request->method;
        $payment->provider = $request->provider;
        $payment->payment_info = $request->payment_info;
        $payment->payment_status = $request->payment_status;
        $payment->save();
    
        return response()->json([
            "message" => "New payment Method Created Successfully"
        ], 201);
    }

    public function getAllPayments() {
        $payment = payment::get()->toJson(JSON_PRETTY_PRINT);
        return response($payment, 200);
    }

    public function updatePayment(Request $request, $id) {
        if (payment::where('id', $id)->exists()) {
            $payment = payment::find($id);
            $payment->method = is_null($request->method) ? $payment->method : $request->method;
            $payment->provider = is_null($request->provider) ? $payment->provider : $request->provider;
            $payment->payment_info = is_null($request->payment_info) ? $payment->payment_info : $request->payment_info;
            $payment->payment_status = is_null($request->payment_status) ? $payment->status : $request->payment_status;
            $payment->save();
    
            return response()->json([
                "message" => "Payment Method updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Payment not UPdate"
            ], 404);
            
        }
    }
    public function deletePayment ($id) {
      if(payment::where('id', $id)->exists()) {
        $payment = payment::find($id);
        $payment->delete();
    
        return response()->json([
          "message" => "payment deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Payment details not found"
            ], 404);
        }
    }






}
