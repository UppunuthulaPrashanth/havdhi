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
class CartController extends Controller
{
   use SendMail;
   use SendSms;
   use SendInapp;

   public function add_to_cart(Request $request)
    {
        $current = Carbon::now();
        $user_id= $request->user_id;
        $qty = $request->qty;
        $product_id = $request->product_id;
         $p = DB::table('shop_product')
           ->where('id',$product_id)
           ->first();
        $check = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('vendor_id', $p->vendor_id)
            ->where('status', "incart")
            ->first();
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

        if($check){
           $cart_id=$check->order_cart_id;
        }else{
           $cart_id = $val.$val2.$cr;
        }
        $order_status = "incart";


        $cart_items = DB::table('product_order_details')
                    ->where('user_id',$user_id)
                    ->where('status', 'incart')
                    ->first();



        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone')
                  ->where('id',$user_id)
                  ->first();
        if(!$ph){
            $message = array('status'=>'0', 'message'=>'User not Found');
        	return $message;
        }
        $user_phone = $ph->user_phone;





       $price = $p->price;
        $price2= $price*$qty;

       $var_image = $p->product_image;
        $n =$p->product_name;

        $check = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('product_id',$product_id)
            ->where('status', "incart")
            ->first();

     if(!$check){

        $insert = DB::table('product_order_details')
                ->insertGetId([
                        'vendor_id' => $p->vendor_id,
                        'product_id'=>$product_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'product_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'user_id'=>$user_id,
                        'order_cart_id'=>$cart_id,
                        'total_price'=>$price2,
                        'status'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price,
                        'description'=>$p->description]);

     }
     else{
          $del = DB::table('product_order_details')
          ->where('user_id',$user_id)
            ->where('product_id',$product_id)
            ->where('status', "incart")
            ->delete();

         $insert = DB::table('product_order_details')
                ->insertGetId([
                        'vendor_id' => $p->vendor_id,
                        'product_id'=>$product_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'product_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'user_id'=>$user_id,
                        'order_cart_id'=>$cart_id,
                        'total_price'=>$price2,
                        'status'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price,
                        'description'=>$p->description]);

     }


  $checkitems = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->get();
  if($insert){
      $lang=DB::table('langs')
           ->get();
        foreach($lang as $langs){
          $l_p = $langs->lang_prefix;
          $des1=$l_p.'_description';
          $name=$l_p.'_product_name';
          $des=$p->$des1;
          $p_name=$p->$name;
           $insert1 = DB::table('product_order_details')
                ->where('store_order_id',$insert)
                ->update([$l_p.'_product_name'=>$p_name,
                $l_p.'_description'=>$des]);
      }
      $del = DB::table('product_order_details')
          ->where('user_id',$user_id)
             ->where('qty', 0)
            ->where('status', "incart")
            ->delete();

      $sum = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->select(DB::raw('SUM(product_order_details.total_price) as total_price'))
            ->first();
    $data = array('total_price'=>$sum->total_price,'cart_items'=>$checkitems);


        	$message = array('status'=>'1', 'message'=>'Cart Updated', 'data'=>$data);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed');
        	return $message;
        }


 }




