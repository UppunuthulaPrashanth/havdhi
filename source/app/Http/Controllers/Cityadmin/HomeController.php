<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use Carbon\Carbon;

class HomeController extends Controller
{

	private $orders_vendor_id = 'orders.vendor_id';
	private $vendor_vendor_id = 'vendor.vendor_id';
	private $vendor_cityadmin_id = 'vendor.cityadmin_id';
	private $cityadmin_cityadmin_id = 'cityadmin.cityadmin_id';

	public function cityadminIndex(Request $request)
    {
        $created_at = Carbon::Now();
    if(Session::has('cityadmin'))
     {
        $cityadmin_email=Session::get('cityadmin');
        
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;
        
        
        	$currentDate = date('Y-m-d');
				$day = 1;
       $current2 = date('d-m-Y', strtotime($currentDate.' + '.$day.' days'));
        
         $total_earnings = DB::table('orders')
                             ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('orders.status','=',6)
    	                    ->count(); 
    	   $orders = DB::table('orders')
    	                     ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('orders.status','=',2)
    	                    ->count();  
    	   $total_cash = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','=',2)
    	                    ->sum('total_price'); 
    	   $pen_cash = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','=',1)
    	                    ->sum('total_price');                 
    	   $all_cash = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','!=',3)
    	                    ->where('status','!=',4)
    	                    ->where('status','!=',5)
    	                    ->sum('total_price');                   
    	      $total_book = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','!=',3)
    	                    ->where('status','!=',4)
    	                    ->where('status','!=',5)
    	                    ->count();
    	       $pen_book = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','=',1)
    	                    ->count();                 
    	    $comp_book = DB::table('orders')
    	                    ->join('vendor',$this->orders_vendor_id,'=',$this->vendor_vendor_id)
    	                    ->where('status','=',2)
    	                    ->count();                  
    	 $total_users = DB::table('users')
    	                    ->count(); 
    	                    
    	                    
    	  $ongoing =   DB::table('product_order')
    	                    ->count();      
    	   $vendor =   DB::table('vendor')
    	                    ->count(); 
    	   $cityadmin1 =   0; 
    	   $user =   DB::table('users')
    	                    ->count(); 
    	  
    	
    	   $currency =   DB::table('currency')
    	                    ->first(); 
    	            
    	                    
        return view('cityadmin.index', compact("cityadmin_email", "cityadmin", "total_earnings", "total_users", "ongoing","vendor","cityadmin1","orders","user","total_cash","currency","all_cash","pen_cash","total_book","comp_book","pen_book"));
	 }
	else
	 {
	    return redirect()->route('cityadminlogin')->withErrors('please login first');
	 }
    }
    
}
