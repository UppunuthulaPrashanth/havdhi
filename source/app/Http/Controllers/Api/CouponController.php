<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CouponController extends Controller
{
   public function apply_coupon(Request $request)
    {
        $cart_id = $request->cart_id;
        $check = DB::table('orders')
               ->where('cart_id',$cart_id)
               ->first();
        $p=$check->total_price;
        $user_id= $check->user_id;
        $type=$request->type;
        if($type=="coupon"){
        $coupon_code = $request->coupon_code;
                       
        $coupon = DB::table('coupon')
                ->where('coupon_code', $coupon_code)
                ->first();
                
        if($coupon){        
        
              
         $orderchecked =DB::table('orders')
              ->where('cart_id',$cart_id)
              ->where('coupon_id',$coupon->coupon_id)
              ->first();     
              
        if(!$orderchecked){     
         $check2 = DB::table('orders')
               ->where('coupon_id',$coupon->coupon_id)
               ->where('user_id',$check->user_id)
               ->count();
       
        if($coupon->uses_restriction > $check2){
      
        $mincart = $coupon->cart_value;
        $am = $coupon->amount;
        $type = $coupon->type;
        if($type=='%'||$type=='Percentage'||$type=='percentage'){
          $per = ($p*$am)/100;  
          $rem_price = $p-$per;
        }
        else{
            $per = $am;
            $rem_price = $p-$am; 
        }
        $update=DB::table('orders')
              ->where('cart_id',$cart_id)
              ->update(['rem_price'=>$rem_price,
              'coupon_discount'=>$per,
              'coupon_id'=>$coupon->coupon_id]);
              
        $order =DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();
     if($order){   
        if($update){
            $message = array('status'=>'1', 'message'=>'Coupon Applied Successfully', 'data'=>$order);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Cannot Applied');
            return $message;
        }
     }else{
         $message = array('status'=>'0', 'message'=>'Cart not found');
         return $message;
     }
    }
    else{
         $message = array('status'=>'0', 'message'=>'Invalid Coupon! Maximum use limit reached');
         return $message;
    }
        }
        else{
            $update=DB::table('orders')
              ->where('cart_id',$cart_id)
              ->update(['rem_price'=>$p,
              'coupon_discount'=>0,
              'coupon_id'=>0]);
             $order =DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();  
              
         if($update){
            $message = array('status'=>'2', 'message'=>'Coupon Unapplied', 'data'=>$order);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Something went wrong');
            return $message;
        }      
        }
    
    }else{
        $message = array('status'=>'3', 'message'=>'Coupon not found');
            return $message;
    }
     }
    else{
        $rewards = DB::table('users')
                ->select('rewards')
                ->where('id',$user_id)
                ->first();
        $rew = $rewards->rewards;
        $redeem_points = DB::table('reedem_values')
               ->select('value','reward_point')
               ->first();
        $new = $rew * $redeem_points->value/$redeem_points->reward_point; 
        if($new <= $p){
            $rewuse = $rew;
            $rewdis =$new; 
            $rem_price = $p-$rewdis; 
            $reww = $rew-$rewuse;

        }else{
            $rewdis = $p;
            $rewuse = $p*$redeem_points->reward_point;
            $rem_price = 0;
            $reww = $rew-$rewuse;
        }
        
        
          $update=DB::table('orders')
              ->where('cart_id',$cart_id)
              ->update(['rem_price'=>$rem_price,
              'reward_discount'=>$rewdis,
              'reward_use'=>$rewuse]);
              
        $order =DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();
        if($update){
            $update_rew = DB::table('users')
                ->where('id',$user_id)
                ->update(['rewards'=>$reww]);
            $message = array('status'=>'1', 'message'=>'Rewards Applied Successfully', 'data'=>$order);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Cannot Applied');
            return $message;
        }
        
        
    }
    }
    
    public function coupon_list(Request $request)
    {
        $currentdate = Carbon::now();
        $cart_id = $request->cart_id; 
       $lang=$request->lang;
        $check = DB::table('orders')
               ->where('cart_id',$cart_id)
               ->first();
        if($check){        
        $p=$check->total_price;
        if($lang != NULL){
        $coupon = DB::table('coupon')
                ->join('coupon_vendor','coupon.coupon_id','=','coupon_vendor.coupon_id')
                  ->select('coupon.coupon_id','coupon.'.$lang.'_coupon_name as coupon_name','coupon.coupon_code','coupon.'.$lang.'_coupon_description as coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by')
                ->where('coupon_vendor.vendor_id',$check->vendor_id)
                ->where('coupon.cart_value','<=', $p)
                ->where('coupon.start_date','<=',$currentdate)
                ->where('coupon.end_date','>=',$currentdate)
                ->get();
        }else{
            $coupon = DB::table('coupon')
                ->join('coupon_vendor','coupon.coupon_id','=','coupon_vendor.coupon_id')
                   ->select('coupon.coupon_id','coupon.coupon_name','coupon.coupon_code','coupon.coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by')
                ->where('coupon_vendor.vendor_id',$check->vendor_id)
                ->where('coupon.cart_value','<=', $p)
                ->where('coupon.start_date','<=',$currentdate)
                ->where('coupon.end_date','>=',$currentdate)
                ->get(); 
        }
        }else{
             $message = array('status'=>'0', 'message'=>'Cart not Found');
            return $message;
        }
         if(count($coupon)>0){
            $message = array('status'=>'1', 'message'=>'Coupon List', 'data'=>$coupon);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Coupon not Found');
            return $message;
        }
    
    }
    
    
    
    public function getnearcouponlist(Request $request)
    {
        $currentdate = Carbon::now();
        $lang = $request->lang;
        $lat = $request->lat;
       $lng = $request->lng;
       $nearbystore = DB::table('vendor')
                    ->select('vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','opening_time','closing_time','delivery_range','shop_type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                  ->paginate(5);
      $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store->vendor_id; 
            }
            
        }
        if($pr != NULL){ 
          if($lang != NULL){
            $coupon =  DB::table('coupon')
                 ->join('coupon_vendor','coupon.coupon_id','=','coupon_vendor.coupon_id')
                  ->join('vendor','coupon_vendor.vendor_id','=','vendor.vendor_id')
                  ->select('coupon.coupon_id','coupon.'.$lang.'_coupon_name as coupon_name','coupon.coupon_code','coupon.'.$lang.'_coupon_description as coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by','vendor.*')
                ->where('coupon_vendor.vendor_id',$pr)
                ->where('coupon.start_date','<=',$currentdate)
                ->where('coupon.end_date','>=',$currentdate)
                ->get();
          }else{
               $coupon =  DB::table('coupon')
                 ->join('coupon_vendor','coupon.coupon_id','=','coupon_vendor.coupon_id')
                  ->join('vendor','coupon_vendor.vendor_id','=','vendor.vendor_id')
                   ->select('coupon.coupon_id','coupon.coupon_name','coupon.coupon_code','coupon.coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by','vendor.*')
                ->where('coupon_vendor.vendor_id',$pr)
                ->where('coupon.start_date','<=',$currentdate)
                ->where('coupon.end_date','>=',$currentdate)
                ->get();
          }
            $message = array('status'=>'1', 'message'=>'Coupon List', 'data'=>$coupon);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
                  
    }
    
}