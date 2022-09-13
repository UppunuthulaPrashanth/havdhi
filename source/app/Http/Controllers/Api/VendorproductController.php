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

class VendorproductController extends Controller
{
use SendMail;

       public function salon_products(Request $request)
    { 
       $lat = $request->lat;
       $lng = $request->lng;
       $seachstring= $request->searchstring;
       $user_id = $request->user_id;
        $lang = $request->lang;

       if($user_id != NULL){
     if($lang!=NULL){
         $product = DB::table('shop_product')
                   ->join('vendor','shop_product.vendor_id','=','vendor.vendor_id')
                   ->leftJoin('product_order_details','shop_product.id','=','product_order_details.product_id')
                    ->select('shop_product.id','shop_product.'.$lang.'_product_name as product_name','shop_product.product_image','shop_product.price','shop_product.quantity','shop_product.'.$lang.'_description as description','shop_product.created_at','shop_product.updated_at','shop_product.vendor_id','vendor.vendor_name','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('vendor.online_status','ON')
                   ->where('vendor.admin_approval',1)
                  ->where('shop_product.product_name', 'like', $seachstring.'%')
                  ->paginate(5);
     }else{
           $product = DB::table('shop_product')
                   ->join('vendor','shop_product.vendor_id','=','vendor.vendor_id')
                   ->leftJoin('product_order_details','shop_product.id','=','product_order_details.product_id')
                    ->select('shop_product.id','shop_product.product_name','shop_product.product_image','shop_product.price','shop_product.quantity','shop_product.description','shop_product.created_at','shop_product.updated_at','shop_product.vendor_id','vendor.vendor_name','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('vendor.online_status','ON')
                   ->where('vendor.admin_approval',1)
                  ->where('shop_product.product_name', 'like', $seachstring.'%')
                  ->paginate(5);
     }         
                  
         if(count($product)>0){ 
             $result =array();
            $i = 0;
           $j=0;
            foreach ($product as $cats) {
                
                array_push($result, $cats);
                $app = json_decode($cats->id);
                $apps = array($app);
                 $app = DB::table('product_order_details')
                 ->select('qty')
                  ->where('product_id',$cats->id)
                  ->where('user_id',$user_id)
                  ->where('status','incart')
                  ->first();
                  if($app){
                   $result[$i]->cart_qty = $app->qty;
                  
                  }else{
                     $result[$i]->cart_qty = 0; 
                  }
                   
                    $wish= DB::table('wishlist')
                  ->where('product_id',$cats->id)
                  ->where('user_id',$user_id)
                  ->first();
                    
                     if($wish){
                      $result[$i]->isFavourite = true;  
                     }else{
                       $result[$i]->isFavourite = false;    
                     }
                       $i++;
                 }
                 
                
         }
       }else{
     if($lang!=NULL){
         $product = DB::table('shop_product')
                   ->join('vendor','shop_product.vendor_id','=','vendor.vendor_id')
                    ->select('shop_product.id','shop_product.'.$lang.'_product_name as product_name','shop_product.product_image','shop_product.price','shop_product.quantity','shop_product.'.$lang.'_description as description','shop_product.created_at','shop_product.updated_at','shop_product.vendor_id','vendor.vendor_name','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                   ->where('admin_approval',1)
                  ->where('shop_product.product_name', 'like', $seachstring.'%')
                  ->paginate(5);
     }else{
       $product = DB::table('shop_product')
                   ->join('vendor','shop_product.vendor_id','=','vendor.vendor_id')
                    ->select('shop_product.id','shop_product.product_name','shop_product.product_image','shop_product.price','shop_product.quantity','shop_product.description','shop_product.created_at','shop_product.updated_at','shop_product.vendor_id','vendor.vendor_name','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                   ->where('admin_approval',1)
                  ->where('shop_product.product_name', 'like', $seachstring.'%')
                  ->paginate(5);
     }
                   if(count($product)>0){ 
             $result =array();
            $i = 0;
          
            foreach ($product as $cats) {
                array_push($result, $cats);
                $app = json_decode($cats->id);
                  $result[$i]->cart_qty = 0; 
                  
                  $result[$i]->isFavourite = false;
                   $i++; 
                 }
         }
       }     
     
           $nearbystore = $product->unique('id');        
          
       
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        } 
         if($pr != NULL){ 
            $message = array('status'=>'1', 'message'=>'Products Found at your location', 'data'=>$pr);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
    }
    
    
          public function service_salons(Request $request)
    { 
        $ser_name = $request->service_name;
        $lang = DB::table('langs')
              ->get();
    if(count($lang)>0){          
        foreach($lang as $langs){
            $check= DB::table('service')
                 ->select('service_name')
                  ->where($langs->lang_prefix.'_service_name',$ser_name)
                  ->first();
                  
            if($check){
                $ser_name=$check->service_name;
            }else{
                $ser_name=$ser_name;
            }      
        } 
    }
        $lat = $request->lat;
       $lng = $request->lng;
         $product = DB::table('service')
                   ->join('vendor','service.vendor_id','=','vendor.vendor_id')
                    ->select('vendor.vendor_id','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  
                  ->where('service.service_name', $ser_name)
                  ->orderBy('distance')
                  ->get();
          $prr = $product->unique('vendor_id');
          $apps = NULL;
       foreach ($prr as $cats) {
                $app = json_decode($cats->vendor_id);
                $apps = array($app);
       }
       
                     
        
       
 
        if($apps != NULL){ 
            $nearbystore = DB::table('vendor')
                    ->select('vendor_id','vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','opening_time','closing_time','delivery_range','shop_type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                   ->whereIn('vendor_id', $apps)
                  ->paginate(5);
                  
             $prr = $nearbystore->unique('vendor_id');
          $pr1 = NULL;
        foreach($prr as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr1[] = $store; 
            }
            
        }       
                  
          if($pr1 != NULL){        
            $message = array('status'=>'1', 'message'=>'Salons Found at your location', 'data'=>$pr1);
            return $message;
          }else{
               $message = array('status'=>'0', 'message'=>'No Salons has this service');
            return $message;
          }
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
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
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
               
    }
   
}