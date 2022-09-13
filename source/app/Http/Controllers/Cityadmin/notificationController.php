<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;


class notificationController extends Controller
{
    public function cityadminNotification(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        
                    $cityadmin=DB::table('cityadmin')
                    ->where('cityadmin_email',$cityadmin_email)
                    ->first();	
           $users = DB::table('users')
             ->select('users.name', 'users.id','users.user_phone')
             ->groupBy('users.name', 'users.id','users.user_phone')
             ->get();  
        return view('cityadmin.send_notification',compact("cityadmin_email","cityadmin","users"));
    }

    public function cityadminNotificationSend(Request $request)
    {
           $this->validate(
            $request,
                [
                'title' => 'required',
                'text' => 'required',
                'image' => 'mimes:jpeg,png,jpg|max:1000',
                ],
                [
                'title.required' => 'Enter notification title.',
                'text.required' => 'Enter notification text.',
                ]
        );
       
        $date = date('d-m-Y');
         $user = $request->user;
        $countuser = count($user);
        $date = date('d-m-Y');
      
            $url_aws=url('/');
           
        if($request->hasFile('image')){
              $image = $request->image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           $image->move('images/notification/'.$date.'/', $fileName);
            $filePath = '/images/notification/'.$date.'/'.$fileName;
             $notify_image = $url_aws.$filePath;
        
        }
        else{
            $notify_image = "N/A";
        }
         

        $notification_title = $request->title;
        $notification_text = $request->text;
        
        $date = date('d-m-Y');
          
        $created_at = Carbon::now();
        
       $getFcm = DB::table('fcm_key')
                    ->where('unique_id', '1')
                    ->first();
                    
        $getFcmKey = $getFcm->user_app_key;
        
          if($countuser >= 600){
              $userin = DB::table('users')
             ->select('users.device_id','users.name','users.id')
             ->get();
          }
          else{
      $userin = DB::table('users')->select('device_id','name','id')
                        ->WhereIn('id', $user)
                        ->get();
          }         
        
        
        

         
        foreach($userin as $us){
        $get_device_id[] = $us;
        }
        $loop =  count(array_chunk($get_device_id,600));  // count array chunk 1000
        $arrayChunk = array_chunk($get_device_id,600);   // devide array in 1000 chunk
        $device_id = array();
        
    
        for($i=0; $i<$loop ;$i++)
        {
            foreach($arrayChunk[$i] as $all_device_id)
            {       
                   
                        $device_id[] =  $all_device_id->device_id;
                        
                                    $insertNotification = DB::table('user_notification')
                                    ->insert([
                                        'user_id'=>$all_device_id->id,
                                        'noti_title'=>$notification_title,
                                         'image'=>$notify_image,
                                        'noti_message'=>$notification_text,
                                      
                                    ]);
            }
             $url = 'https://fcm.googleapis.com/fcm/send';
            $body=$notification_text;
            $customData=$url;
            $json_data = 
                [
                    "registration_ids" => $device_id,
                    "notification" => [
                        "body" => $body,
                        "title" => $notification_title,
                        "image"=>$notify_image
                    ],
                    "data" => [
                        "extra" => $customData
                    ]
                ];
         $data = json_encode($json_data); 
       
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = $getFcmKey;
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        // CURL request to route notification to FCM connection server (provided by Google)
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Oops! FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            unset($device_id); // unset the array value 

        }
        return redirect()->back()->withSuccess('Notification Sent to user Successfully');
        
      
    }
    
    
    
     public function CNotification_to_store(Request $request)
    {
        $cityadmin_email=Session::get('cityadmin');
        
                    $cityadmin=DB::table('cityadmin')
                    ->where('cityadmin_email',$cityadmin_email)
                    ->first();	

        return view('cityadmin.notification_store',compact("cityadmin_email","cityadmin"));
    }

      public function CNotification_to_store_Send(Request $request)
    {
        $this->validate(
            $request,
                [
                    'notification_title' => 'required',
                    'notification_text' => 'required',
                    'category_image' => 'required',

             
                ],
                [
                    'notification_title.required' => 'Enter notification title.',
                    'notification_text.required' => 'Enter notification text.',
                    'category_image.required' => 'Enter Image for Notification',

                ]
        );

           $url_aws=url('/');
           
      $date = date('d-m-Y');
           
        if($request->hasFile('category_image')){
              $image = $request->category_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           $image->move('images/notification/'.$date.'/', $fileName);
            $filePath = '/images/notification/'.$date.'/'.$fileName;
             $notify_image = $url_aws.$filePath;
        
        }
        else{
            $notify_image = "N/A";
        }

        $notification_title = $request->notification_title;
        $notification_text = $request->notification_text;
        
      
          
        $created_at = Carbon::now();
         $cityadmin_email=Session::get('cityadmin');
        
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
    
        $cityadmin_id = $cityadmin->cityadmin_id;

            $getUser = DB::table('vendor')->where('cityadmin_id',$cityadmin_id)
                        ->get();
       $getFcm = DB::table('fcm_key')
                    ->first();
                    
        $getFcmKey = $getFcm->vendor_app_key;
        
          if(count($getUser) >= 600){
             $getUser = DB::table('vendor')->where('cityadmin_id',$cityadmin_id)
                        ->get();
          }
          else{
     $getUser = DB::table('vendor')->where('cityadmin_id',$cityadmin_id)
                        ->get();
          }         

         
        foreach($getUser as $us){
        $get_device_id[] = $us;
        }
        $loop =  count(array_chunk($get_device_id,600));  // count array chunk 1000
        $arrayChunk = array_chunk($get_device_id,600);   // devide array in 1000 chunk
        $device_id = array();
        
    
        for($i=0; $i<$loop ;$i++)
        {
            foreach($arrayChunk[$i] as $all_device_id)
            {       
                   
                        $device_id[] =  $all_device_id->device_id;
                        
                                 
                                    
                                     $insertNotification = DB::table('vendor_notification')
                                    ->insert([
                                        'vendor_id'=>$all_device_id->vendor_id,
                                        'not_title'=>$notification_title,
                                        'not_message'=>$notification_text,
                                        'image'=>$notify_image,
                                    ]);
            }
             $url = 'https://fcm.googleapis.com/fcm/send';
            $body=$notification_text;
            $customData=$url;
            $json_data = 
                [
                    "registration_ids" => $device_id,
                    "notification" => [
                        "body" => $body,
                        "title" => $notification_title,
                        "image"=>$notify_image
                    ],
                    "data" => [
                        "extra" => $customData
                    ]
                ];
         $data = json_encode($json_data); 
       
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = $getFcmKey;
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        // CURL request to route notification to FCM connection server (provided by Google)
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Oops! FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            unset($device_id); // unset the array value 

        }

        return redirect()->back()->withErrors('Notification send to store successfully');
    }
    
    
    
    
    
}   