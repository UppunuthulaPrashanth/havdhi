<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\Traits\SendMail;

class UserController extends Controller
{
use SendMail;
public function social_login(Request $request)
    {
    $logintype = $request->type;
    $device_id = $request->device_id;
    if($logintype == 'google'){
       $user_email = $request->user_email;
       $checkuser = DB::table('users')
                  ->where('email',$user_email)
                  ->where('phone_verified','!=',0)
                  ->first();

      
      if($checkuser){
          $updateDeviceId = DB::table('users')
    		              ->where('email',$user_email)
    		              ->update(['device_id'=>$device_id]);
            $user = User::where('email',$user_email)
                    ->first();
              $token = JWTAuth::fromUser($user);  
              
               $checkitemss = DB::table('product_order_details')
            ->where('user_id',$checkuser->id)
            ->where('status', "incart")
            ->count();     
            $data=array('user'=>$checkuser,
                         'cart_count'=>$checkitemss);
                 $message = array('status'=>'1', 'message'=>'Login Successfully','data'=>$data, 'token'=>$token);
                return $message;
      }else{
          $delete = DB::table('users')
                  ->where('email',$user_email)
                  ->where('phone_verified', 0)
                  ->delete();
         $message = array('status'=>'2', 'message'=>'go to register page', 'user_email'=>$user_email);
                return $message;
      }
    }
    else{
     $email = $request->email_id;
       $fb_id = $request->facebook_id;
        $checkuser = DB::table('users')
                  ->where('phone_verified','!=',0)
                  ->where('facebook_id',$fb_id)
                  ->orWhere('email', $email)
                  ->first();

      if($checkuser){
          $updateDeviceId = DB::table('users')
    		              ->where('facebook_id',$fb_id)
                          ->orWhere('email', $email)
    		              ->update(['device_id'=>$device_id]);
    		 $user = User::where('facebook_id',$fb_id)
                          ->orWhere('email', $email)
                    ->first();             
            $token = JWTAuth::fromUser($user); 
                $checkitemss = DB::table('product_order_details')
            ->where('user_id',$checkuser->id)
            ->where('status', "incart")
            ->count();     
            $data=array('user'=>$checkuser,
                         'cart_count'=>$checkitemss);
            
                 $message = array('status'=>'1', 'message'=>'Login Successfully','data'=>$data, 'token'=>$token);
                return $message;
      }else{
        $delete = DB::table('users')
                   ->where('phone_verified','!=',0)
                     ->where('facebook_id',$fb_id)
                    ->orWhere('email', $email)
                  ->delete();
         $message = array('status'=>'3', 'message'=>'go to register page', 'fb_id' =>$fb_id);
                return $message;
      }
    }

   }

