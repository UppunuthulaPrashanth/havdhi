<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use App\Traits\SendMail;
use App\Coupon;
use App\CouponVendor;
use GoogleTranslate;

class CouponController extends Controller
{
	use SendMail;
	
	 public function langlist(Request $request)
    {  
        $lang = DB::table('langs')
                ->get();
        
         if($lang){
            $message = array('status'=>'1', 'message'=>'Lang list', 'data'=>$lang);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No language Found');
            return $message;
        }
    }

    public function list(Request $request)
    {
        $lang=$request->lang;
        if($lang != NULL){
		$coupon = Coupon::join('coupon_vendor','coupon_vendor.coupon_id','coupon.coupon_id') ->select('coupon.coupon_id','coupon.'.$lang.'_coupon_name','coupon.coupon_code','coupon.'.$lang.'_coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by')->where('vendor_id', $request->vendor_id)->get();
        }else{
            $coupon = Coupon::join('coupon_vendor','coupon_vendor.coupon_id','coupon.coupon_id')->select('coupon.coupon_id','coupon.coupon_name','coupon.coupon_code','coupon.coupon_description','coupon.start_date','coupon.end_date','coupon.cart_value','coupon.amount','coupon.type','coupon.uses_restriction','coupon.added_by')->where('vendor_id', $request->vendor_id)->get();
        }
        
        //GoogleTranslate::detectLanguage(['Hello world', 'Laravel is the best']);
    	if(count($coupon)>0){
    		$message = array('status'=>'1', 'message'=>'Coupon list', 'data'=>$coupon);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Coupon list');
	        return $message;
    	}
     }
    
	public function add(Request $request)
    {
        
        $coupon = new Coupon;
        $coupon->coupon_name = $request->coupon_name;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_description = $request->coupon_description;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->cart_value = $request->cart_value;
        $coupon->amount = $request->amount;
        $coupon->type = $request->type;
        $coupon->uses_restriction = $request->uses_restriction;
        $coupon->added_by = 1;
      if($coupon->save()){
        $vcoupon = new CouponVendor;
        $vcoupon->vendor_id = $request->vendor_id;
        $vcoupon->coupon_id = $coupon->coupon_id;
        $vcoupon->save();
       
         $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_coupon_name';
                $t_product_name=$request->$tec;
                if($t_product_name ==NULL){
                    $t_product_name=$request->coupon_name;
                }
                 $tec2 = $langs->lang_prefix.'_coupon_description';
                $t_des=$request->$tec2;
                 if($t_des ==NULL){
                    $t_des=$request->coupon_description;
                }
                   $update2 = DB::table('coupon')
                 ->where('coupon_id', $coupon->coupon_id)
                  ->update([$langs->lang_prefix.'_coupon_name'=>$t_product_name,$langs->lang_prefix.'_coupon_description'=>$t_des]);
                   }
                   
           $coupon= DB::table('coupon')
                ->where('coupon_id',$coupon->coupon_id)
                ->first();

        $message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$coupon);
                return $message;	
        }
        else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    
    }


	public function delete(Request $request)
    {
        $coupon = Coupon::where('coupon_id', $request->coupon_id)->first();
        if($coupon){
            $coupon->vcoupon()->delete();
            $coupon->delete();
            $message = array('status'=>'1', 'message'=>'Deleted successfully');
            return $message;	
        } else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    }   




}
