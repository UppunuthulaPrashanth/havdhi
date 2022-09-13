<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use App\Traits\SendMail;
use App\Traits\SendSms;
use App\ProductOrder;
use App\ProductOrderDetails;

class ProductOrderController extends Controller
{

   public $login_check_message = 'please login first';

   public function orders($id){
     if(Session::has('cityadmin'))
     {
        $status = $id;
        $data['status'] = $status;
        $cityadmin_email=Session::get('cityadmin');
        $data['cityadmin_email'] = $cityadmin_email;
        $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
        $data['cityadmin'] = $cityadmin;

        if($status==0){
            $orders = ProductOrderDetails::with('vendor')->with('user')->has('vendor')->has('user')->whereIn('status',[0,1])->orderBy('order_cart_id')->get();
        }
        if($status==1){
            $orders = ProductOrderDetails::with('vendor')->with('user')->has('vendor')->has('user')->where('status',2)->orderBy('order_cart_id')->get();
        }
        if($status==2){
            $orders = ProductOrderDetails::with('vendor')->with('user')->has('vendor')->has('user')->whereIn('status',[3,4])->orderBy('order_cart_id')->get();
        }
        if($status==3){
            $orders = ProductOrderDetails::with('vendor')->with('user')->has('vendor')->has('user')->whereIn('status',[0,1])->whereDate('order_date','<',date('Y-m-d'))->orderBy('order_cart_id')->get();
        }
        $data['orders'] = $orders;
		return view('cityadmin.productorders.orders',$data);
     }else{
        return redirect()->route('cityadminlogin')->withErrors($login_check_message);
     }
    }
    
    public function orders_accepted($order_id){
     if(Session::has('cityadmin'))
     {
        $cityadmin_email=Session::get('cityadmin');
        $data['cityadmin_email'] = $cityadmin_email;
        $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
        $data['cityadmin'] = $cityadmin;

        $order = ProductOrderDetails::find($order_id);
        $order->status = 2;
        $order->save();
        $order_test = ProductOrderDetails::where('store_order_id',$order_id)->where('status',1)->first();
        if(!$order_test){
            $order = ProductOrder::where('cart_id',$order->order_cart_id)->update(['status'=>2]);
        }
		return back()->with('success','Order is Accepted Successfully.');
     }else{
        return redirect()->route('cityadminlogin')->withErrors($login_check_message);
     }
    }

    public function orders_cancelled($order_id){
     if(Session::has('cityadmin'))
     {
        $cityadmin_email=Session::get('cityadmin');
        $data['cityadmin_email'] = $cityadmin_email;
        $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
        $data['cityadmin'] = $cityadmin;

        $order = ProductOrderDetails::find($order_id);
        $order->status = 4;
        $order->save();
        $order_test = ProductOrderDetails::where('store_order_id',$order_id)->where('status',1)->first();
        if(!$order_test){
            $order = ProductOrder::where('cart_id',$order->order_cart_id)->update(['status'=>2]);
        }
		return back()->with('success','Order is Cancelled Successfully.');
     }else{
        return redirect()->route('cityadminlogin')->withErrors($login_check_message);
     }
    }
    

    
}
