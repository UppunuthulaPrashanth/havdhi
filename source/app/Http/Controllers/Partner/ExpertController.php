<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use App\Traits\SendMail;
use Validator;

class ExpertController extends Controller
{
use SendMail;


 public function add(Request $request)
    {
        
         $vendor_id = $request->vendor_id;
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
  if($insert){

        
            $lang=DB::table('langs')
                 ->get();
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_staff_description';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$request->staff_description;
                }
                   $update2 = DB::table('staff_profile')
                 ->where('staff_id', $insert)
                  ->update([$langs->lang_prefix.'_staff_description'=>$t_product_name]);   
                   }
        $ven =  DB::table('staff_profile')
        ->where('staff_id', $insert)
        ->first();
        $message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$ven);
                return $message;	
        }
        else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    
}
    public function list(Request $request)
    
     {
         $vendor_id = $request->vendor_id;
      $staff= DB::table('staff_profile')
        ->where('vendor_id',$vendor_id)
        ->get();
        
    	if(count($staff)>0){
    		$message = array('status'=>'1', 'message'=>'Staff list', 'data'=>$staff);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no staff list');
	        return $message;
    	}
     }
    
  public function edit(Request $request)
    {

        $staff_id= $request->staff_id;
        $staff_profile = DB::table('staff_profile')->where('staff_id', $staff_id)->first();
        if(!$staff_profile){
            $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
            return $message;	  
        }
        $vendor_id = $request->vendor_id;
        $staff_name=$request->staff_name;
        $staff_description=$request->staff_description;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
		if($request->hasFile('staff_image')){
            $staff_image = $request->staff_image;
            $fileName = date('dmyhisa').'-'.$staff_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $staff_image->move('staff/images/'.$date.'/', $fileName);
            $staff_image = 'staff/images/'.$date.'/'.$fileName;
		}else{
            $staff_image = $staff_profile->staff_image;
		}


        $insert = DB::table('staff_profile')
                  ->where('staff_id', $staff_id)
                  ->update(['staff_name'=>$staff_name,'staff_description'=>$staff_description,'staff_image'=>$staff_image,'created_at'=>$created_at]);
  if($insert){  
     $ven =  DB::table('staff_profile')
        ->where('staff_id', $staff_id)
        ->first();   
      $lang=DB::table('langs')
           ->get();
  $lang=DB::table('langs')
                 ->get();
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_staff_description';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$request->staff_description;
                }
                   $update2 = DB::table('staff_profile')
                 ->where('staff_id', $staff_id)
                  ->update([$langs->lang_prefix.'_staff_description'=>$t_product_name]);   
                   }
 
     
        $message = array('status'=>'1', 'message'=>'Updated successfully', 'data'=>$ven);
                return $message;	
        }
        else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    
}   

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $staff = DB::table('staff_profile')->where('staff_id',$request->staff_id)->delete();

    	if($staff){
    		$message = array('status'=>'1', 'message'=>'Deleted successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }
   

}
