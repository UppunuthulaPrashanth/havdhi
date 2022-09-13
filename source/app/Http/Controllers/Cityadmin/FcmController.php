<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;

class FcmController extends Controller
{    
      public function edit_fcm_api(Request $request)
    {
     if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
    	   
    			
    	   $api_key=  DB::table('fcm_key')
    	              ->select('*')
                      ->first();
              $user_api_key = $api_key->user_app_key;
              $vendor_app_key = $api_key->vendor_app_key;
              
            	return view('admin.fcm_api', compact("cityadmin_email", "cityadmin", "user_api_key"));
            	
    			
    	
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
    
    
      
     public function update_fcm_api(Request $request)
    {
    if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
          $user_key = $request->user_key;
          $vendor_key= $request->vendor_key;
          
        $update= DB::table('fcm_key')
     		     ->update(['user_app_key'=>$user_key,
     		                 'vendor_app_key'=>$vendor_key]);
	
     if($update){
            return redirect()->back()->withErrors('API key set');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
          public function edit_countrycode(Request $request)
    {
      if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
    			
    	   $api_key=  DB::table('country_code')
    	              ->select('*')
                      ->first();
              $country_code = $api_key->country_code;
              $number_limit = $api_key->number_limit;
              
            	return view('admin.fcm_api', compact("cityadmin_email", "cityadmin","country_code","number_limit"));
            	
    			
    	
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
    
    
      
     public function update_countrycode(Request $request)
    {
     if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
          $country_code = $request->country_code;
          $number_limit= $request->number_limit;
          
        $update= DB::table('country_code')
     		     ->update(['country_code'=>$country_code]);
	
     if($update){
            return redirect()->back()->withErrors('Updated Sucessfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
            public function edit_firebase(Request $request)
    {
     if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
    	   
    			
    	   $api_key=  DB::table('firebase')
    	              ->select('*')
                      ->first();
              
            	return view('admin.fcm_api', compact("cityadmin_email", "cityadmin"));
            	
    			
    	
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
    
    
      
     public function update_firebase(Request $request)
    {
      if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
          $country_code = $request->coupon_type;
          
        $update= DB::table('firebase')
     		     ->update(['status'=>$country_code,
     		                 ]);
	
     if($update){
            return redirect()->back()->withErrors('Updated Sucessfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
}