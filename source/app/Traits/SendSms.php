<?php

namespace App\Traits;
use DB;
use Twilio\Rest\Client;

trait SendSms {

    private $url_path = "https://control.msg91.com/api/sendhttp.php";

    public function bookingsuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone)
    {
        $getInvitationMsg = "Booking Successfully Placed: Your booking cart id #".$cart_id." contains of " .$prod_name." of price rs ".$price2. " has been booked Successfully for ".$delivery_date."(".$time_slot.").";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url = $this->url_path;
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
    ///product order
     public function ordersuccessfull($cart_id,$user_id)
    {
         $getDevice = DB::table('users')
                         ->where('id', $user_id)
                        ->select('device_id','name','user_phone')
                        ->first();
        $user_phone = $getDevice->user_phone; 
        $getInvitationMsg = "Order Successfully Placed: Your order with cart id #".$cart_id." has been placed Successfully Please pickup it from Vendor(s) ASAP";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url = $this->url_path;
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    //to store//
    public function ordersuccessfullstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$store_phone)
    {
        $getInvitationMsg = "You got a Booking: You got a booking cart id #".$cart_id." contains of " .$prod_name." of price rs ".$price2. " for ".$delivery_date."(".$time_slot.").";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $store_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url = $this->url_path;
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $store_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
     public function order_completed_sms($cart_id,$user_id)
    {
         $getDevice = DB::table('users')
                         ->where('id', $user_id)
                        ->select('device_id','name','user_phone')
                        ->first();
        $user_phone = $getDevice->user_phone; 
        $getInvitationMsg = "Order Successfully Placed: Your order with cart id #".$cart_id." has been completed Successfully Please pickup it from Vendor(s) ASAP";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url = $this->url_path;
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
  
    
}