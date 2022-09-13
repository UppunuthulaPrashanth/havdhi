<?php

namespace App\Traits;
use DB;
use Mail;
use App\Users;
use Carbon\Carbon;

trait SendInapp {
    ////for user////
    ///////Order Placed///////
    public function codorderplacedinapp($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$user_id,$device_id) {
        
        $check = DB::table('orders')
               ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
               ->select('vendor.vendor_logo')
               ->where('orders.cart_id',$cart_id)
               ->first();
               
        $notify_image= url('/').'/'.$check->vendor_logo;      
        
                  $notification_title = "Hey ".$user_name.", Your Booking has been placed";
                $notification_text = "Booking Successfully Placed: Your Booking cart id #".$cart_id." contains of " .$prod_name." of price rs ".$price2. " is placed Successfully for ".$delivery_date."(".$time_slot.").";
                
                $date = date('d-m-Y');
        
        
                $getDevice = DB::table('users')
                         ->where('id', $user_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm_key')
                            ->first();
                            
                $getFcmKey = $getFcm->user_app_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                         'image'=>$notify_image,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text,
                     'image'=>$notify_image,
                     'created_at'=>Carbon::now()]);
                    
                $results = json_decode($result);
                }
          }
          ////product order
          public function orderplacedinapp($cart_id,$user_id) {
               $getDevice = DB::table('users')
                         ->where('id', $user_id)
                        ->select('device_id','name')
                        ->first();
                        
                $user_name = $getDevice->name;        
                  $notification_title = "Hey ".$user_name.", Your order has been placed";
                $notification_text = "Order Successfully Placed: Your order with cart id #".$cart_id." has been placed Successfully Please pickup it from Vendor(s) ASAP";
                
                $date = date('d-m-Y');
        
        
               
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm_key')
                            ->first();
                            
                $getFcmKey = $getFcm->user_app_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text,
                     'created_at'=>Carbon::now()]);
                    
                $results = json_decode($result);
                }
          }
          
          //to store//
           public function codorderplacedinappstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_name,$vendor_id) {
                 $getDevice = DB::table('vendor')
                         ->where('vendor_id', $vendor_id)
                        ->select('device_id','vendor_name')
                        ->first();
                  $check = DB::table('orders')
               ->join('users','orders.user_id','=','users.id')
               ->select('users.image')
               ->where('orders.cart_id',$cart_id)
               ->first();
               
             $notify_image= url('/').'/'.$check->image;         
                $user_name =  $getDevice->vendor_name;
                
                  $notification_title = "Hey ".$user_name.", You Got a Booking";
                $notification_text = "You Got a Booking cart id #".$cart_id." contains of " .$prod_name." of price ".$price2. " for ".$delivery_date."(".$time_slot.").";
                
                $date = date('d-m-Y');
        
        
              
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm_key')
                            ->first();
                            
                $getFcmKey = $getFcm->user_app_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'image'=>$notify_image,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
             
                $dd = DB::table('vendor_notification')
                    ->insert(['vendor_id'=>$vendor_id,
                     'not_title'=>$notification_title,
                     'not_message'=>$notification_text, 
                     'image'=>$notify_image,
                     'created_at'=>Carbon::now()]);
                    
                $results = json_decode($result);
                }
          }
    
    //////////confirm Order /////////
     public function orderconfirmedinapp($cart_id,$user_phone,$orr){
                 $user = DB::table('users')
                       ->where('user_phone', $user_phone)
                       ->first();
                  $user_name = $user->name;
                   $check = DB::table('orders')
               ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
               ->select('vendor.vendor_logo')
               ->where('orders.cart_id',$cart_id)
               ->first();
               
        $notify_image= url('/').'/'.$check->vendor_logo; 
                  $notification_title = "Hey ".$user_name.", Your Order is Confirmed";
                $notification_text = "Your Order is confirmed: Your order id #".$cart_id." is confirmed by the store.Please reach on salon location on ".$orr->delivery_date." (".$orr->time_slot.").";
                
                $date = date('d-m-Y');
        
        
                $getDevice = DB::table('users')
                         ->where('id', $orr->user_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm_key')
                            ->where('unique_id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->user_app_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'image'=>$notify_image,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$orr->user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text,
                     'image'=>$notify_image]);
                    
                $results = json_decode($result);
                }
             }

    
     public function order_completed_inapp($order){
                 $user = DB::table('users')
                         ->where('id', $order->user_id)
                        ->select('device_id','name','user_phone')
                        ->first();
                  $user_name = $user->name;
                  
                   $check = DB::table('orders')
               ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
               ->select('vendor.vendor_logo')
               ->where('orders.cart_id',$order->cart_id)
               ->first();
               
        $notify_image= url('/').'/'.$check->vendor_logo; 
                  $notification_title = "Hey ".$user_name.", Your Order is Confirmed";
                $notification_text = "Your Order is Completed: Your order id #".$order->cart_id." is Completed by the Store";
                
                $date = date('d-m-Y');
        
        
                $getDevice = DB::table('users')
                         ->where('id', $order->user_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm_key')
                            ->where('unique_id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->user_app_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'image'=>$notify_image,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$order->user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text]);
                    
                $results = json_decode($result);
                }
             }
    
    
}