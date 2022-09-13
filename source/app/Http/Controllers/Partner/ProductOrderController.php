<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\Traits\SendMail;
use App\ProductOrderDetails;
use App\ProductOrder;

class ProductOrderController extends Controller
{
use SendMail;


    public function product_orders(Request $request){
        $orders = ProductOrderDetails::with('user')->with('order')->has('user')->has('order')->where('vendor_id',$request->vendor_id)->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }


    
    public function complete_order(Request $request){
        $order = ProductOrderDetails::with('user')->with('order')->has('user')->has('order')->where('store_order_id',$request->store_order_id)->first();
    	if($order){
    	    $order->status = 2;
    	    $order->save();
            $cart = ProductOrderDetails::where('order_cart_id',$order->order_cart_id)->where('status',1)->first();
            if(!$cart){
                ProductOrder::where('cart_id',$order->order_cart_id)->update(['status'=>'2']);
            }
    		$message = array('status'=>'1', 'message'=>'Updated Successfully', 'data'=>$order, 'cart'=>$cart);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function product_orders_cancel(Request $request){
        $order = ProductOrderDetails::where('store_order_id',$request->store_order_id)->first();
    	if($order){
    	    $order->status = 4;
    	    $order->save();
    		$message = array('status'=>'1', 'message'=>'Cancelled Successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Some Error Occurred.');
	        return $message;
    	}
    }
    
}
