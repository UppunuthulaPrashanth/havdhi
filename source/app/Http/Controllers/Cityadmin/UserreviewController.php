<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;

class UserreviewController extends Controller
{

    private $review_user_id = 'review.user_id';
    private $tbl_user_user_id = 'users.id';
    private $review_vendor_id = 'review.vendor_id';
    private $vendor_vendor_id = 'vendor.vendor_id';
    private $review_active = 'review.active';
    private $cityadmin_userreview_alluserreview = 'cityadmin.userreview.alluserreview';

    public function allusersreview(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;		

        $alluser = DB::table('review')
        ->join('users',$this->review_user_id, '=', $this->tbl_user_user_id)
        ->join('vendor',$this->review_vendor_id, '=', $this->vendor_vendor_id)
        ->where($this->review_active,0)
        ->select('users.*','vendor.*','review.*')
        ->paginate(10);
        return view($this->cityadmin_userreview_alluserreview,compact("cityadmin_email","alluser","cityadmin"));
    }
    public function allusersreview_confirm(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;		

        $alluser = DB::table('review')
        ->join('users',$this->review_user_id, '=', $this->tbl_user_user_id)
        ->join('vendor',$this->review_vendor_id, '=', $this->vendor_vendor_id)
        ->where($this->review_active,1)
        ->select('users.*','vendor.*','review.*')
        ->paginate(10);
        return view($this->cityadmin_userreview_alluserreview,compact("cityadmin_email","alluser","cityadmin"));
    }
    public function allusersreview_reject(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;		

        $alluser = DB::table('review')
        ->join('users',$this->review_user_id, '=', $this->tbl_user_user_id)
        ->join('vendor',$this->review_vendor_id, '=', $this->vendor_vendor_id)
        ->where($this->review_active,2)
        ->select('users.*','vendor.*','review.*')
        ->paginate(10);
        return view($this->cityadmin_userreview_alluserreview,compact("cityadmin_email","alluser","cityadmin"));
    }

    public function edituserreview(Request $request)
    {
       $id=$request->id;
    	 $cityadmin_email=Session::get('cityadmin');
    	 $city=DB::table('city')
                ->get();
         $cityadmin=DB::table('cityadmin')
                ->where('cityadmin_email',$cityadmin_email)
                ->first();       
    	 $user= DB::table('review')
                ->where('id',$id)
                ->first(); 
    	 return view('cityadmin.userreview.edituserreview',compact("cityadmin_email","cityadmin","city","user"));


    }
    public function Updateuser(Request $request)
{
        $id=$request->id;
        $active=$request->active;
        $description=$request->description;
   
        $update = DB::table('review')
                 ->where('id', $id)
                 ->update(['description'=>$description,'active'=>$active]);

        if($update){
            return redirect('cityadmin/allusersreview')->withErrors('updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    
   

}	
    
}
