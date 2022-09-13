<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;
use App\Faqs;
use App\Vendor;
use App\PrivacyPolicy;

class SettingController extends Controller
{

    public function currency(Request $request)
    {
		$currency = DB::table('currency')->first();
    	if($currency){
    		$message = array('status'=>'1', 'message'=>'Currency list', 'data'=>$currency);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Faq list');
	        return $message;
    	}
     }

    public function faqs(Request $request)
    {
		$faqs = Faqs::get();
    	if(count($faqs)>0){
    		$message = array('status'=>'1', 'message'=>'Faq list', 'data'=>$faqs);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Faq list');
	        return $message;
    	}
     }

    public function privacy_policy(Request $request)
    {
		$faqs = PrivacyPolicy::first();
    	if($faqs){
    		$message = array('status'=>'1', 'message'=>'Privacy Policy', 'data'=>$faqs);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Privacy Policy');
	        return $message;
    	}
     }

    public function shop_setting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'online_status' => 'required|in:ON,OFF',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }

		$vendor = Vendor::where('vendor_id',$request->vendor_id)->first();
    	if($vendor){
    	    $vendor->online_status = $request->online_status;
    	    $vendor->save();
//    		$message = array('status'=>'1', 'message'=>'Vendor', 'data'=>$vendor);
    		$message = array('status'=>'1', 'message'=>'Update Successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Some Error Occurred');
	        return $message;
    	}
     }


}
