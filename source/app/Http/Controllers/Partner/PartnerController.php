<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\Traits\SendMail;
use Validator;
use App\Vendor;
use App\Staff;
use App\ShopProduct;

class PartnerController extends Controller
{
use SendMail;


 public function partner_reg(Request $request)
    {
        
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
    	$shop_type = $request->type;   
        $vendor_id=$request->id;
        $vendor_name=$request->vendor_name;
        $owner = $request->owner_name;
        $vendor_email=$request->vendor_email;
        $vendor_phone=$request->vendor_phone; 
        $password=$request->vendor_password;

        $address1 = $request->vendor_address; 
        $description = $request->description; 
        $addres = str_replace(" ", "+", $address1);
        $address1 = str_replace("-", "+", $addres);
                       
        
         $checkmap = DB::table('map_api')
                  ->first();
         $mapset= DB::table('map_settings')
                ->first();
                
        $chkstorphon = DB::table('vendor')
                      ->where('vendor_phone', $vendor_phone)
                      ->first();
         $chkstoremail = DB::table('vendor')
                      ->where('vendor_email', $vendor_email)
                      ->first();        
                
          if($chkstorphon && $chkstoremail){
              $message = array('status'=>'0', 'message'=>'This Phone Number and Email Are Already Registered With Another Vendor');
                return $message;
        } 

        if($chkstorphon){
            $message = array('status'=>'0', 'message'=>'This Phone Number is Already Registered With Another Vendor');
                return $message;
        } 
        if($chkstoremail){
            $message = array('status'=>'0', 'message'=>'This Email is Already Registered With Another Vendor');
                return $message;
        }         
        

        //   if($mapset->mapbox == 0 && $mapset->google_map == 1){        
        // $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$checkmap->map_api_key));
        
        //  $lat = $response->results[0]->geometry->location->lat;
        //  $lng = $response->results[0]->geometry->location->lng;
        // }
        // else{
        //   $lat = $request->lat;
        //   $lng = $request->lng;  
        // }
              
              $lat = "29.006057";
              $lng = "77.027535";
        
        $old_vendor_image=$request->old_vendor_image;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
        if($request->vendor_image){
            $vendor_image = $request->vendor_image;
            $fileName = date('dmyhisa').'-'.$vendor_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $vendor_image->move('vendor_img/images/'.$date.'/', $fileName);
            $vendor_image = 'vendor_img/images/'.$date.'/'.$fileName;
        }else{
            $vendor_image = '';
        }
       
        $new_pass=Hash::make($password);
        $insert = DB::table('vendor')
                  ->insertGetId(['cityadmin_id'=>1,'vendor_name'=>$vendor_name,'vendor_logo'=>$vendor_image,'vendor_email'=> $vendor_email,'vendor_phone'=> $vendor_phone, 'vendor_pass'=>$new_pass,'vendor_loc'=>$address1,'lat'=>$lat,'lng'=>$lng,'owner'=>$owner, 'created_at'=>$created_at,'online_status'=>'OFF','admin_approval'=>0,'description'=>$description,'shop_type'=>$shop_type]);

        $vendor_id = $insert;
        $time = DB::table('time_slot')->where('vendor_id',$vendor_id)->get();
        if($time->count()==0){
            $time_dup[0] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Monday','vendor_id'=>$vendor_id];
            $time_dup[1] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Tuesday','vendor_id'=>$vendor_id];
            $time_dup[2] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Wednesday','vendor_id'=>$vendor_id];
            $time_dup[3] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Thursday','vendor_id'=>$vendor_id];
            $time_dup[4] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Friday','vendor_id'=>$vendor_id];
            $time_dup[5] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Saturday','vendor_id'=>$vendor_id];
            $time_dup[6] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Sunday','vendor_id'=>$vendor_id];
            DB::table('time_slot')->insert($time_dup);
        }

      
  if($insert){  
   $ven =  DB::table('vendor')
        ->where('vendor_id', $insert)
        ->first();
     
        $message = array('status'=>'1', 'message'=>'Registered successfully! Wait for admin approval', 'data'=>$ven);
                return $message;	
        }
        else{
           $message = array('status'=>'0', 'message'=>'Registeration failed! Try again later');
                return $message;	  
        }
    
}
    public function login(Request $request)
    
     {
    	$user_email = $request->vendor_email;
    	$user_password = $request->vendor_password;
    	$device_id = $request->device_id;
    
    	
            
    	$checkUser = DB::table('vendor')
    					->where('vendor_email', $user_email)
    					->first();
    	if($checkUser){
    	 
    
            if(Hash::check($user_password, $checkUser->vendor_pass)){
    		   $updateDeviceId = DB::table('vendor')
    		                       ->where('vendor_email', $user_email)
    		                       ->update(['device_id'=>$device_id]);
    		                       
    		      
                   
    			$message = array('status'=>'1', 'message'=>'login successfully', 'data'=>$checkUser);
	        	return $message;
                 
    	   }
    	   else{
    		$message = array('status'=>'0', 'message'=>'Wrong Password');
	        return $message;
    	}
    
	}	else{
    		$message = array('status'=>'0', 'message'=>'Partner not Registered');
	        return $message;
    	}
     }


