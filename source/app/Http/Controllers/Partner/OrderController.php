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
use App\Traits\SendSms;
use App\Traits\SendInapp;
use App\Items;
use App\Order;

class OrderController extends Controller
{
use SendMail;
use SendSms;
use SendInapp;


    public function appointment_history(Request $request){
        $orders = Order::with('user')->has('user')->where('vendor_id',$request->vendor_id)->whereNotIn('status',['0','1','6'])->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }

    public function pending_orders(Request $request){
        $orders = Order::with('user')->has('user')->where('vendor_id',$request->vendor_id)->whereIn('status',['0','1','6'])->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function completed_orders(Request $request){
        $orders = Order::where('vendor_id',$request->vendor_id)->where('status','2')->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function payment_failed_orders(Request $request){
        $orders = Order::where('vendor_id',$request->vendor_id)->where('status','3')->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function cancelled_orders(Request $request){
        $orders = Order::where('vendor_id',$request->vendor_id)->where('status','4')->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
   
    public function cancelled_by_partner_orders(Request $request){
        $orders = Order::where('vendor_id',$request->vendor_id)->where('status','5')->get();
    	if(count($orders)>0){
    		$message = array('status'=>'1', 'message'=>count($orders).' Records Found', 'data'=>$orders);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }

    public function booking_details(Request $request){
        $order = Order::with('items')->with('user')->with('staff')->has('items')->has('user')->has('staff')->where('id',$request->order_id)->first();
    	if($order){
    		$message = array('status'=>'1', 'message'=>'Order Found', 'data'=>$order);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function booking_cancel(Request $request){
        $order = Order::where('id',$request->order_id)->first();
    	if($order){
    	    $order->status = 5;
    	    $order->save();
    		$message = array('status'=>'1', 'message'=>'Cancelled Successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function booking_complete(Request $request){
        $order = Order::with('items')->with('staff')->with('vendor')->has('items')->has('staff')->has('vendor')->where('id',$request->order_id)->first();
    	if($order){
    	    $order->status = 2;
//    	    $order->items()->status = 2;
    	    if($order->save()){
    	        $result = $this->order_completed_sms($order->cart_id,$order->user_id);
    	        $result1 = $this->order_completed_inapp($order);
    	        $data_sms['sms_status'] = $result;
    	        $data_sms['notification_status'] = $result1;
    	        
    	         // assign scratch card
            $getScratchCard = DB::table('tbl_scratch_card')
                                ->where('min_cart_value','<=',$order->total_price)
                                ->orderBy('min_cart_value','DESC')
                                ->first();

            $scratch_card_offers = json_decode($getScratchCard->scratch_card_rewards);
            $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

            $earn = "You've won ".$earning." reward points";

            $created_at = Carbon::now();

         
                $insertScratchCard = DB::table('tbl_user_scratch_card')
                                    ->insert([
                                        'user_id'=>$order->user_id,
                                        'scratch_id'=>$getScratchCard->id,
                                        'earning'=>$earn,
                                        'earn_points'=>$earning,
                                        'is_scratch'=>0,
                                        'created_at'=>$created_at,
                                    ]);
    	    }
    		$message = array('status'=>'1', 'message'=>'Updated Successfully', 'data'=>$order);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }

    public function booking_confirm(Request $request){
        $order = Order::with('items')->with('staff')->with('vendor')->with('user')->has('items')->has('staff')->has('vendor')->has('user')->where('id',$request->order_id)->first();
    	if($order){
    	    $order->status = 6;
    	    if($order->save()){
    	        $result = $this->ordersuccessfull($order->cart_id,$order->user_id);
    	        $order->delivery_date = $order->service_date;
    	        $order->time_slot = $order->service_time;
    	        $result1 = $this->orderconfirmedinapp($order->cart_id,$order->user->user_phone,$order);
    	        $data_sms['ordersuccessfull'] = $result;
    	        //$data_sms['ordersuccessfullstore'] = $result1;
    	    }
    		$message = array('status'=>'1', 'message'=>'Updated Successfully', 'data'=>$order);
//    		$message = array('status'=>'1', 'message'=>'Updated Successfully', 'data'=>$order,$data_sms);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Order list');
	        return $message;
    	}
    }
    
    public function home_page(Request $request){
        $day1 = Carbon::now()->today();
        $day2 = Carbon::now()->subDays(1);
        $day3 = Carbon::now()->subDays(2);
        $day4 = Carbon::now()->subDays(3);
        $day5 = Carbon::now()->subDays(4);
        $day6 = Carbon::now()->subDays(5);
        $day7 = Carbon::now()->subDays(6);

        $all_orders = Order::with('user')->has('user')->where('vendor_id',$request->vendor_id)->whereNotIn('status',[4])->get();

            $data['all_orders_count'] = $all_orders->count();
            $data['pending_orders'] = Order::with('user')->has('user')->where('vendor_id',$request->vendor_id)->whereIn('status',['0','1','6'])->count();
            $data['read'] = 0;
            $data['read_notification_count'] = DB::table('vendor_notification')->where(['vendor_id'=>$request->vendor_id,'read_by_vendor'=>1])->count();
            $data['unread_notification_count'] = DB::table('vendor_notification')->where(['vendor_id'=>$request->vendor_id,'read_by_vendor'=>0])->count();
            $data['complted_order_count'] = Order::with('user')->has('user')->where('vendor_id',$request->vendor_id)->where('status',2)->count();
            $data['vendor_details'] = DB::table('vendor')->where('vendor_id',$request->vendor_id)->first();


            $data['day1_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day1)))->where('status',2)->sum('total_price');
            $data['day1_details']['date'] = date('Y-m-d',strtotime($day1));
            $data['day1_details']['day'] = date('D',strtotime($day1));

            $data['day2_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day2)))->where('status',2)->sum('total_price');
            $data['day2_details']['date'] = date('Y-m-d',strtotime($day2));
            $data['day2_details']['day'] = date('D',strtotime($day2));

            $data['day3_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day3)))->where('status',2)->sum('total_price');
            $data['day3_details']['date'] = date('Y-m-d',strtotime($day3));
            $data['day3_details']['day'] = date('D',strtotime($day3));

            $data['day4_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day4)))->where('status',2)->sum('total_price');
            $data['day4_details']['date'] = date('Y-m-d',strtotime($day4));
            $data['day4_details']['day'] = date('D',strtotime($day4));

            $data['day5_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day5)))->where('status',2)->sum('total_price');
            $data['day5_details']['date'] = date('Y-m-d',strtotime($day5));
            $data['day5_details']['day'] = date('D',strtotime($day5));

            $data['day6_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day6)))->where('status',2)->sum('total_price');
            $data['day6_details']['date'] = date('Y-m-d',strtotime($day6));
            $data['day6_details']['day'] = date('D',strtotime($day6));

            $data['day7_details']['earning'] = Order::where('vendor_id',$request->vendor_id)->whereDate('created_at', date('Y-m-d',strtotime($day7)))->where('status',2)->sum('total_price');
            $data['day7_details']['date'] = date('Y-m-d',strtotime($day7));
            $data['day7_details']['day'] = date('D',strtotime($day7));

    		$message = array('status'=>'1', 'message'=>'Order list', 'data'=>$data);
	        return $message;

    }


    public function vendor_earnings(Request $request){
        $vendor_id = $request->vendor_id;
        $vendor = DB::table('vendor')->where('vendor_id',$vendor_id)->first();
        if($vendor){
            $admin_share = $vendor->admin_share;
            $data['admin_share'] = $vendor->admin_share;
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
    
    		$message = array('status'=>'1', 'message'=>'Earning Details', 'data'=>$data);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Some Error Occurred.');
	        return $message;
    	}
    }
    
    
    public function paid_to_admin(Request $request){
        $vendor_id = $request->vendor_id;
        $vendor = DB::table('vendor')->where('vendor_id',$vendor_id)->first();
        if($vendor){
            Order::where(['vendor_id'=>$vendor_id,'status'=>2,'share_send_status'=>0,'payment_method'=>'COD'])->update(['share_send_status'=>1]);

    		$message = array('status'=>'1', 'message'=>'Request sent Successfully.');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Some Error Occurred.');
	        return $message;
    	}
    }

    
}
