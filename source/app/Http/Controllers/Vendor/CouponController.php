<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class CouponController extends Controller
{
    public function allcoupons(Request $request)
    {
        
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
                
         $coupon= DB::table('coupon')
         ->join('coupon_vendor','coupon.coupon_id','=', 'coupon_vendor.coupon_id' )     
         ->where('coupon_vendor.vendor_id',$vendor->vendor_id)
                ->paginate(10);
        $lang=DB::table('langs')
             ->get();
        return view('vendor.coupon.couponlist',compact("vendor","coupon","vendor_email","lang"));
    }
       

}