    public function partner_profile(Request $request){
        $vendor_id = $request->vendor_id;
        $description = Vendor::select('*')->where('vendor_id', $vendor_id)->first();
        $lat = $description->lat;
        $lng = $description->lng;

        $rating = DB::table('review')->where('vendor_id', $vendor_id)->avg('rating');

         $review = DB::table('review')
                 ->join('users','review.user_id','=','users.id')
                 ->select('review.*', 'users.name','users.image')
                 ->where('vendor_id',$vendor_id)
                  ->get();         
        $barber = Staff::where('vendor_id',$vendor_id)->get();

        $sproduct = ShopProduct::where('vendor_id',$vendor_id)->get();          
        $product = DB::table('service')->where('vendor_id',$vendor_id)->get();

         if(count($product)>0){ 
             $result =array();
            $i = 0;

            foreach ($product as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->service_id);
                $apps = array($app);
                $app = DB::table('service_varient')->whereIn('service_id', $apps)->get();
                        
                
                if($app){        
                   $result[$i]->service_type = $app;
                   $i++; 
                   }
                   else{
                     $res[$j]->service_type = [];
                    $j++;  
                   }
                 }
         }
       $type= $description->shop_type;
         $gallery = DB::table('galleries')->where('vendor_id', $vendor_id)->get();
        $weektime= DB::table('time_slot')->where('vendor_id', $vendor_id)->get();
         
           $nearbystore = DB::table('vendor')
                    ->select('vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','opening_time','closing_time','delivery_range','shop_type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                //   ->where('vendor_id','!=', $vendor_id)
                  ->where('shop_type',$description->shop_type)
                  ->get();
 
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        }
          $data = array(
            'salon_name'=>$description->vendor_name,
            'owner'=>$description->owner,
            'description'=>$description->description,
            'type'=>$type,
            'vendor_logo'=>$description->vendor_logo,
            "vendor_loc"=>$description->vendor_loc,
            'vendor_id'=>$vendor_id,
            'rating'=>round($rating, 1),
            'weekly_time'=>$weektime,
            'barber'=>$barber, 
            'products'=>$sproduct,
            'services'=>$product,
            'review'=>$review,
            'gallery'=>$gallery,
            'similar_salons'=>$pr,
            'review'=>$review
            );       
               
        if($description){
            $message = array('status'=>'1', 'message'=>'salon details', "data"=>$data);
          return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'No salon found');
          return $message;
        }
    } 
  
  