  public function cart_checkout(Request $request)
    {
        $current = Carbon::now();
        $user_id= $request->user_id;
        $lang = $request->lang;
        if($lang!=NULL){
        $incart = DB::table('product_order_details')
                ->select('store_order_id',$lang.'_product_name as product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status',$lang.'_description as description','vendor_id')
                ->where('user_id',$user_id)
                ->where('status','incart')
                ->get();
        }else{
            $incart = DB::table('product_order_details')
             ->select('store_order_id','product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status','description','vendor_id')
                ->where('user_id',$user_id)
                ->where('status','incart')
                ->get();
        }
        $cart = DB::table('product_order_details')
                ->where('user_id',$user_id)
                ->where('status','incart')
                ->first();
        if($cart){
        $cart_id = $cart->order_cart_id;
        }else{
          $message = array('status'=>'0', 'message'=>'No Items in cart');
        	return $message;
        }
        $price=0;
        foreach($incart as $in){
            $price+=$in->total_price;
        }
        $payment_gateway = $request->payment_gateway;
        $payment_status = $request->payment_status;
        $payment_id = $request->payment_id;

        if($payment_status == "COD" || $payment_gateway == "COD"){
            $payment_id="COD";
        }

   if(count($incart)>0){
       if($payment_status == 'success' || $payment_status == 'COD'){
            $add= DB::table('product_order')
                ->insert(['user_id'=>$user_id,
                'payment_gateway'=>$payment_gateway,
                'payment_status'=>$payment_status,
                'payment_id'=>$payment_id,
                'total_price'=>$price,
                'cart_id'=>$cart_id,
                'created_at'=>$current]);
            if($add){
                $update=DB::table('product_order_details')
                ->where('order_cart_id',$cart_id)
                ->update(['status'=>1]);
            }
            $checkitemss = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->count();
            $ordersuccessed = DB::table('product_order')
                ->where('cart_id',$cart_id)
                ->first();

            $data=array('order'=>$ordersuccessed,
                         'cart_count'=>$checkitemss);

              $orderplacedmsgstore = $this->ordersuccessfull($cart_id,$user_id);

                     $codorderplacedstore = $this->orderplacedinapp($cart_id,$user_id);

        	$message = array('status'=>'1', 'message'=>'Cart checkout successfully', 'data'=>$data );
        	return $message;
       }else{
           $add= DB::table('product_order')
                ->insert(['user_id'=>$user_id,
                'payment_gateway'=>$payment_gateway,
                'payment_status'=>'failed',
                'payment_id'=>$payment_id,
                'total_price'=>$price,
                'cart_id'=>$cart_id,
                'created_at'=>$current,
                 'status'=>3]);
            if($add){
                $update=DB::table('product_order_details')
                ->where('order_cart_id',$cart_id)
                ->update(['status'=>3]);
            }


            $checkitemss = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->count();
            $ordersuccessed = DB::table('product_order')
                ->where('cart_id',$cart_id)
                ->first();

            $data=array('order'=>$ordersuccessed,
                         'cart_count'=>$checkitemss);
        	$message = array('status'=>'2', 'message'=>'Transaction Failed', 'data'=>$data );
        	return $message;
       }
        }
        else{
        	$message = array('status'=>'0', 'message'=>'No Items in cart');
        	return $message;
        }

 }