 public function signUp(Request $request)
    {
        
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
    	$user_name = $request->user_name;
    	$user_email = $request->user_email;
    	$user_phone = $request->user_phone;
    	$user_image = $request->user_image;
    	$fb_id = $request->fb_id;
        $user_password = Hash::make($request->password);
        $device_id = $request->device_id;
    	$date = date('d-m-Y');	          
    	 if($request->user_image){
            $image = $request->user_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           $image->move('images/user/'.$date.'/', $fileName);
            $filePath = '/images/user/'.$date.'/'.$fileName;
    
        }
          else{
               $filePath = 'N/A';
            }
            
        if($fb_id == NULL){
            $fb_id == NULL;
        }
        
        $u_name1 = str_replace(' ', '', $user_name);
        $u_name2 = str_replace('.', '', $u_name1);
        $u_name3 = str_replace('-', '', $u_name2);
        $u_name = str_replace(',', '', $u_name3);
         $referral_code1 = $request->referral_code;
         $startingg = str_replace(' ', '', $u_name);
         $startingg1 = strtoupper(substr($u_name , 0, 3));
       
         $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $referral_code = "";
                    for ($i = 0; $i < 5; $i++){
                       $referral_code .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        $referral_c =$startingg1.$referral_code;             
        if($request->referral_code){
            $getReferredUser = DB::table('users')
                                ->where('referral_code', $referral_code1)
                                ->get();

            if(count($getReferredUser) == 0){
                $message = array('status'=>'0', 'message'=>'wrong referral code');
                return $message;
            }
        }

        $date=date('d-m-Y');
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
                        ->orwhere('email', $user_email)
    					->first();
    	//////delete if unverified/////				
    	if($checkUser && $checkUser->phone_verified==0){
    	    	$delUser = DB::table('users')
    					->where('id', $checkUser->id)
    					->delete();
    					}					
        
    	if($checkUser && $checkUser->phone_verified==1){
    		$message = array('status'=>'0', 'message'=>'user already registered');
            return $message;
    	}
    	
  
        
    	 $user = DB::table('users')
    	 ->insertGetId([
            'name'=>$user_name,
            'email'=>$user_email,
            'user_phone'=>$user_phone,
            'image'=>$filePath,
            'password'=>$user_password,
            'device_id'=>$device_id,
            'facebook_id'=>$fb_id,
            'referral_code'=>$referral_c,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at, 
            ]);
 
    		if($user){
                 ////earn referral amount/////      
    			  if($request->referral_code){
                    $getReferredUser1 = DB::table('users')
                                        ->where('referral_code', $referral_code1)
                                        ->first();

                    if($getReferredUser1){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$user->id,
                                                'referral_by'=>$getReferredUser->id,
                                                'created_at'=>$created_at,
                                            ]);
                         $getScratchCard = DB::table('referral_points')
                                ->first();

                   $scratch_card_offers = json_decode($getScratchCard->points);
                   $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

                   $earn = "You've won ".$earning." reward points.";
                   /////referral by user//////
                    $userupdate = DB::table('users')
                                        ->where('referral_code', $referral_code1)
                                        ->update(['rewards'=>$getReferredUser1->rewards + $earning]);
                    //////referral to user /////////
                      $userupdate2 = DB::table('users')
                                        ->where('id', $user->id)
                                        ->update(['rewards'=>$earning]);                   

                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code');
                        return $message;
                    }
                }	
            	 $user1 = User::where('id', $user)
                    ->first();
 
    			$message = array('status'=>'1', 'message'=>'verify OTP', 'data'=>$user1);
                return $message;			
             	}
             	else{
             	    $message = array('status'=>'0', 'message'=>'wrong referral code');
                        return $message;
             	}
            
        }
    
    
    public function verifyotpfirebase(Request $request)
    {
        $phone = $request->user_phone;
        $status = $request->status;
        $device_id = $request->device_id;
        $referral_code = $request->referral_code;
         $created_at = Carbon::now();       
        // check for otp verify
        $getUser = DB::table('users')
                  ->where('user_phone', $phone)
                    ->first();
             
            
        $user_name =  $getUser->name;
        $user_phone = $getUser->user_phone;
        $user_email = $getUser->email;
                    
                    
        if($getUser){
            
            if($status == "success"){
                // verify phone
                $getUser2 = User::where('user_phone', $phone)
                            ->update(['phone_verified'=>1]);


                 if($referral_code != NULL){
                    $getReferredUser1 = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->first();
                     $getuser = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->first();
                    if($getReferredUser1){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$getuser->id,
                                                'referral_by'=>$getReferredUser1->id,
                                                'created_at'=>$created_at,
                                            ]);
                         $getScratchCard = DB::table('referral_points')
                                ->first();

                   $scratch_card_offers = json_decode($getScratchCard->points);
                   $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

                   $earn = "You've won ₹ ".$earning;
                   /////referral by user//////
                    $userupdate = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->update(['rewards'=>$getReferredUser1->rewards + $earning]);
                    //////referral to user /////////
                      $userupdate2 = DB::table('users')
                                        ->where('user_phone', $phone)
                                        ->update(['rewards'=>$earning]);                   

                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code');
                        return $message;
                    }
                }
                 $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                  
                 $user = User::where('user_phone', $phone)
                    ->first();
                 $token = JWTAuth::fromUser($user);
                $message = array('status'=>'1', 'message'=>"Phone Verified! login successfully", 'data'=> $getUser, 'token'=>$token);
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
    
    
     


  



    public function login_with_email(Request $request)
    
     {
    	$user_email = $request->user_email;
    	$user_password = $request->password;
    	$device_id = $request->device_id;
    
    	
            
    	$checkUser = DB::table('users')
    					->where('email', $user_email)
    					->first();
    					
    	 $checkitemss = DB::table('product_order_details')
            ->where('user_id',$checkUser->id)
            ->where('status', "incart")
            ->count();
          
                
           
                         
                         
                         
    	if($checkUser){
    	 
    		   $checkUserreg = DB::table('users')
            					->where('email', $user_email)
            					->first();
    
            if(Hash::check($user_password, $checkUserreg->password)){
    		   $updateDeviceId = DB::table('users')
    		                       ->where('email', $user_email)
    		                       ->update(['device_id'=>$device_id]);
    		                       
    		         $user = User::where('email', $user_email)
                    ->first();
                    $data=array('user'=>$user,
                         'cart_count'=>$checkitemss);    
                 $token = JWTAuth::fromUser($user);               
    			$message = array('status'=>'1', 'message'=>'login successfully', 'data'=>$data, 'token'=>$token);
	        	return $message;
                 
    	   }
    	   else{
    		$message = array('status'=>'0', 'message'=>'Wrong Password');
	        return $message;
    	}
    
	}	else{
    		$message = array('status'=>'0', 'message'=>'User not Registered');
	        return $message;
    	}
     }
    
    
     public function login_with_phone(Request $request)
    
     {
    	$user_phone = $request->user_phone;
    	$device_id = $request->device_id;
    
    	
            
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    	if($checkUser){
            
    		   $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $user_phone)
    		                        ->update(['device_id'=>$device_id]);
    		                       
    		 $user = User::where('user_phone', $user_phone)
                    ->first();
    			$message = array('status'=>'1', 'message'=>'OTP sent', 'data'=>$user);
	        	return $message;
                 
    	  
    
	}	else{
    		$message = array('status'=>'0', 'message'=>'User not Registered');
	        return $message;
    	}
     }
    
    
     public function login_verifyotpfirebase(Request $request)
    {
        $phone = $request->user_phone;
        $status = $request->status;
        $device_id = $request->device_id;
         $created_at = Carbon::now();       
        // check for otp verify
        $getUser = DB::table('users')
                  ->where('user_phone', $phone)
                    ->first();
         	 $checkitemss = DB::table('product_order_details')
            ->where('user_id',$getUser->id)
            ->where('status', "incart")
            ->count();            
        $user_name =  $getUser->name;
        $user_phone = $getUser->user_phone;
        $user_email = $getUser->email;
                    
                    
        if($getUser && $getUser->phone_verified == 1){
            
            if($status == "success"){
                  
                     $getuser = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->first();
                 
                 $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                $data=array('user'=>$getUser,
                         'cart_count'=>$checkitemss);  
                 $user = User::where('user_phone', $phone)
                    ->first();
                 $token = JWTAuth::fromUser($user);
                $message = array('status'=>'1', 'message'=>"Login successfully", 'data'=> $data, 'token'=>$token);
                return $message;
            }
            else{
                $message = array('status'=>'0', 'message'=>"Wrong OTP", 'data'=>$checuss);
                return $message;
            }
       
        }
        else{
            $message = array('status'=>'0', 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
        
    }
    
    
    public function myprofile(Request $request)
    {   
        $user_id = $request->id;
         $user =  DB::table('users')
                ->where('id', $user_id )
                ->first();
                        
    if($user){
        	 $user = User::where('id', $user_id)
                    ->first();
              $token = JWTAuth::fromUser($user); 
        	$message = array('status'=>'1', 'message'=>'User Profile', 'data'=>$user,'token'=>$token);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'User not registered');
	        return $message;
    	}
        
    }   
    
    public function forgotPassword(Request $request)
    {
        $user_email = $request->user_email;
        $checkUser = DB::table('users')
                        ->where('email', $user_email)
                        ->where('phone_verified',1)
                        ->first();
        $user_name = $checkUser->name;   
         $chars ="0123456789";
                    $otp = "";
                    for ($i = 0; $i < 6; $i++){
                       $otp .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        if($checkUser){
               
    
                $updateOtp = DB::table('users')
                                ->where('email', $user_email)
                                ->update(['otp'=>$otp]);
                                
            if($updateOtp){
    		     $otpmsg = $this->forgetpassword($user_email,$otp,$user_name);                   
    			$message = array('status'=>'1', 'message'=>'Check Your Mail for OTP', 'data'=>$checkUser);
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
        $user_email = $request->user_email;
        $otp = $request->otp;
       
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('email', $user_email)
                    ->where('phone_verified',1)
                    ->first();
                    
        if($getUser){
            $getotp = $getUser->otp;
            
            if($otp == $getotp){
                $message = array('status'=>'1', 'message'=>"Otp Matched Successfully", 'data'=>$getUser);
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
    
    public function changePassword(Request $request)
    {
        $user_email = $request->user_email;
        $password = Hash::make($request->password);
        
        $getUser =DB::table('users')
                    ->where('email', $user_email)
                    ->where('phone_verified',1)
                    ->first();
                    
        if($getUser){
            $updateOtp = DB::table('users')
                            ->where('email', $user_email)
                            ->update(['password'=>$password]);
                                
            if($updateOtp){
    		                        
    			$message = array('status'=>'1', 'message'=>'Password changed', 'data'=>$getUser);
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
    
    
     public function profile_edit(Request $request)
    {
        
        $user_id = $request->id;
        $updated_at = Carbon::now();
    	$user_name = $request->user_name;
    $user_password1= $request->password;
    
    	$user_image = $request->user_image;
    	$uu = DB::table('users')
    	    ->where('id', $user_id)
    	    ->first();
    if($user_password1==NULL){	    
	$user_password = $uu->password;
    }else{
     $user_password = Hash::make($user_password1);   
    }
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
    			 $user = User::where('id', $user_id)
                    ->first();
              $token = JWTAuth::fromUser($user); 			
	    		$message = array('status'=>'1', 'message'=>'Profile Updated', 'data'=>$Userdetails,'token'=>$token);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something Went wrong');
	        return $message;
	    	}  
    	
    }
    
  
    
    
    public function resendotp(Request $request)
    {
        $user_phone = $request->user_phone;
       $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $otpval = "";
                    for ($i = 0; $i < 5; $i++){
                       $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('user_phone', $user_phone)
                    ->first();
  
        if($getUser){
          
              $getUserup = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->update(['otp_value'=>NULL]);
                            
                $message = array('status'=>'1', 'message'=>'Otp sent via firebase', 'data'=>$getUser);
                return $message;	            
        }
        else{
            $message = array('status'=>'0', 'message'=>"User not found", 'data'=>	$checuss);
            return $message;
        }
        
    }
    
     public function deletenum(Request $request)
    {
       $user_phone = $request->user_phone;
       $del = DB::table('users')
            ->where('user_phone', $user_phone)
            ->delete();
        if($del){
             $message = array('status'=>'1', 'message'=>"User Number Deleted");
            return $message;
        }else{
             $message = array('status'=>'0', 'message'=>"not found");
            return $message;
        }    
    }
    
  public function validates(Request $request)
    {
      
            return response()->json(['error' => 'UnAuthorised'], 401);
        
    }

}
