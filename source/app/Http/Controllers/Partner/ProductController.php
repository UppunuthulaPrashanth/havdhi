<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;
use App\Traits\SendMail;
use App\ShopProduct;

class ProductController extends Controller
{
	use SendMail;

    public function product_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required'
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        $vendor_id = $request->vendor_id;
        
		$product = ShopProduct::where('vendor_id',$vendor_id)->get();
    	if(count($product)>0){
    		$message = array('status'=>'1', 'message'=>'Product list', 'data'=>$product);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Product list');
	        return $message;
    	}
     }
    
	public function product_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'vendor_id' => 'required',
            'product_image' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        $product = new ShopProduct;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->created_at = date('d-m-Y h:i a');
        $product->vendor_id = $request->vendor_id;

        $product->product_image = 'N/A';

        $date = date('d-m-Y');
		if($request->hasFile('product_image')){
            $service_image = $request->product_image;
            $fileName = date('dmyhisa').'-'.$service_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $service_image->move('product/images/'.$date.'/', $fileName);
            $service_image = 'product/images/'.$date.'/'.$fileName;
            $product->product_image = $service_image;
		}

        if($product->save()){
            
     $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_product_name';
                $t_product_name=$request->$tec; 
                if($t_product_name== NULL){
                    $t_product_name=$request->product_name;
                }
                 $tec2 = $langs->lang_prefix.'_description';
                 
                $t_des=$request->$tec2; 
                if($t_des== NULL){
                    $t_des= $request->description;
                }
                   $update2 = DB::table('shop_product')
                ->where('id',$product->id)
                  ->update([$langs->lang_prefix.'_product_name'=>$t_product_name,$langs->lang_prefix.'_description'=>$t_des]);   
                   }			
         
            $message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$product);
            return $message;	
        }else{
            $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
            return $message;	  
        }
    }

	public function product_edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'vendor_id' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        $product = ShopProduct::where('id',$request->product_id)->first();
        if(!$product){
            $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
            return $message;	  
        }
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->created_at = date('d-m-Y h:i a');
        $product->vendor_id = $request->vendor_id;

        $date = date('d-m-Y');
		if($request->hasFile('product_image')){
            $service_image = $request->product_image;
            $fileName = date('dmyhisa').'-'.$service_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $service_image->move('product/images/'.$date.'/', $fileName);
            $service_image = 'product/images/'.$date.'/'.$fileName;
            $product->product_image = $service_image;
		}

        if($product->save()){
             $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_product_name';
                $t_product_name=$request->$tec; 
                if($t_product_name== NULL){
                    $t_product_name=$request->product_name;
                }
                 $tec2 = $langs->lang_prefix.'_description';
               
                $t_des=$request->$tec2; 
                  if($t_des== NULL){
                    $t_des= $request->description;
                }
                   $update2 = DB::table('shop_product')
                ->where('id',$request->product_id)
                  ->update([$langs->lang_prefix.'_product_name'=>$t_product_name,$langs->lang_prefix.'_description'=>$t_des]);   
                   }
            $message = array('status'=>'1', 'message'=>'Updated successfully', 'data'=>$product);
            return $message;	
        }else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }

    }   

	public function product_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required'
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        $product = ShopProduct::where('id',$request->product_id)->first();
        if($product){
            $product->delete();
            $message = array('status'=>'1', 'message'=>'Deleted successfully');
            return $message;	
        } else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    }   



}
