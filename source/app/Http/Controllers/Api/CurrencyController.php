<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Setting;
use Carbon\Carbon;

class CurrencyController extends Controller
{
   public function currency(Request $request)
    {  
        $currency = DB::table('currency')
                ->first();
        
         if($currency){
            $message = array('status'=>'1', 'message'=>'currency', 'data'=>$currency);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No currency Found');
            return $message;
        }
    }
    public function gatewaysettings(Request $request)
    {  
        $currency = Setting::get();
        $razorpay_status =Setting::where('name', 'razorpay_active')->select('value')->first(); 
        $paystack_status =Setting::where('name', 'paystack_active')->select('value')->first(); 
        $stripe_status =Setting::where('name', 'stripe_active')->select('value')->first(); 
        $razorpay_secret =Setting::where('name', 'razorpay_secret_key')->select('value')->first(); 
        $razorpay_key =Setting::where('name', 'razorpay_key_id')->select('value')->first(); 
        $stripe_secret =Setting::where('name', 'stripe_secret_key')->select('value')->first(); 
        $stripe_publishable_key =Setting::where('name', 'stripe_publishable_key')->select('value')->first(); 
        $stripe_merchant_key =Setting::where('name', 'stripe_merchant_id')->select('value')->first(); 
        $paystack_public_key =Setting::where('name', 'paystack_public_key')->select('value')->first(); 
        $paystack_secret_key =Setting::where('name', 'paystack_secret_key')->select('value')->first(); 
        
        
        $stripe = array("stripe_status" => $stripe_status->value,
        "stripe_secret"=>$stripe_secret->value,
        "stripe_publishable"=>$stripe_publishable_key->value,
        "stripe_merchant_id"=>$stripe_merchant_key->value
            );
            
        $paystack  = array("paystack_status"=>$paystack_status->value,
        "paystack_public_key" =>$paystack_public_key->value,
        "paystack_secret_key" => $paystack_secret_key->value);
        
        $razorpay = array("razorpay_status"=>$razorpay_status->value,
        "razorpay_secret"=>$razorpay_secret->value,
        "razorpay_key"=>$razorpay_key->value);
        
        $data= array('razorpay'=>$razorpay, 'stripe'=>$stripe, "paystack"=>$paystack);
        
         if($currency){
            $message = array('status'=>'1', 'message'=>'Payment Gateways and Values', 'data'=>$data);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No Payment Gateway Found');
            return $message;
        }
    }
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
}