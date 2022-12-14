<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;

class LoginController extends Controller
{
	public function vendorlogin(Request $request)
    {
      return view('vendor.login');
    }
    public function checkvendorLogin(Request $request)
    {
    	$vendor_email=$request->vendor_email;
    	$vendor_pass=$request->vendor_pass;

    	$this->validate(
         $request,
         [
         		'vendor_email'=>'required',
         		'vendor_pass'=>'required',
         ],
         [

         	'vendor_email.required'=>'Enter E-Mail',
         	'vendor_pass.required'=>'Enter the password',
         ]

);
    	$checkvendorLogin = DB::table('vendor')
    	                   ->where('vendor_email',$vendor_email)
    	                   ->first();

    	if($checkvendorLogin){
    	    

         if(Hash::check($vendor_pass,$checkvendorLogin->vendor_pass)){
           session::put('vendor',$checkvendorLogin->vendor_email);
           return redirect()->route('vendor-index');
         }
         else
         {
         	return redirect()->route('vendorlogin')->withErrors('wrong password');
         }
      
    	}
    	else
    	{
             return redirect()->route('vendorlogin')->withErrors('invalid email and password');
    	}

    }
    
}
