<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use App\Traits\SendMail;
use App\Traits\SendSms;
use App\Order;

class OrderController extends Controller
{

   public $login_check_message = 'please login first';

   public function orders($id){
     if(Session::has('vendor'))
     {
        $status = $id;
        $data['status'] = $status;
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        if($status==0){
            $orders = Order::with('vendor')->with('user')->with('staff')->has('vendor')->has('user')->has('staff')->whereIn('status',[0,1,6])->where('vendor_id',$vendor->vendor_id)->get();
        }
        if($status==1){
            $orders = Order::with('vendor')->with('user')->with('staff')->has('vendor')->has('user')->has('staff')->where('status',2)->where('vendor_id',$vendor->vendor_id)->get();
        }
        if($status==2){
            $orders = Order::with('vendor')->with('user')->with('staff')->has('vendor')->has('user')->has('staff')->whereIn('status',[3,4,5])->where('vendor_id',$vendor->vendor_id)->get();
        }
        if($status==3){
            $orders = Order::with('vendor')->with('user')->with('staff')->has('vendor')->has('user')->has('staff')->whereIn('status',[0,1,6])->where('vendor_id',$vendor->vendor_id)->whereDate('service_date','<',date('Y-m-d'))->get();
        }
        $data['orders'] = $orders;
		return view('vendor.orders.orders',$data);
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }
    
    public function orders_accepted($order_id){
     if(Session::has('vendor'))
     {
        $order = Order::find($order_id);
        $order->status = 6;
        $order->save();
		return back()->with('success','Order is Accepted Successfully.');
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }

    public function orders_complete($order_id){
     if(Session::has('vendor'))
     {
        $order = Order::find($order_id);
        $order->status = 2;
        $order->save();
		return back()->with('success','Order is Completed Successfully.');
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }

    public function orders_cancelled($order_id){
     if(Session::has('vendor'))
     {
        $order = Order::find($order_id);
        $order->status = 5;
        $order->save();
		return back()->with('success','Order is Cancelled Successfully.');
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }
    
    
    public function vendor_earnings(Request $request){
     if(Session::has('vendor')){
        $vendor_email = Session::get('vendor');
        $vendor = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        $admin_share = $vendor->admin_share;
        $data['admin_share'] = $vendor->admin_share;
        $vendor_id = $vendor->vendor_id;
        $data['total_price'] = Order::where(['vendor_id'=>$vendor_id,'status'=>2])->sum('total_price');

        $share_sent = Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>1,'payment_method'=>'COD'])->get();
        $data['share_sent_amount'] = ( ( $share_sent->sum('total_price') * $admin_share ) / 100);
        $data['share_sent'] = $share_sent;

        $share_sent_pending = Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>0,'payment_method'=>'COD'])->get();
        $data['share_sent_pending_amount'] = ( ( $share_sent_pending->sum('total_price') * $admin_share ) / 100);
        $data['share_sent_pending'] = $share_sent_pending;

        $share_given = Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>1])->whereNotIn('payment_method',['COD'])->get();
        $data['share_given_amount'] = ( ( $share_given->sum('total_price') * $admin_share ) / 100);
        $data['share_given'] = $share_given;

        $share_given_pending = Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>0])->whereNotIn('payment_method',['COD'])->get();
        $data['share_given_pending_amount'] = ( ( $share_given_pending->sum('total_price') * $admin_share ) / 100);
        $data['share_given_pending'] = $share_given_pending;

		return view('vendor.orders.vendor_earnings',$data);
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }
    
    
    public function paid_to_admin(Request $request){
     if(Session::has('vendor')){
        $vendor_email = Session::get('vendor');
        $vendor = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        $admin_share = $vendor->admin_share;
        $data['admin_share'] = $vendor->admin_share;
        $vendor_id = $vendor->vendor_id;

        Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>0,'payment_method'=>'COD'])->update(['share_send_status'=>1]);

		return back()->with('success','Request sent Successfully.');
     }else{
        return redirect()->route('vendorlogin')->withErrors($login_check_message);
     }
    }
    
}
