<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;

class FavouriteController extends Controller
{
   use SendMail; 
   use SendSms;
   public function add_to_favourites(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $product_id = $request->product_id;
        $ven = DB::table('shop_product')
            ->where('id',$product_id)
            ->first();
        $vendor_id = $ven->vendor_id;    
        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
        
    
        $p = DB::table('shop_product')
           ->where('id',$product_id)
           ->first();
      
      $price = $p->price;
        $price2= $price;
     
       $var_image = $p->product_image;
        $n =$p->product_name;
         $ar_n =$p->ar_product_name;
      
        $check = DB::table('wishlist')
            ->where('product_id',$product_id)
            ->where('user_id', $user_id)
            ->first();
      
     if(!$check){

        $insert = DB::table('wishlist')
                ->insertGetId([
                        'vendor_id' => $vendor_id,
                        'product_id'=>$product_id,
                        'product_name'=>$n,
                        'product_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'description'=>$p->description,
                        'user_id'=>$user_id,
                        'created_at'=>$created_at,
                        'updated_at'=>$created_at,
                        'price'=>$price2]);
                        
  if($insert){
        $lang=DB::table('langs')
           ->get();
        foreach($lang as $langs){
          $l_p = $langs->lang_prefix;
          $des1=$l_p.'_description';
          $name=$l_p.'_product_name';
          $des=$p->$des1;
          $p_name=$p->$name;
           $insert1 = DB::table('wishlist')
                ->where('wish_id',$insert)
                ->update([$l_p.'_product_name'=>$p_name,
                $l_p.'_description'=>$des]);
      }
      $count = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->count();
        $items = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->get();
            
            $data = array('fav_count'=>$count,'fav_items'=>$items);
        	$message = array('status'=>'1', 'message'=>'Added to Favourites', 'data'=>$data);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Something Wents Wrong');
        	return $message;
        }
      
     }
     else{
          $del = DB::table('wishlist')
            ->where('product_id',$product_id)
            ->where('user_id', $user_id)
            ->delete();
            
         if($del){
          $count = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->count();
        $items = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->get();
     if($count>0){       
        $data = array('fav_count'=>$count,'fav_items'=>$items);
        	$message = array('status'=>'1', 'message'=>'Removed from Favourites', 'data'=>$data);
        	return $message;
     }else{
         $message = array('status'=>'0', 'message'=>'Removed from Favourites');
        	return $message;
     }
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Something Wents Wrong');
        	return $message;
        }  
         
     }

 }
 
 
   public function show_fav(Request $request)
    { 
        $user_id= $request->user_id;
        $lang=$request->lang;
      if($lang != NULL){
         $wishlist_item = DB::table('wishlist')
                   ->join('shop_product','wishlist.product_id','=','shop_product.id')
                   ->join('vendor','wishlist.vendor_id','=','vendor.vendor_id')
                    ->select('shop_product.'.$lang.'_product_name as product_name','shop_product.quantity','shop_product.id','shop_product.price','shop_product.product_image','shop_product.'.$lang.'_description as description','shop_product.vendor_id','shop_product.created_at','shop_product.updated_at','vendor.vendor_name','vendor.delivery_range','wishlist.wish_id')
                  ->where('vendor.online_status','ON')
                   ->where('vendor.admin_approval',1)
                   ->where('wishlist.user_id',$user_id)
                  ->get();
      }else{
            $wishlist_item = DB::table('wishlist')
                   ->join('shop_product','wishlist.product_id','=','shop_product.id')
                   ->join('vendor','wishlist.vendor_id','=','vendor.vendor_id')
                    ->select('shop_product.product_name','shop_product.quantity','shop_product.id','shop_product.price','shop_product.product_image','shop_product.description','shop_product.vendor_id','shop_product.created_at','shop_product.updated_at','vendor.vendor_name','vendor.delivery_range','wishlist.wish_id')
                  ->where('vendor.online_status','ON')
                   ->where('vendor.admin_approval',1)
                   ->where('wishlist.user_id',$user_id)
                  ->get();
      }          
                  
         if(count($wishlist_item)>0){ 
             $result =array();
            $i = 0;
           $j=0;
            foreach ($wishlist_item as $cats) {
                
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
             $count = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->count();    
             $data = array('fav_count'=>$count,'fav_items'=>$wishlist_item);
        	$message = array('status'=>'1', 'message'=>'Favourites List', 'data'=>$data);
        	return $message;   
         }
        else{
        	$message = array('status'=>'0', 'message'=>'Nothing in Favourites');
        	return $message;
        }
        }

}