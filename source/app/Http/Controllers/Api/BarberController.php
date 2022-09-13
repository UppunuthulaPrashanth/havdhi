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

class BarberController extends Controller
{
use SendMail;
public function barber_desc(Request $request)
    {
        $staff_id = $request->staff_id;
        $lang= $request->lang;
        $staff = DB::table('staff_profile')
               ->where('staff_id', $staff_id)
               ->first();
        $vendor_id = $staff->vendor_id;

        $description = DB::table('vendor')
                     ->where('vendor_id', $vendor_id)
                     ->first();
        $rating = DB::table('staff_review')
                 ->where('staff_id', $staff_id)
                 ->avg('rating');

         $review = DB::table('staff_review')
                 ->join('users','staff_review.user_id','=','users.id')
                 ->select('staff_review.*', 'users.name','users.image')
                 ->where('staff_review.staff_id', $staff_id)
                  ->get();





          $type= $description->shop_type;


        $weektime= DB::table('time_slot')
                 ->where('vendor_id', $vendor_id)
                 ->get();
        if($lang != NULL){
            $t=$lang.'_staff_description';
            $des = $staff->$t;
        }else{
            $des = $staff->staff_description;
        }

        $data = array(
            'salon_name'=>$description->vendor_name,
            'owner'=>$description->owner,
            'vendor_logo'=>$description->vendor_logo,
            "vendor_loc"=>$description->vendor_loc,
            'staff_id'=>$staff->staff_id,
            'staff_name'=>$staff->staff_name,
            'staff_image'=>$staff->staff_image,
            'staff_description'=>$des,
            'vendor_id'=>$vendor_id,
            'created_at'=>$staff->created_at,
            'type'=>$type,
            'rating'=>round($rating, 1),
            'weekly_time'=>$weektime,
            'review'=>$review
            );

        if($staff){
            return array('status'=>'1', 'message'=>'Barber details','data'=>$data);

        }
        else{
            return array('status'=>'0', 'message'=>'No Barber found');

        }
    }


    public function product_desc(Request $request)
    {
        $id = $request->product_id;
        $lang= $request->lang;
        $user_id = $request->user_id;
        $product = DB::table('shop_product')
               ->where('id', $id)
               ->first();
        $vendor_id = $product->vendor_id;
       $wish= DB::table('wishlist')
                  ->where('product_id',$id)
                  ->where('user_id',$user_id)
                  ->first();

                     if($wish){
                      $isFavourite = true;
                     }else{
                        $isFavourite = false;
                     }

        $description = DB::table('vendor')
                     ->select('vendor_name','owner','description','shop_type')
                     ->where('vendor_id', $vendor_id)
                     ->first();
        $rating = DB::table('product_review')
                 ->where('product_id', $id)
                 ->avg('rating');

         $review = DB::table('product_review')
                 ->join('users','product_review.user_id','=','users.id')
                 ->select('product_review.*', 'users.name','users.image')
                 ->where('product_review.product_id', $id)
                  ->get();

         if($lang != NULL){
             $d= $lang.'_description';
             $n= $lang.'_product_name';
            $des = $product->$d;
            $name = $product->$n;
        }else{
            $des = $product->description;
            $name = $product->product_name;
        }
           $data = array(
            'salon_name'=>$description->vendor_name,
            'owner'=>$description->owner,
            'id'=>$product->id,
            'product_name'=>$name,
            'product_image'=>$product->product_image,
            'quantity'=>$product->quantity,
            'description'=>$des,
            'price'=>$product->price,
            'vendor_id'=>$vendor_id,
            'created_at'=>$product->created_at,
            'updated_at'=>$product->updated_at,
            'rating'=>round($rating, 1),
            'review'=>$review,
            'isFavourite'=>$isFavourite
            );

        if($product){
            $message = array('status'=>'1', 'message'=>'Product details','data'=>$data);
          return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'No Product found');
          return $message;
        }
    }

}
