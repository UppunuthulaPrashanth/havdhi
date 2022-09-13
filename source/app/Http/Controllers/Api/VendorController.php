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

class VendorController extends Controller
{
use SendMail;

       public function salon_desc(Request $request)
    { 
        $vendor_id = $request->vendor_id;
        $lang=$request->lang;
        $lat = $request->lat;
       $lng = $request->lng;
       if($lang != NULL){
        $description = DB::table('vendor')
                     ->select($lang.'_description as description','shop_type','vendor_name','vendor_id','owner','vendor_logo','vendor_loc','lat','lng')
                     ->where('vendor_id', $vendor_id)
                     ->first();
       }else{
           $description = DB::table('vendor')
                      ->select('description','shop_type','vendor_name','vendor_id','owner','vendor_logo','vendor_loc','lat','lng')
                     ->where('vendor_id', $vendor_id)
                     ->first();
       }
        $rating = DB::table('review')
                 ->where('vendor_id', $vendor_id)
                 ->avg('rating');
                 
         $review = DB::table('review')
                 ->join('users','review.user_id','=','users.id')
                 ->select('review.*', 'users.name','users.image')
                 ->where('vendor_id',$vendor_id)
                  ->get();         
       
          if($lang != NULL){
              $check = DB::table('langs')
                     ->where('lang_prefix', $lang)
                     ->first();
                 
         $barber = DB::table('staff_profile')
                 ->select('staff_id','staff_name',$lang.'_staff_description as staff_description','staff_image','vendor_id','created_at')
                 ->where('vendor_id',$vendor_id)
                  ->get();      
         $sproduct = DB::table('shop_product')
                 ->select('id',$lang.'_product_name as product_name','product_image','price','quantity',$lang.'_description as description','created_at','updated_at','vendor_id')
                  ->where('vendor_id',$vendor_id)
                  ->get();  
                  
        $product = DB::table('service')
                  ->select('service_id',$lang.'_service_name as service_name','service_image','created_at','updated_at','vendor_id')
                  ->where('vendor_id',$vendor_id)
                  ->get();
             if(count($product)>0){ 
             $result =array();
            $i = 0;

            foreach ($product as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->service_id);
                $apps = array($app);
                $app = DB::table('service_varient')
                       ->select('varient_id','service_id',$lang.'_varient as varient','price','time',$lang.'_service_name as service_name','vendor_id')
                        ->whereIn('service_id', $apps)
                        ->get();
                        
                
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
        }else{
             $barber = DB::table('staff_profile')
                 ->select('staff_id','staff_name','staff_description','staff_image','vendor_id','created_at')
                 ->where('vendor_id',$vendor_id)
                  ->get();      
           $sproduct = DB::table('shop_product')
                 ->select('id','product_name','product_image','price','quantity','description','created_at','updated_at','vendor_id')
                  ->where('vendor_id',$vendor_id)
                  ->get();   
            $product = DB::table('service')
            ->select('service_id','service_name','service_image','created_at','updated_at','vendor_id')
                  ->where('vendor_id',$vendor_id)
                  ->get();
                  
                 if(count($product)>0){ 
             $result =array();
            $i = 0;

            foreach ($product as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->service_id);
                $apps = array($app);
                $app = DB::table('service_varient')
                         ->select('varient_id','service_id','varient','time','price','service_name','vendor_id')
                        ->whereIn('service_id', $apps)
                        ->get();
                        
                
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
        }         
         
        
             
     
    
       $type= $description->shop_type;
         $gallery = DB::table('galleries') 
         ->where('vendor_id', $vendor_id)
                 ->get();
        $weektime= DB::table('time_slot')
                 ->where('vendor_id', $vendor_id)
                 ->get();
         
        
 
          $nearbystore = DB::table('vendor')
                    ->select('vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','opening_time','closing_time','delivery_range','shop_type as type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                    //  ->where('vendor_id','!=', $vendor_id)
                  ->where('shop_type',$description->shop_type)
                  ->paginate(5);
 
          $pr = [];
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        }
        if($pr != []){ 
             $result =array();
            $i = 0;
            $j=0;

            foreach ($pr as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->vendor_id);
                $apps = array($app);
                $app = DB::table('review')
                        ->whereIn('vendor_id', $apps)
                        ->avg('rating');
                        
                
                if($app){        
                   $result[$i]->rating = round($app,1);
                   $i++; 
                   }
                   else{
                      $result[$i]->rating = 0;
                      $i++; 
                   }
                 } 
        }     
        
        if($lang){
          $des= $description->description; 
        }else{
            $des= $description->description; 
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
    
        public function similar_salon(Request $request)
    { 
        $vendor_id = $request->vendor_id;
        $description = DB::table('vendor')
                     ->select('description','shop_type')
                     ->where('vendor_id', $vendor_id)
                     ->first();
        
       
                     
        $lat = $request->lat;
       $lng = $request->lng;
       $nearbystore = DB::table('vendor')
                    ->select('vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','opening_time','closing_time','delivery_range','shop_type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                   ->where('vendor_id','!=', $vendor_id)
                  ->where('shop_type',$description->shop_type)
                  ->get();
 
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        }
        if($pr != NULL){ 
            $message = array('status'=>'1', 'message'=>'Salons Found at your location', 'data'=>$pr);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No similar salons at your location');
            return $message;
           }
               
    }
    
      public function salon_services(Request $request)
    {
          $vendor = $request->vendor_id;
       $product = DB::table('service')
                  ->where('vendor_id',$vendor)
                  ->get();
             
     
         if(count($product)>0){ 
             $result =array();
            $i = 0;

            foreach ($product as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->service_id);
                $apps = array($app);
                $app = DB::table('service_varient')
                        ->whereIn('service_id', $apps)
                        ->get();
                        
                
                if($app){        
                   $result[$i]->service_type = $app;
                   $i++; 
                   }
                   else{
                     $res[$i]->service_type = [];
                    
                   }
                 } 
            $message = array('status'=>'1', 'message'=>'Services Found', 'data'=>$pr);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No services added');
            return $message;
           }
                  
        
    }
   
}