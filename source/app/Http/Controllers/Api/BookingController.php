<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Setting;
use Razorpay\Api\Api;
use App\Traits\SendMail;
use App\Traits\SendSms;
use App\Traits\SendInapp;

class BookingController extends Controller
{
   use SendMail;
   use SendSms;
   use SendInapp;
   public function book_now(Request $request)
    {
        $current = Carbon::now();
        $data= json_encode($request->order_array);
        $data_array = json_decode($data);
        $user_id= $request->user_id;
        $user_detail = DB::table('users')
                    ->where('id', $user_id)
                    ->first();

        if($user_detail->block==1){
            $message = array('status'=>'0', 'message'=>'You are blocked by admin you cannot book services.');
        	return $message;
        }
        $booking_date = $request-> delivery_date;
        $time_slot= $request->time_slot;
        $vendor_id = $request->vendor_id;
        $staff_id = $request->staff_id;
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $val = "";
                for ($i = 0; $i < 4; $i++){
                    $val .= $chars[mt_rand(0, strlen($chars)-1)];
                }

        $chars2 = "0123456789";
                $val2 = "";
                for ($i = 0; $i < 2; $i++){
                    $val2 .= $chars2[mt_rand(0, strlen($chars2)-1)];
                }
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;

        $created_at = Carbon::now();
        $user_id= $request->user_id;
        $price2=0;
        $price5=0;
        $ph = DB::table('users')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
       $delete = DB::table('order_cart')
               ->where('status', 0)
                ->where('user_id',$user_id)
                ->delete();

    foreach ($data_array as $h){
        $varient_id = $h->varient_id;
         $p =  DB::table('service_varient')
           ->where('varient_id',$varient_id)
           ->where('vendor_id',$vendor_id)
           ->first();

        $price = $p->price;
        $order_qty = 1;
        $price2+= $price*$order_qty;
        $p_name[] = $p->service_name."(".$p->varient.")";
        $prod_name = implode(',',$p_name);
        $n =$p->service_name;
        $varient = $p->varient;
        $varient_id = $p->varient_id;
        $service_id = $p->service_id;
        $lang=DB::table('langs')
             ->get();

        $insert = DB::table('order_cart')
                ->insertGetId([
                        'varient_id'=>$varient_id,
                        'service_id'=>$service_id,
                        'service_name'=>$n,
                        'varient'=>$varient,
                        'user_id'=>$user_id,
                        'vendor_id'=>$vendor_id,
                        'status'=>0,
                        'cart_id'=>$cart_id,
                        'price'=>$price,
                        'created_at'=>$created_at]);
                 }



  if($insert){
      foreach($lang as $langs){
          $l_p = $langs->lang_prefix;
          $varient1=$l_p.'_varient';
          $name=$l_p.'_service_name';
          $var_name=$p->$varient1;
          $ser_name=$p->$name;
           $insert1 = DB::table('order_cart')
                ->where('order_cart_id',$insert)
                ->update([$l_p.'_service_name'=>$ser_name,
                $l_p.'_varient'=>$var_name]);
      }
        $oo = DB::table('orders')
            ->insertGetId(['cart_id'=>$cart_id,
            'total_price'=>$price2,
            'staff_id'=>$staff_id,
            'vendor_id'=>$vendor_id,
            'user_id'=>$user_id,
            'rem_price'=>$price2,
            'service_date'=> $booking_date,
            'mobile'=>$user_detail->user_phone,
            'service_time'=>$time_slot,
            'order_status'=>0]);

           $ordersuccessed = DB::table('orders')
                           ->where('id',$oo)
                           ->first();
        	$message = array('status'=>'1', 'message'=>'Proceed to Checkout', 'data'=>$ordersuccessed );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'failed! Try again later');
        	return $message;
        }

 }


 public function checkout(Request $request)
    {
        $cart_id=$request->cart_id;
        $lang=$request->lang;

        $payment_method= $request->payment_method;
        $payment_status = $request->payment_status;
        $payment_id = $request->payment_id;
        $payment_gateway = $request->payment_gateway;

         $cart =  DB::table('orders')
           ->where('cart_id', $cart_id)
           ->first();
        $vendor_id = $cart->vendor_id;
         $getD = DB::table('vendor')
                ->where('vendor_id', $vendor_id)
                ->first();

       $store_n = $getD->vendor_name;
        $user_id= $cart->user_id;
        $delivery_date = $cart->service_date;
        $time_slot= $cart->service_time;

        $var= DB::table('order_cart')
           ->where('cart_id', $cart_id)
           ->get();
        $price2 = $cart->rem_price;
        $ph = DB::table('users')
                  ->select('name','user_phone','rewards')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
        $user_name = $ph->name;
        foreach ($var as $h){
        $varient_id = $h->varient_id;

        $price = $h->price;
         if($lang != NULL){
             $na =$lang.'_service_name';
             $ser_name = $h->$na;
             $v=$lang.'_varient';
             $v_name = $h->$v;
         }else{
            $ser_name =$h->service_name;
             $v_name =$h->varient;
         }
        $p_name[] = $ser_name."(".$v_name.")";
        $prod_name = implode(',',$p_name);
        }
         $charge = 0;
         $prii = $price2;
        if ($payment_method == 'COD' || $payment_method =='cod'){


             $payment_status="COD";
             $rem_amount=  $prii;

          $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'rem_price'=>$rem_amount,
            'payment_status'=>$payment_status,
            'payment_method'=>$payment_method,
            'status'=>1,
             'payment_gateway'=>$payment_gateway
            ]);


            $orderplacedmsg = $this->bookingsuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone);

             $q = DB::table('users')
                              ->select('email','name','device_id')
                              ->where('id',$user_id)
                              ->first();
            $user_email = $q->email;
            $device_id = $q->device_id;
            $user_name = $q->name;


                  $codorderplaced = $this->codorderplacedinapp($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$user_id,$device_id);



        $orderr1 = DB::table('orders')
                       ->where('cart_id', $cart_id)
                       ->first();

                ///////send notification to store//////

             if($getD){

                   $store_phone = $getD->vendor_phone;
                   $vendor_email = $getD->vendor_email;
                     $orderplacedmsgstore = $this->ordersuccessfullstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$store_phone);

                      $codorderplacedstore = $this->codorderplacedinappstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_name,$vendor_id);
                 }
            $delete = DB::table('order_cart')
                           ->where('cart_id', $cart_id)
                           ->update(['status'=>1]);
            $message = array('status'=>'1', 'message'=>'Booking Placed successfully', 'data'=>$cart );
            return $message;
        }

        else{

        $prii = $price2;

              $rem_amount=  $prii;
        if($payment_status=='success'){


            $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'rem_price'=>$rem_amount,
            'payment_method'=>$payment_method,
            'payment_status'=>'success',
            'status'=>1,
             'payment_gateway'=>$payment_gateway,
             'payment_id'=>$payment_id
            ]);

    /////send sms/////
      $codorderplaced = $this->bookingsuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone);


             $q = DB::table('users')
                  ->select('email','name')
                  ->where('id',$user_id)
                  ->first();
            $user_email = $q->email;
            $user_name = $q->name;


           $store_n = $getD->vendor_name;




         $delete = DB::table('order_cart')
                           ->where('cart_id', $cart_id)
                           ->update(['status'=>1]);
         if($getD){
                     $store_phone = $getD->vendor_phone;
                     $vendor_email = $getD->vendor_email;
                     $orderplacedmsgstore = $this->ordersuccessfullstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$store_phone);


                     $codorderplacedstore = $this->codorderplacedinappstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_name,$vendor_id);
                 }
            $message = array('status'=>'1', 'message'=>'Booking Placed successfully', 'data'=>$cart );
            return $message;
         }
         else{
              $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'rem_price'=>$rem_amount,
            'payment_method'=>$payment_method,
            'status'=>3,
            'payment_status'=>'failed',
             'payment_gateway'=>$payment_gateway,
             'payment_id'=>$payment_id
            ]);
            $message = array('status'=>'0', 'message'=>'Payment Failed');
            return $message;
         }
      }
    }




      public function vendor_desc(Request $request)
    {
        $vendor_id = $request->vendor_id;
       $lang=$request->lang;
       if($lang != NULL){
        $description = DB::table('vendor')
                     ->select($lang.'_description as description','shop_type','vendor_name','vendor_id','owner','vendor_logo','vendor_loc')
                     ->where('vendor_id', $vendor_id)
                     ->first();
       }else{
           $description = DB::table('vendor')
                      ->select('description','shop_type','vendor_name','vendor_id','owner','vendor_logo','vendor_loc')
                     ->where('vendor_id', $vendor_id)
                     ->first();
       }

       $rating = DB::table('review')
              ->where('vendor_id', $vendor_id)
                     ->avg('rating');
        $barber = DB::table('staff_profile')
                  ->join('orders','staff_profile.staff_id','=','orders.staff_id')
                 ->select('staff_profile.staff_id','staff_profile.staff_name','staff_profile.staff_image', DB::raw('count(orders.id) as count'))
                 ->groupBy('staff_profile.staff_id','staff_profile.staff_name','staff_profile.staff_image')
                 ->where('staff_profile.vendor_id',$vendor_id)
                 ->orderBy('count', 'ASC')
                  ->get();
          if(!empty($barber)){
             $barber = DB::table('staff_profile')
                 ->where('vendor_id',$vendor_id)
                 ->orderBy('staff_id', 'ASC')
                  ->get();
          }

        $staff =   DB::table('staff_profile')
                 ->join('orders','staff_profile.staff_id','=','orders.staff_id')
                 ->select('staff_profile.staff_id', DB::raw('count(orders.id) as count'))
                 ->groupBy('staff_profile.staff_id')
                 ->where('staff_profile.vendor_id',$vendor_id)
                 ->orderBy('count', 'ASC')
                  ->first();
          if(!$staff){
              $staff =   DB::table('staff_profile')
                 ->where('vendor_id',$vendor_id)
                 ->orderBy('staff_id', 'ASC')
                  ->first();
          }
        $staff_id1= $staff->staff_id;
        $current_time = Carbon::Now();
    $date = date('Y-m-d');

    $staff_id = $staff_id1;
    $orders = 1;
    $duration  = 60;
    $selected_date  = date('Y-m-d');

     $day = date('l', strtotime($selected_date));
       $time_slot = DB::table('time_slot')
               ->where('vendor_id',$vendor_id)
               ->where('days',$day)
               ->first();

    $starttime  = $time_slot->open_hour;
     $endtime  = $time_slot->close_hour;

    $array_of_time = array ();
    $array_of_time1 = array ();
    $min = 10;
    $currenttime = strtotime ("+".$min." minutes", strtotime($current_time));
    $start_time    = strtotime ($starttime); //change to strtotime
    $end_time      = strtotime ($endtime); //change to strtotime

    $add_mins  = $duration * 60;
if(strtotime($date)==strtotime($selected_date)){
    while ($start_time <= $currenttime) // loop between time
    {
       $array_of_time[] = date ("h:i a", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time = array ();
    for($i = 0; $i < count($array_of_time) - 1; $i++)
    {
        $new_array_of_time[] = '' . $array_of_time[$i] . ' - ' . $array_of_time[$i + 1];
    }

$items=last($new_array_of_time);
$numbers = explode('-', $items);
$last_Number = end($numbers);
 $lastNumber    = strtotime ($last_Number);
 if($last_Number!= NULL){
while ($lastNumber <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("h:i a", $lastNumber);
       $lastNumber += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 1; $i < count($array_of_time1) - 1; $i++)
    {
         $totorders = DB::table('orders')
               ->where('service_date',$selected_date)
               ->where('service_time',$array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1])
               ->count();

        if($orders > $totorders){

            $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'true');

        }
        else{

             $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'false');
        }

    }
 }
 else{
     while ($start_time <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("h:i a", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 1; $i < count($array_of_time1) - 1; $i++)
    {
         $totorders = DB::table('orders')
               ->where('service_date',$selected_date)
               ->where('service_time',$array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1])
               ->count();

        if($orders > $totorders){

            $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'true');

        }
        else{

             $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'false');
        }
    }
 }

}



        $product = DB::table('service')
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
       $type= $description->shop_type;

          $data = array(
            'salon_name'=>$description->vendor_name,
            'owner'=>$description->owner,
            'description'=>$description->description,
            'type'=>$type,
            'vendor_logo'=>$description->vendor_logo,
            "vendor_loc"=>$description->vendor_loc,
            'vendor_id'=>$vendor_id,
            'rating'=>round($rating, 0)+0.1,
            'staff_id'=>$staff_id1,
            'barber'=>$barber,
            'services'=>$product,
            'selected_date'=>$selected_date,
            'time_slot'=>$new_array_of_time1

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



     public function ongoing(Request $request)
    {
      $user_id = $request->user_id;
      $lang = $request->lang;
      $ongoing = DB::table('orders')
            ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
            ->join('users','orders.user_id','=','users.id')
            ->join('staff_profile','orders.staff_id','=','staff_profile.staff_id')
              ->where('orders.user_id',$user_id)
              ->where('orders.order_status', '!=', NULL)
              ->where('orders.payment_method', '!=', NULL)
              ->orderBy('orders.id', 'DESC')
               ->get();

      if(count($ongoing)>0){
      foreach($ongoing as $ongoings){
    if($lang != NULL){
        $order = DB::table('order_cart')
            ->select('order_cart_id',$lang.'_service_name as service_name',$lang.'_varient as varient','service_id','varient_id','cart_id','user_id','vendor_id','status','price','created_at')
            ->where('cart_id',$ongoings->cart_id)
            ->get();
    }else{
      $order = DB::table('order_cart')
       ->select('order_cart_id','service_name','varient','service_id','varient_id','cart_id','user_id','vendor_id','status','price','created_at')
            ->where('cart_id',$ongoings->cart_id)
            ->get();
    }
        $vendor_review=DB::table('review')
                      ->select('rating','description')
                      ->where('user_id',$user_id)
                      ->where('vendor_id',$ongoings->vendor_id)
                      ->first();

         $staff_review=DB::table('staff_review')
                       ->select('rating','review_description')
                      ->where('user_id',$user_id)
                      ->where('staff_id',$ongoings->staff_id)
                      ->first();
        $data[]=array('user_name'=>$ongoings->name,'vendor_name'=>$ongoings->vendor_name,'owner'=>$ongoings->owner, 'vendor_phone'=>$ongoings->vendor_phone, 'vendor_email'=>$ongoings->vendor_email, 'vendor_loc'=>$ongoings->vendor_loc ,'vendor_logo'=>$ongoings->vendor_logo, 'service_date'=>$ongoings->service_date, 'service_time'=>$ongoings->service_time,'payment_method'=>$ongoings->payment_method,'payment_status'=>$ongoings->payment_status,'staff_name'=>$ongoings->staff_name, 'cart_id'=>$ongoings->cart_id ,'price'=>$ongoings->total_price,'staff_id'=>$ongoings->staff_id,'rem_price'=>$ongoings->rem_price,'coupon_discount'=>$ongoings->coupon_discount,'reward_discount'=>$ongoings->reward_discount,'status'=>$ongoings->status,'vendor_id'=>$ongoings->vendor_id,'vendor_review'=>$vendor_review, 'staff_review'=>$staff_review,'cart_services'=>$order);
        }
        $message = array('status'=>'1', 'message'=>'All Bookings', "data"=>$data);
          return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'No Bookings Found');
          return $message;
        }



  }




    public function cancel_for(Request $request)
    {
   $cancelfor = DB::table('cancel_for')
                  ->get();

       if($cancelfor){
            $message = array('status'=>'1', 'message'=>'Cancelling reason list', 'data'=>$cancelfor);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'no list found');
            return $message;
        }
  }


  public function delete_order(Request $request)
  {
      $cart_id = $request->cart_id;
       $user = DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();
        $price2=0;
        $ph = DB::table('users')
                  ->select('user_phone','name','id')
                  ->where('id',$user->user_id)
                  ->first();
        $user_id = $ph->id;
        $user_phone = $ph->user_phone;
        $user_name = $ph->name;


      $reason = $request->reason;
      $order_status = '4';
      $updated_at = Carbon::now();
      $order = DB::table('orders')
                  ->where('cart_id', $cart_id)
                  ->update([
                        'cancelling_reason'=>$reason,
                        'status'=>$order_status,
                        'updated_at'=>$updated_at]);

       if($order){
        if($user->payment_method == 'COD' || $user->payment_method == 'Cod' || $user->payment_method == 'cod'){
             $message = array('status'=>'1', 'message'=>'Booking cancelled');
            return $message;
              }
               elseif($user->payment_gateway == "stripe" || $user->payment_gateway == "Stripe" || $user->payment_gateway == "STRIPE"){
                     $stripe_secret =Setting::where('name', 'stripe_secret_key')->select('value')->first();
                     $stripe_publishable_key =Setting::where('name', 'stripe_publishable_key')->select('value')->first();
                    $stripe = new \Stripe\StripeClient(
                      $stripe_secret->value
                    );
                    $stripe->refunds->create([
                      'charge' => $user->payment_id,
                    ]);


        }elseif($user->payment_gateway == "paystack" || $user->payment_gateway == "Paystack" || $user->payment_gateway == "PAYSTACK"){
                    $paystack_public_key =Setting::where('name', 'paystack_public_key')->select('value')->first();
                    $paystack_secret_key =Setting::where('name', 'paystack_secret_key')->select('value')->first();

                                   $url = "https://api.paystack.co/refund";
              $fields = [
                'transaction' =>  $user->payment_id
              ];
              $fields_string = http_build_query($fields);
              $ch = curl_init();
              curl_setopt($ch,CURLOPT_URL, $url);
              curl_setopt($ch,CURLOPT_POST, true);
              curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".$paystack_secret_key,
                "Cache-Control: no-cache",
              ));

              curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);


                   }else{


                     $razorpay_secret =Setting::where('name', 'razorpay_secret_key')->select('value')->first();
                     $razorpay_key =Setting::where('name', 'razorpay_key_id')->select('value')->first();

                    $api = new Api($razorpay_key->value, $razorpay_secret->value);

                    $payment = $api->payment->fetch($user->payment_id);
                    $refund = $payment->refund();


                 }




            $message = array('status'=>'1', 'message'=>'order cancelled');
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something went wrong');
            return $message;
        }


  }
}
