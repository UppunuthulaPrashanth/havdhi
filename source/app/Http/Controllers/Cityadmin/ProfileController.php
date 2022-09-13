<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;

class ProfileController extends Controller
{
    public function adminProfile(Request $request)
    {
    	 
    	 $admin_email=Session::get('admin');
    	 $profile= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	
           return view('admin.profile',compact("admin_email","profile"));
      

    }
   
   
      public function Editadmin(Request $request)
{
    
	 $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;	
      $api_key=  DB::table('fcm_key')
    	       ->select('*')
               ->first();
      $user_api_key = $api_key->user_app_key;
      //$dboy_api_key = $api_key->dboy_app_key;
      $dboy_api_key = '';
      $vendor_app_key = $api_key->vendor_app_key;
      
      $country=  DB::table('country_code')
    	       ->select('*')
               ->first();
      $country_code = $country->country_code;
      
      $logo= DB::table('logo')
        ->first();
        

   
        
     $msg91 = DB::table('msg91')
                ->first();   
          $twilio = DB::table('twilio')
                ->first(); 
            $smsby = DB::table('smsby')
                ->first(); 
    $g = DB::table('map_api')
                ->first();   
          $m = DB::table('mapbox')
                ->first(); 
          $mset = DB::table('map_settings')
                ->first(); 
    	 $currency= DB::table('currency')
                ->first();
          $setting= DB::table('settings')
                ->first();
          $currency_sign= DB::table('payment_currency')
                ->get();
	 return view('cityadmin.editadmin.editadmin',compact("cityadmin_email","cityadmin_id","cityadmin","user_api_key","dboy_api_key","api_key","logo","msg91","twilio", "smsby","g","m","mset","currency","country","country_code","setting","currency_sign","vendor_app_key"));
}
   

    public function adminUpdateProfile(Request $request)
    {
   
        $admin_id = $request->id;
        $admin_name = $request->admin_name;
        $admin_email = $request->admin_email;
        $admin_pass = $request->admin_pass;
        $admin_phone = $request->admin_phone;
        $admin_phone2 = $request->admin_phone2;
        $password2 = $request->password2;
        $old_admin_image = $request->old_admin_image;
        $date=date('d-m-y');
        if($admin_pass!=$password2){
            return redirect()->back()->withErrors('password are not same');
        }
        else{
        $this->validate(
            $request,
                [
                    'admin_name' => 'required',
                    'admin_email' => 'required',
                    'admin_image' => 'mimes:jpeg,png,jpg|max:400',
                    'old_admin_image'=>'required',
                ],
                [
                    'admin_name.required' => 'Enter your name.',
                    'admin_email.required' => 'Enter new email.',
                    'old_admin_image.required' => 'choose profile picture.',
                ]
        );

        $getImage = DB::table('cityadmin')
                        ->where('cityadmin_id', $admin_id)
                        ->first();

        $image = $getImage->cityadmin_image;  

        if($request->hasFile('admin_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $admin_image = $request->admin_image;
            $fileName = date('dmyhisa').'-'.$admin_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $admin_image->move('images/admin/profile/'.$date.'/', $fileName);
            $admin_image = 'images/admin/profile/'.$date.'/'.$fileName;
        }
        else{
            $admin_image = $old_admin_image;
        }
        
        if($admin_pass!="" && $password2!="")
        {
            if($admin_pass!=$password2){
                return redirect()->back()->withErrors('password are not same');
            }
            else
            {
                $new_pass=Hash::make($admin_pass);
                $value=array('cityadmin_name'=>$admin_name, 'cityadmin_email'=>$admin_email, 'cityadmin_image'=>$admin_image,'cityadmin_pass' =>$new_pass, 'cityadmin_phone'=>$admin_phone);
            }
            
        }
        else
        {
            $value=array('cityadmin_name'=>$admin_name, 'cityadmin_email'=>$admin_email, 'cityadmin_image'=>$admin_image, 'cityadmin_phone'=>$admin_phone);
        }

        $adminChangeProfile = DB::table('cityadmin')
                                ->where('cityadmin_id', $admin_id)
                                ->update($value);

        if($adminChangeProfile){

             session::put('cityadmin',$admin_email);

            return redirect()->back()->withErrors('profile updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
}
    public function adminChangePass(Request $request)
    {
        
        $admin_email=Session::get('admin');
         $pass= DB::table('admin')
                   ->where('admin_email',$admin_email)
                   ->first();
        
           return view('admin.change_pass',compact("admin_email","pass"));
       
    }



   public function adminChangePassword(Request $request)
    {
       
        $this->validate(
            $request,
                [
                    'current_pass' => 'required',
                    'new_pass' => 'required',
                ],
                [
                    'current_pass.required' => 'Enter current password.',
                    'new_pass.required' => 'Enter new password.',
                ]
           );

        $admin_id = $request->id;
        $current_pass = $request->current_pass;

        $getAdmin = DB::table('admin')
                    ->where('admin_id', $admin_id)
                    ->first();

        if(Hash::check($current_pass,$getAdmin->admin_pass))
            {
            $new_pass = Hash::make($request->new_pass);
            $updated_at = date("d-m-y h:i a");

            $adminChangePassword = DB::table('admin')
                                    ->where('admin_id', $admin_id)
                                    ->update(['admin_pass'=>$new_pass,'updated_at'=>$updated_at]);

            if($adminChangePassword)
            {
                

                return redirect()->back()->withErrors("password changed! login again.");
            }
            else{
                return redirect()->back()->withErrors("something wents wrong.");
            }
        }
        else{
            return redirect()->back()->withErrors("current password does not match.");
        }
     }
	 
       public function adminLogout(Request $request)
     {
      $request->session()->forget('cityadmin');
           return redirect()->route('cityadminlogin')->withErrors("Logged Out Successfully");

     }
}

 