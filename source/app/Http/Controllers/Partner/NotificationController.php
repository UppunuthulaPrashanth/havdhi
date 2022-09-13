<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use App\Traits\SendMail;
use App\Service;
use App\VendorNotification;

class NotificationController extends Controller
{
	use SendMail;

    public function notifications(Request $request)
    {
		$notifications = VendorNotification::where('vendor_id',$request->vendor_id)->get();
    	if(count($notifications)>0){
    	    $notitions=VendorNotification::where('vendor_id',$request->vendor_id)->update(['read_by_vendor'=>1]);
    		$message = array('status'=>'1', 'message'=>'Notification list', 'data'=>$notifications);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Notification list');
	        return $message;
    	}
     }


}
