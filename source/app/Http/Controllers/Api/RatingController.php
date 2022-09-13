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

class RatingController extends Controller
{
use SendMail;

       public function add_salon_rating(Request $request)
    { 
        $user_id = $request->user_id;
        $staff_id = $request->vendor_id;
        $rating = $request->rating;
        $description=$request->description;
        $created_at = Carbon::now();
        $check = DB::table('review')
               ->where('user_id',$user_id)
               ->where('vendor_id',$staff_id)
               ->first();
               
        if($check){
            $review= DB::table('review') 
            ->where('user_id',$user_id)
               ->where('vendor_id',$staff_id)
               ->update([
               'rating'=>$rating,
               'description'=>$description,
               'active'=>1,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
        }       
          else{     
        $review= DB::table('review') 
               ->insert([ 'user_id'=>$user_id,
               'vendor_id'=>$staff_id,
               'rating'=>$rating,
               'description'=>$description,
               'active'=>1,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
          }     
        if($review){
            $message = array('status'=>'1', 'message'=>'reviewed successfully');
          return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'Please try again later');
          return $message;
        }
    }
    
     public function add_staff_rating(Request $request)
    { 
        $user_id = $request->user_id;
        $staff_id = $request->staff_id;
        $rating = $request->rating;
        $description=$request->description;
        $created_at = Carbon::now();
        $check = DB::table('staff_review')
               ->where('user_id',$user_id)
               ->where('staff_id',$staff_id)
               ->first();
    if($check){
         $review= DB::table('staff_review') 
               ->where('user_id',$user_id)
               ->where('staff_id',$staff_id)
               ->update([ 'rating'=>$rating,
               'review_description'=>$description,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
    }else{           
        $review= DB::table('staff_review') 
               ->insert([ 'user_id'=>$user_id,
               'staff_id'=>$staff_id,
               'rating'=>$rating,
               'review_description'=>$description,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
    }    
        if($review){
            $message = array('status'=>'1', 'message'=>'reviewed successfully');
          return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'Please try again later');
          return $message;
        }
    }
       public function add_product_rating(Request $request)
    { 
        $user_id = $request->user_id;
        $id = $request->product_id;
        $rating = $request->rating;
        $description=$request->description;
        $created_at = Carbon::now();
         $check = DB::table('staff_review')
              ->where('user_id',$user_id)
               ->where('product_id',$id)
               ->first();
               
         if($check){
         $review= DB::table('staff_review') 
               ->where('user_id',$user_id)
               ->where('product_id',$id)
               ->update([ 'rating'=>$rating,
               'description'=>$description,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
    }else{             
        $review= DB::table('review') 
               ->insert([ 'user_id'=>$user_id,
               'product_id'=>$id,
               'rating'=>$rating,
               'description'=>$description,
               'created_at'=>$created_at,
               'updated_at'=>$created_at]);
    }    
        if($review){
            $message = array('status'=>'1', 'message'=>'reviewed successfully');
          return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'Please try again later');
          return $message;
        }
    }
}