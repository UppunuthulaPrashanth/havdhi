<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;

class PagesController extends Controller
{
   use SendMail; 

   public function terms(Request $request)
    {   
        $lang = $request->lang;
        if($lang != NULL){
        $terms= DB::table('termcondition')
               ->select('id',$lang.'_termcondition as termcondition')
               ->first();
        }else{
            $terms= DB::table('termcondition')
            ->select('id','termcondition')
               ->first();
        }
        if($terms){

        	$message = array('status'=>'1', 'message'=>'terms and conditions', 'data'=>$terms);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'No terms found');
        	return $message;
        }
        
   
 }
 
   public function cookies(Request $request)
    {   
        $lang = $request->lang;
        if($lang != NULL){
        $cookies= DB::table('cookies_policy')
                ->select('id',$lang.'_cookies_policy as cookies_policy')
               ->first();
        }else{
            $cookies= DB::table('cookies_policy')
                ->select('id','cookies_policy')
               ->first();  
        }
        if($cookies){

        	$message = array('status'=>'1', 'message'=>'cookies policy', 'data'=>$cookies);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'cookies policy not found');
        	return $message;
        }
        
   
 }
 
     public function privacy(Request $request)
    {   
         $lang = $request->lang;
        if($lang != NULL){
        $privacy= DB::table('privacy_policy')
                ->select('id',$lang.'_privacy_policy as privacy_policy')
               ->first();
        }else{
            $privacy= DB::table('privacy_policy')
                ->select('id','privacy_policy')
               ->first();  
        }
        if($privacy){

        	$message = array('status'=>'1', 'message'=>'Privacy policy', 'data'=>$privacy);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Privacy policy not found');
        	return $message;
        }
        
   
 }
 
 
 
 
  
 
}