   public function show_cart(Request $request)
    {
        $user_id= $request->user_id;

         $lang = $request->lang;
        if($lang!=NULL){
        $checkitems = DB::table('product_order_details')
                ->select('store_order_id',$lang.'_product_name as product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status',$lang.'_description as description','vendor_id')
                ->where('user_id',$user_id)
                ->where('status','incart')
                ->get();
        }else{
            $checkitems = DB::table('product_order_details')
             ->select('store_order_id','product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status','description','vendor_id')
                ->where('user_id',$user_id)
                ->where('status','incart')
                ->get();
        }
        if(count($checkitems)>0){

        $sum = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->select(DB::raw('SUM(product_order_details.total_price) as total_price'))
            ->first();
         $data = array('total_price'=>$sum->total_price,'cart_items'=>$checkitems);

            $message = array('status'=>'1', 'message'=>'cart_items', 'data'=>$data );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'No Items in cart');
        	return $message;
        }
        }

  public function del_frm_cart(Request $request)
    {
        $user_id= $request->user_id;
        $varient_id = $request->product_id;
        $cart_items = DB::table('product_order_details')
                    ->where('user_id',$user_id)
                   ->where('status', "incart")
                    ->where('product_id', $varient_id)
                    ->delete();


        if($cart_items){
            $cart_items2 = DB::table('product_order_details')
                    ->where('user_id',$user_id)
                    ->where('status', 'incart')
                    ->get();
             $sum = DB::table('product_order_details')
            ->where('user_id',$user_id)
            ->where('status', "incart")
            ->select(DB::raw('SUM(product_order_details.total_price) as total_price'))
            ->first();
           $data = array('total_price'=>$sum->total_price,'cart_items'=>$cart_items2);

            $message = array('status'=>'1', 'message'=>'Product has been removed from cart','data'=>$data);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Please try again');
        	return $message;
        }
        }




     public function clear_cart(Request $request)
    {
        $user_id= $request->user_id;
        $cart_items = DB::table('product_order_details')
                    ->where('user_id',$user_id)
                    ->where('status', 'incart')
                    ->delete();


        if ($cart_items){
            $message = array('status'=>'1', 'message'=>'your cart has been cleared.');
        	return $message;

        }
        else{
             $message = array('status'=>'0', 'message'=>'nothing in cart');
        	return $message;
        }
        }


      public function ongoing(Request $request)
    {
      $user_id = $request->user_id;
      $lang=$request->lang;
      $ongoing = DB::table('product_order')
              ->where('user_id',$user_id)
              ->where('status', '!=', NULL)
              ->where('payment_gateway', '!=', NULL)
               ->get();

    if(count($ongoing)>0){
            $result =array();
            $i = 0;

            foreach ($ongoing as $ons) {
                array_push($result, $ons);

                $apps = array($ons->cart_id);
                 $countpro = DB::table('product_order_details')
                    ->where('product_order_details.order_cart_id', $ons->cart_id)
                        ->count();


                $app = DB::table('product_order_details')
                        ->join('vendor','product_order_details.vendor_id','=','vendor.vendor_id')
                        ->select('vendor.vendor_id','vendor.vendor_name','vendor.owner','vendor.vendor_email','vendor.vendor_phone','vendor.vendor_logo','vendor.vendor_loc','vendor.lat','vendor.lng','vendor.description','vendor.online_status', DB::raw('count(product_order_details.store_order_id) as vendor_product_count'))
                        ->groupBy('vendor.vendor_id','vendor.vendor_name','vendor.owner','vendor.vendor_email','vendor.vendor_phone','vendor.vendor_logo','vendor.vendor_loc','vendor.lat','vendor.lng','vendor.description','vendor.online_status')
                        ->whereIn('product_order_details.order_cart_id', $apps)
                        ->get();
                 $ven = $app->unique('vendor_id');
                  $result[$i]->count = $countpro;
                $result[$i]->vendor = $ven;
                $i++;
                $res =array();
                $j = 0;
                foreach ($ven as $appss) {
                    array_push($res, $appss);
                    $c = array($appss->vendor_id);
                if($lang != NULL){
                    $app1 = DB::table('product_order_details')
                            ->select('store_order_id',$lang.'_product_name as product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status',$lang.'_description as description','vendor_id')
                            ->whereIn('vendor_id', $c)
                            ->whereIn('order_cart_id',$apps)
                            ->get();
                }else{
                    $app1 = DB::table('product_order_details')
                            ->select('store_order_id','product_name','quantity','product_id','qty','price','total_price','order_cart_id','order_date','product_image','user_id','status','description','vendor_id')
                            ->whereIn('vendor_id', $c)
                            ->whereIn('order_cart_id',$apps)
                            ->get();
                }
                if(count($app1)>0){

                    $res[$j]->products = $app1;
                    $j++;
                   }
                   else{
                     $res[$j]->products = [];
                    $j++;
                   }
                 }

            }

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$ongoing);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found');
            return $message;
        }



  }






  public function delete_order(Request $request)
  {
      $cart_id = $request->cart_id;
       $user = DB::table('product_order')
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
      $order = DB::table('product_order')
                  ->where('cart_id', $cart_id)
                  ->update([
                        'cancelling_reason'=>$reason,
                        'status'=>$order_status,
                        'updated_at'=>$updated_at]);

       if($order){
        if($user->payment_gateway == 'COD' || $user->payment_gateway == 'Cod' || $user->payment_gateway == 'cod'){
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
