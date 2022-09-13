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

class ServicesController extends Controller
{
use SendMail;
 public function getnearbysalons(Request $request)
    {
        $lat = $request->lat;
       $lng = $request->lng;
       $seachstring= $request->searchstring;
       $nearbystore = DB::table('vendor')
                    ->select('vendor_name','owner','vendor_id','vendor_email','vendor_phone','vendor_logo','vendor_loc','lat','lng','delivery_range','shop_type as type',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('online_status','ON')
                  ->where('admin_approval',1)
                  ->where('vendor_name', 'like', $seachstring.'%')
                  ->paginate(5);
 
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        }
        if($pr != NULL){ 
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
            $message = array('status'=>'1', 'message'=>'Salons Found at your location', 'data'=>$pr);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
                  
   

}
    

  public function services(Request $request)
    {
          $lat = $request->lat;
       $lng = $request->lng;
    
        $seachstring= $request->searchstring;
     $lang = $request->lang;
    if($lang != NULL){
        $product = DB::table('service')
                   ->join('vendor','service.vendor_id','=','vendor.vendor_id')
                    ->select('service.'.$lang.'_service_name as service_name','service.service_image','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('vendor.online_status','ON')
                  ->where('vendor.admin_approval',1)
                  ->where('service.service_name', 'like', $seachstring.'%')
                  ->paginate(5);
    }else{
       $product = DB::table('service')
                   ->join('vendor','service.vendor_id','=','vendor.vendor_id')
                    ->select('service.service_name','service.service_image','vendor.delivery_range',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('vendor.online_status','ON')
                  ->where('vendor.admin_approval',1)
                  ->where('service.service_name', 'like', $seachstring.'%')
                  ->paginate(5); 
    }    
       
             
     
           $nearbystore = $product->unique('service_name');        
          
       
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = array('service_name'=>$store->service_name, 'service_image'=>$store->service_image); 
            }
            
        } 
         if($pr != NULL){ 
            $message = array('status'=>'1', 'message'=>'Services Found at your location', 'data'=>$pr);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
                  
        
    }
    
     public function getnearbanner(Request $request)
    {
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
                  ->paginate(5);
      $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store->vendor_id; 
            }
            
        }
        if($pr != NULL){ 
          
            $banner = DB::table('admin_banner')
                   ->whereIn('vendor_id', $pr)
                   ->get();
            $message = array('status'=>'1', 'message'=>'Banners List', 'data'=>$banner);
            return $message;
           }
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
                  
    }
    
    
    
      public function popular_barber(Request $request)
    {
        $lat = $request->lat;
       $lng = $request->lng;
       $seachstring= $request->searchstring;
        $product = DB::table('staff_profile')
                   ->join('vendor','staff_profile.vendor_id','=','vendor.vendor_id')
                    ->select('vendor.vendor_id','vendor.vendor_name','vendor.vendor_logo','vendor.delivery_range','vendor.owner','staff_profile.staff_id','staff_profile.staff_name','staff_profile.staff_image',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(vendor.lat)) 
                    * cos(radians(vendor.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor.lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('vendor.online_status','ON')
                  ->where('vendor.admin_approval',1)
                  ->where('staff_profile.staff_name', 'like', $seachstring.'%')
                  ->paginate(5);
             
     
           $nearbystore = $product->unique('staff_id');        
          
       
          $pr = NULL;
        foreach($nearbystore as $store)
        {
            if($store->delivery_range >= $store->distance)  {  
           
                $pr[] = $store; 
            }
            
        } 
         if($pr != NULL){ 
            $message = array('status'=>'1', 'message'=>'Popular Barbers Found at your location', 'data'=>$pr);
            return $message;
           }
       
    
           else{
                $message = array('status'=>'0', 'message'=>'No Salons registered at your location');
            return $message;
           }
                  
    }
    
    
  
}