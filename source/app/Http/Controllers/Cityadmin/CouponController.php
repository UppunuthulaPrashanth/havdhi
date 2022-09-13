<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class CouponController extends Controller
{
    public function couponlist(Request $request)
    {

        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();

         $coupon= DB::table('coupon')
                ->paginate(10);
        $lang=DB::table('langs')
             ->get();
        return view('cityadmin.coupon.couponlist',compact("cityadmin","coupon","cityadmin_email","lang"));
    }

    public function addcoupon(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $vendors= DB::table('vendor')
        ->where('cityadmin_id',$cityadmin->cityadmin_id)
        ->get();
           $lang=DB::table('langs')
             ->get();
        return view('cityadmin.coupon.couponadd',compact("cityadmin","vendors","cityadmin_email","lang"));
    }

    public function addnewcoupon(Request $request)
    {
        if(Session::has('cityadmin'))
        {
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')
            ->where('cityadmin_email',$cityadmin_email)
            ->first();

            $vendor_id=$request->vendor_id;
        $coupon_name = $request->coupon_name;
        $coupon_code = $request->coupon_code;
        $coupon_desc = $request->coupon_desc;
        $valid_to = $request->valid_to;
        $valid_from = $request->valid_from;
        $cart_value = $request->cart_value;
        $coupon_type = $request->coupon_type;
        $coupon_discount =$request->coupon_discount;
        $restriction = $request->restriction;

        $this->validate(
            $request,
                [

                    'coupon_name'=>'required',
                    'coupon_code'=>'required',
                    'coupon_desc'=>'required',
                    'valid_to'=>'required',
                    'valid_from'=>'required',
                    'cart_value'=>'required',
                    'restriction'=>'required'
                ],
                [

                    'coupon_name.required'=>'Coupon Name Required',
                    'coupon_code.required'=>'Coupon Code Required',
                    'coupon_desc.required'=>'Coupon Description Required',
                    'valid_to.required'=>'Date Required',
                    'valid_from.required'=>'Date Required',
                    'cart_value.required'=>'Cart value Required',
                    'restriction.required'=>'Enter Uses Restiction limit'

                ]
        );


        $insert = DB::table('coupon')
                  ->insertGetId([
                       'coupon_name'=>$coupon_name,
                       'coupon_description'=>$coupon_desc,
                       'coupon_code'=>$coupon_code,
                       'start_date'=>$valid_to,
                       'end_date'=>$valid_from,
                       'type'=>$coupon_type,
                       'uses_restriction'=>$restriction,
                       'amount'=>$coupon_discount,
                       'cart_value'=>$cart_value]);

                       $total_vendor=count($vendor_id);
                       for($i=0;$i<=($total_vendor-1);$i++)
                           {
                               $insert2 = DB::table('coupon_vendor')
                                     ->insert(['coupon_id'=>$insert, 'vendor_id'=>$vendor_id[$i]]);
                           }
                           
	   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_coupon_name';
                $t_product_name=$request->$tec;
                if($t_product_name ==NULL){
                    $t_product_name=$coupon_name;
                }
                 $tec2 = $langs->lang_prefix.'_coupon_description';
                $t_des=$request->$tec2;
                 if($t_des ==NULL){
                    $t_des=$coupon_desc;
                }
                   $update2 = DB::table('coupon')
                 ->where('coupon_id', $insert)
                  ->update([$langs->lang_prefix.'_coupon_name'=>$t_product_name,$langs->lang_prefix.'_coupon_description'=>$t_des]);
                   }
            return redirect()->back()->withErrors('Added Successfully');
        }
       else
          {
            return redirect()->route('cityadminlogin')->withErrors('please login first');
          }

    }


    public function editcoupon(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
         $coupon_id=$request->coupon_id;
    	 $coupon= DB::table('coupon')
    	 		  ->where('coupon_id',$coupon_id)
                   ->first();
                   $vendors= DB::table('vendor')
                   ->where('cityadmin_id',$cityadmin->cityadmin_id)
                  ->get();
                  $coupon_vendor = DB::table('coupon_vendor')
                  ->join('vendor','coupon_vendor.vendor_id','=', 'vendor.vendor_id' )
                  ->where('coupon_id',$coupon_id)
                  ->get();
                  $lang=DB::table('langs')
             ->get();
    	 return view('cityadmin.coupon.couponedit',compact("cityadmin","coupon","vendors","coupon_vendor","cityadmin_email","lang"));


    }
    public function updatecoupon(Request $request)
    {
        if(Session::has('cityadmin'))
     {
        $vendor_id=$request->vendor_id;
        $coupon_id = $request->coupon_id;
        $coupon_name = $request->coupon_name;
        $coupon_code = $request->coupon_code;
        $coupon_type = $request->coupon_type;
        $coupon_desc = $request->coupon_desc;
        $valid_to = $request->valid_to;
        $valid_from = $request->valid_from;
        $cart_value = $request->cart_value;
        $restriction = $request->restriction;


      $this->validate(
            $request,
                [

                    'coupon_name'=>'required',
                    'coupon_code'=>'required',
                    'coupon_desc'=>'required',
                    'valid_to'=>'required',
                    'valid_from'=>'required',
                    'cart_value'=>'required',
                    'restriction'=>'required'
                ],
                [

                    'coupon_name.required'=>'Coupon Name Required',
                    'coupon_code.required'=>'Coupon Code Required',
                    'coupon_desc.required'=>'Coupon Description Required',
                    'valid_to.required'=>'Date Required',
                    'valid_from.required'=>'Date Required',
                    'cart_value.required'=>'Cart value Required',
                    'restriction.required'=>'Enter Uses Restiction limit'

                ]
        );

        $delete = DB::table('coupon_vendor')
        ->where('coupon_id', $coupon_id)
        ->delete();
        $total_vendor=count($vendor_id);
        for($i=0;$i<=($total_vendor-1);$i++)
        {
        DB::table('coupon_vendor')
                  ->insert(['coupon_id'=>$coupon_id, 'vendor_id'=>$vendor_id[$i]]);
        }
        $update = DB::table('coupon')
                 ->where('coupon_id', $coupon_id)
                 ->update([
                      'coupon_name'=>$coupon_name,
                       'coupon_description'=>$coupon_desc,
                       'coupon_code'=>$coupon_code,
                       'start_date'=>$valid_to,
                       'type'=>$coupon_type,
                       'end_date'=>$valid_from,
                       'cart_value'=>$cart_value,
                       'uses_restriction'=>$restriction]);


			   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_coupon_name';
                $t_product_name=$request->$tec;
                 $tec2 = $langs->lang_prefix.'_coupon_description';
                $t_des=$request->$tec2;
                   $update2 = DB::table('coupon')
                 ->where('coupon_id', $coupon_id)
                  ->update([$langs->lang_prefix.'_coupon_name'=>$t_product_name,$langs->lang_prefix.'_coupon_description'=>$t_des]);
                   }

        if($update || $update2){



            return redirect()->back()->withErrors(' Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
     }
     else
      {
        return redirect()->route('vendorlogin')->withErrors('please login first');
      }
    }
  public function deletecoupon(Request $request)
    {

        $coupon_id=$request->coupon_id;

        DB::table('coupon')
                ->where('coupon_id',$coupon_id)
                ->first();


    	$delete=DB::table('coupon')->where('coupon_id',$request->coupon_id)->delete();
        if($delete)
        {
         return redirect()->back()->withSuccess('Deleted Successfully');
            }

        else
        {
           return redirect()->back()->withErrors('Unsuccessfull Delete');
        }

    }


}


