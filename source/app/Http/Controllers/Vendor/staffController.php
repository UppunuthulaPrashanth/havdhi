<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class staffController extends Controller
{

     public $login_check_message = 'please login first';

     public function staff(Request $request)
         {
     if(Session::has('vendor'))
     {   
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $staff= DB::table('staff_profile')
        ->where('vendor_id',$vendor->vendor_id)
        ->paginate(10);
        $lang=DB::table('langs')
             ->get();
        return view('vendor.staff.staff',compact("vendor_email","staff","vendor","lang"));
        
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function Addstaff(Request $request)
         {
     if(Session::has('vendor'))
     {
       
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
  $lang=DB::table('langs')
           ->get();
         return view('vendor.staff.addstaff',compact("vendor_email","vendor","lang"));
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function AddNewstaff(Request $request)
         {
                  $this->validate($request,[
               'staff_name' => 'required',
               'staff_description' => 'required',
               'staff_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

           ]);
      if(Session::has('vendor'))
     {
      
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $vendor_id = $vendor->vendor_id;
        $staff_name=$request->staff_name;
        $staff_description=$request->staff_description;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
        $staff_image = $request->staff_image;
        $fileName = date('dmyhisa').'-'.$staff_image->getClientOriginalName();
        $fileName = str_replace(" ", "-", $fileName);
        $staff_image->move('staff/images/'.$date.'/', $fileName);
        $staff_image = 'staff/images/'.$date.'/'.$fileName;


        $insert = DB::table('staff_profile')
                  ->insertGetId(['vendor_id'=>$vendor_id,'staff_name'=>$staff_name,'staff_description'=>$staff_description,'staff_image'=>$staff_image,'created_at'=>$created_at]);
        
        
   
    $lang=DB::table('langs')
                 ->get();
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_staff_description';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$staff_description;
                }
                   $update2 = DB::table('staff_profile')
                 ->where('staff_id', $insert)
                  ->update([$langs->lang_prefix.'_staff_description'=>$t_product_name]);   
                   }
     return redirect()->back()->withErrors('Added successfully');
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }

    }
	
    public function Editstaff(Request $request)
         {
     if(Session::has('vendor'))
      {	
  
       $staff_id=$request->id;
    	 $vendor_email=Session::get('vendor');
    	 
         $vendor=DB::table('vendor')
                ->where('vendor_email',$vendor_email)
                ->first();       
    	 $staff= DB::table('staff_profile')
    	 		  ->where('staff_id',$staff_id)
    	 		  ->first();
  	   $lang=DB::table('langs')
             ->get();
    	 return view('vendor.staff.editstaff',compact("vendor_email","vendor","staff","lang"));
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }


    }
    
    public function Updatestaff(Request $request)
         {
      if(Session::has('vendor'))
      {
        $staff_id=$request->id;
        $staff_name=$request->staff_name;
        $staff_description=$request->staff_description;
        $old_staff_image=$request->old_staff_image;
        $date = date('d-m-Y');
        $updated_at = date("d-m-y h:i a");
        $date=date('d-m-y');
    

        $getImage = DB::table('staff_profile')
                     ->where('staff_id',$staff_id)
                    ->first();

        $image = $getImage->staff_image;  

        if($request->hasFile('staff_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $staff_image = $request->staff_image;
            $fileName = date('dmyhisa').'-'.$staff_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $staff_image->move('staff/images/'.$date.'/', $fileName);
            $staff_image = 'staff/images/'.$date.'/'.$fileName;
        }
        else{
            $staff_image = $old_staff_image;
        }

        $update = DB::table('staff_profile')
                 ->where('staff_id', $staff_id)
                 ->update(['staff_name'=>$staff_name,'staff_description'=>$staff_description,'staff_image'=>$staff_image,'created_at'=>$updated_at]);
            $lang=DB::table('langs')
                 ->get();
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_staff_description';
                $t_product_name=$request->$tec; 
                   $update2 = DB::table('staff_profile')
                 ->where('staff_id', $staff_id)
                  ->update([$langs->lang_prefix.'_staff_description'=>$t_product_name]);   
                   }
        if($update || $update2){

             

            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function deletestaff(Request $request)
         {
     if(Session::has('vendor'))
     {
        $staff_id=$request->id;

        $getfile=DB::table('staff_profile')
                ->where('staff_id',$staff_id)
                ->first();

        $staff_image=$getfile->staff_image;

    	$delete=DB::table('staff_profile')->where('staff_id',$request->id)->delete();
        if($delete)
        {
        
            if(file_exists($staff_image)){
                unlink($staff_image);
            }
         
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }

    }
}
