<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use App\Traits\SendMail;
use Validator;
use App\PartnerReviews;
use App\ProductReviews;
use App\StaffReviews;

class ReviewsController extends Controller
{
use SendMail;

    public function partner_reviews(Request $request){
        $reviews = PartnerReviews::with('user')->with('vendor')->has('user')->has('vendor')->where(['active'=>1,'vendor_id'=>$request->vendor_id])->get();
        
    	if( $reviews->count() > 0){
    		$message = array('status'=>'1', 'message'=>'Review list', 'data'=>$reviews);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Review list');
	        return $message;
    	}
     }
    
    public function product_reviews(Request $request){
        $reviews = ProductReviews::with('user')->with('product')->has('user')->has('product')->where(['product_id'=>$request->product_id])->get();
        
    	if( $reviews->count() > 0){
    		$message = array('status'=>'1', 'message'=>'Review list', 'data'=>$reviews);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Review list');
	        return $message;
    	}
     }

    public function expert_reviews(Request $request){
        $vendor_id = $request->vendor_id;
        $reviews = StaffReviews::with('user')->with('staff')->has('user')->has('staff')->where(['staff_id'=>$request->staff_id])->get();
        
    	if( $reviews->count() > 0){
    		$message = array('status'=>'1', 'message'=>'Review list', 'data'=>$reviews);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Review list');
	        return $message;
    	}
     }


}
