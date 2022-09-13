<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    public function vendorIndex(Request $request)
        {
        $created_at = Carbon::Now();    
     if(Session::has('vendor'))
     {
    	 $vendor_email=Session::get('vendor');

    	  $vendor=DB::table('vendor')
    			->where('vendor_email',$vendor_email)
    			->first();
    			
    	$current = Carbon::now();
        $current->toDateString();
        $currentDate = date('Y-m-d');
        $day = 1;
        $current2 = date('d-m-Y', strtotime($current.' + '.$day.' days'));
    			
    	 $total_earnings = DB::table('orders')
    	                    ->where('vendor_id',$vendor->vendor_id)
    	                    ->where('order_status','=','Confirmed')
    	                    ->count(); 
    	   $orders = DB::table('orders')
    	                    ->where('order_status','=','Completed')
    	                    ->where('vendor_id',$vendor->vendor_id)
    	                    ->count();  
    
    	   $total_cash = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                     ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','=',2)
    	                    ->sum('total_price'); 
    	   $pen_cash = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                    ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','=',1)
    	                    ->sum('total_price');                 
    	   $all_cash = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                    ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','!=',3)
    	                    ->where('status','!=',4)
    	                    ->where('status','!=',5)
    	                    ->sum('total_price');                   
    	      $total_book = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                    ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','!=',3)
    	                    ->where('status','!=',4)
    	                    ->where('status','!=',5)
    	                    ->count();
    	       $pen_book = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                    ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','=',1)
    	                    ->count();                 
    	    $comp_book = DB::table('orders')
    	                    ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
    	                    ->where('orders.vendor_id',$vendor->vendor_id)
    	                    ->where('status','=',2)
    	                    ->count();                  
    	 $total_users = DB::table('users')
    	                    ->count(); 
    	                    
    	                    
    	  $ongoing =   DB::table('product_order')
    	                    ->count();      
    	   $vendorw =     DB::table('product_order_details')
    	          ->where('vendor_id',$vendor->vendor_id)
    	          ->where('status',"2")
    	           ->count(); 
    	   $cityadmin1 =   0; 
    	   $user =   DB::table('product_order_details')
    	          ->where('vendor_id',$vendor->vendor_id)
    	          ->where('status',"1")
    	           ->count(); 
    	  
    	
    	   $currency =   DB::table('currency')
    	                    ->first(); 
    	            
    	                    
        return view('vendor.index', compact("vendor_email", "vendorw", "total_earnings", "total_users", "ongoing","vendor","cityadmin1","orders","user","total_cash","currency","all_cash","pen_cash","total_book","comp_book","pen_book"));       
    	                    
      
         
           
     }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors('please login first');
	 }
      }


  }