/*    
    
    public function partner_profile(Request $request)
    {   
        $user_id = $request->vendor_id;
         $user =  DB::table('vendor')
                ->where('vendor_id', $user_id )
                ->first();
                        
        if($user){
        	$message = array('status'=>'1', 'message'=>'Partner Profile', 'data'=>$user);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'Partner not registered');
	        return $message;
    	}
        
    }   
  
  */
    
    
     public function profile_edit(Request $request)
    {
        $user_id = $request->id;
        $updated_at = Carbon::now();
    	$user_name = $request->user_name;
    
    	$user_image = $request->user_image;
    		$uu = DB::table('users')
    	    ->where('id', $user_id)
    	    ->first();
        	$user_password = $uu->password;
           $date=date('d-m-Y');
    	    
    	  if($request->user_image){
    	     $image = $request->user_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           $image->move('images/user/'.$date.'/', $fileName);
            $filePath = '/images/user/'.$date.'/'.$fileName;
        }
            else{
                $filePath = $uu->image;
            }
        

        
    		$insertUser = DB::table('users')
    		            ->where('id', $user_id)
    						->update([
    							'name'=>$user_name,
    							'image'=>$filePath,
    							'password'=>$user_password,
    							'updated_at'=>$updated_at
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('id', $user_id)
    					->first();
    					
    					
    		if($insertUser){
    						
	    		$message = array('status'=>'1', 'message'=>'Profile Updated', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something Went wrong');
	        return $message;
	    	}  
    	
    }
    
  
    
  public function validates(Request $request)
    {
      
            return response()->json(['error' => 'UnAuthorised'], 401);
        
    }
    
  
     
     public function profile_change_password(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $vendor = Vendor::where('vendor_id', $request->vendor_id)->first();
        if($vendor){
            if(Hash::check($request->current_password, $vendor->vendor_pass)){
                $vendor->vendor_pass = Hash::make($request->password);
                $vendor->save();
	    		$message = array('status'=>'1', 'message'=>'Password is Changes Successfully');
	        	return $message;
            }else{
	    		$message = array('status'=>'1', 'message'=>'Please enter correct current password');
	        	return $message;
            }
        }else{
    		$message = array('status'=>'1', 'message'=>'Invalid User.');
        	return $message;
        }

     }
    
    
    public function forget_password(Request $request)
    {
        $user_email = $request->vendor_email;
        $vendor = Vendor::where('vendor_email', $request->vendor_email)->first();
        $chars ="0123456789";
        $otp = "";
        for ($i = 0; $i < 6; $i++){
           $otp .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        if($vendor){
            $user_name = $vendor->vendor_name;   
            $vendor->otp = $otp;
            if($vendor->save()){
		        $otpmsg = $this->forgetpassword($user_email,$otp,$user_name);                   
			    $message = array('status'=>'1', 'message'=>'Check Your Mail for OTP', 'data'=>$vendor);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Something Went wrong! Please Try Again');
	        	return $message; 
            }
        }                
        else{
            $message = array('status'=>'0', 'message'=>'User not registered');
	        return $message;
        }
        
    }
    
    public function verifyOtp(Request $request)
    {
        $user_email = $request->vendor_email;
        $otp = $request->otp;
       
        // check for otp verify
        $vendor = Vendor::where('vendor_email', $request->vendor_email)->first();
        if($vendor){
            $getotp = $vendor->otp;
            
            if($otp == $getotp){
                $message = array('status'=>'1', 'message'=>"Otp Matched Successfully", 'data'=>$vendor);
                return $message;
            }
            else{
                $message = array('status'=>'0', 'message'=>"Wrong OTP");
                return $message;
            }
        }
        else{
            $message = array('status'=>'0', 'message'=>"User not registered");
            return $message;
        }
    }
    
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }

        $user_email = $request->vendor_email;
        $password = Hash::make($request->password);
        
        $vendor = Vendor::where('vendor_email', $request->vendor_email)->first();

        if($vendor){
            $vendor->vendor_pass = $password;
            if($vendor->save()){
    			$message = array('status'=>'1', 'message'=>'Password changed', 'data'=>$vendor);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Try Again Later');
	        	return $message; 
            }
        }
        else{
            $message = array('status'=>'0', 'message'=>"User not registered");
            return $message;
        }
    }
    
    
    public function update_profile(Request $request){

        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }

        $updated_at = Carbon::now();
        $vendor = Vendor::where('vendor_id', $request->vendor_id)->first();
        if(!$vendor){
    		$message = array('status'=>'0', 'message'=>'Something Went wrong');
            return $message;
        }

        $date=date('d-m-Y');
        $old_vendor_image=DB::table('vendor')
                         ->select('vendor_logo')
                         ->where('vendor_id',$request->vendor_id)
                         ->first();
         if($request->vendor_logo){
            $vendor_image = $request->vendor_logo;
            $fileName = date('dmyhisa').'-'.$vendor_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $vendor_image->move('vendor_img/images/'.$date.'/', $fileName);
            $vendor_image = 'vendor_img/images/'.$date.'/'.$fileName;
            $vendor->vendor_logo = $vendor_image;
        }else{
            $vendor_image = $old_vendor_image->vendor_logo;
        }
    
        
        if($request->vendor_name){
    	    $vendor->vendor_name = $request->vendor_name;
        }
        if($request->owner){
    	    $vendor->owner = $request->owner;
        }
        if($request->cityadmin_id){
    	    $vendor->cityadmin_id = $request->cityadmin_id;
        }
        if($request->vendor_email){
    	    $vendor->vendor_email = $request->vendor_email;
        }
        if($request->vendor_phone){
    	    $vendor->vendor_phone = $request->vendor_phone;
        }
        if($request->vendor_loc){
    	    $vendor->vendor_loc = $request->vendor_loc;
        }
        if($request->description){
    	    $vendor->description = $request->description;
        }
        if($request->opening_time){
    	    $vendor->opening_time = $request->opening_time;
        }
        if($request->closing_time){
    	    $vendor->closing_time = $request->closing_time;
        }
        if($request->comission){
    	    $vendor->comission = $request->comission;
        }
        if($request->delivery_range){
    	    $vendor->delivery_range = $request->delivery_range;
        }
        if($request->shop_type){
    	    $vendor->shop_type = $request->shop_type;
        }
        if($request->booking_amount){
    	    $vendor->booking_amount = $request->booking_amount;
        }
        if($request->admin_approval){
    	    $vendor->admin_approval = $request->admin_approval;
        }
        if($request->admin_share){
    	    $vendor->admin_share = $request->admin_share;
        }
        if($request->updated_at){
    	    $vendor->updated_at = $updated_at;
        }
      $vendor->save();
		if($vendor->save()){
    		$message = array('status'=>'1', 'message'=>'Profile Updated', 'data'=>$vendor);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something Went wrong');
        return $message;
    	}  
    	
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

}
