<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;
use App\Service;
use App\ServiceVarient;

class ServiceController extends Controller
{

    public function list(Request $request)
    {
		$service = DB::table('service')
		          ->where('vendor_id',$request->vendor_id)
		          ->get();
    	if(count($service)>0){
    		$message = array('status'=>'1', 'message'=>'Service list', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Service list');
	        return $message;
    	}
     }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'service_name' => 'required',
            'service_image' => 'required|image',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $service = new Service;
        $service->service_name = $request->service_name;
        $service->vendor_id = $request->vendor_id;
        $service->created_at = date('Y-m-d H:i:s');

        $service->service_image = 'N/A';

        $date = date('d-m-Y');
		if($request->hasFile('service_image')){
            $service_image = $request->service_image;
            $fileName = date('dmyhisa').'-'.$service_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $service_image->move('service/images/'.$date.'/', $fileName);
            $service_image = 'service/images/'.$date.'/'.$fileName;
            $service->service_image = $service_image;
		}

    	if($service->save()){
    
       $lang=DB::table('langs')
           ->get();
           
           
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_service_name';
                $t_product_name=$request->$tec; 
                if($t_product_name == NULL){
                    $t_product_name= $request->service_name;;
                }
                   $update2 = DB::table('service')
                ->where('service_id',$service->service_id)
                  ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);   
                   }
         
         
          
    		$message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'vendor_id' => 'required',
            'service_name' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $service = Service::where('service_id',$request->service_id)->first();
        if(!$service){
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
        }
        $service->service_name = $request->service_name;
        $service->vendor_id = $request->vendor_id;
        $service->created_at = date('Y-m-d H:i:s');

        $date = date('d-m-Y');
		if($request->hasFile('service_image')){
            $service_image = $request->service_image;
            $fileName = date('dmyhisa').'-'.$service_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $service_image->move('service/images/'.$date.'/', $fileName);
            $service_image = 'service/images/'.$date.'/'.$fileName;
            $service->service_image = $service_image;
		}

    	if($service->save()){
    	     $in = DB::table('service')
                ->where('service_id', $request->service_id)
                ->first();
    	 $lang=DB::table('langs')
           ->get();
      foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_service_name';
                $t_product_name=$request->$tec; 
                if($t_product_name == NULL){
                    $t_product_name= $request->service_name;;
                }
                   $update2 = DB::table('service')
                ->where('service_id',$request->service_id)
                  ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);   
                  
                     $insert1 = DB::table('service_varient')
                ->where('service_id', $request->service_id)
                ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);
                
                 $insert1 = DB::table('order_cart')
                ->where('service_id', $request->service_id)
                ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);
                   }
         
    		$message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $service = Service::where('service_id',$request->service_id)->first();

    	if($service){
    	    $service->varients()->delete();
    	    $service->delete();
    		$message = array('status'=>'1', 'message'=>'Deleted successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }


/*============= Service Variant ======================*/

    public function list_servicevariant(Request $request)
    {
		$service = ServiceVarient::where('service_id',$request->service_id)->get();
    	if(count($service)>0){
    		$message = array('status'=>'1', 'message'=>'Service Variant list', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Service Variant list');
	        return $message;
    	}
     }

    public function add_servicevariant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'vendor_id' => 'required',
            'varient' => 'required',
            'price' => 'required',
            'time' => 'required|numeric',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
         $servicen = Service::where('service_id',$request->service_id)->first();
        $service = new ServiceVarient;
        $service->service_id = $request->service_id;
        $service->vendor_id = $request->vendor_id;
        $service->varient = $request->varient;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->service_name = $servicen->service_name;
        
    	if($service->save()){
    	   $lang=DB::table('langs')
           ->get();
    
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_varient';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$request->varient;
                }
                   $update2 = DB::table('service_varient')
                 ->where('varient_id', $service->varient_id)
                  ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);   
                  
                   $insert1 = DB::table('order_cart')
                ->where('varient_id', $service->varient_id)
                ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);
                   }
         
    		$message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }

    public function edit_servicevariant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'varient_id' => 'required',
            'service_id' => 'required',
            'vendor_id' => 'required',
            'varient' => 'required',
            'price' => 'required',
            'time' => 'required|numeric',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $service = ServiceVarient::where('varient_id',$request->varient_id)->first();
        $service->service_id = $request->service_id;
        $service->vendor_id = $request->vendor_id;
        $service->varient = $request->varient;
        $service->price = $request->price;
        $service->time = $request->time;
    	if($service->save()){
    	     $in = DB::table('service_varient')
                ->where('varient_id', $request->varient_id)
                ->first();
    	    $lang=DB::table('langs')
           ->get();
    
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_varient';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$request->varient;
                }
                   $update2 = DB::table('service_varient')
                 ->where('varient_id', $request->varient_id)
                  ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);   
                  
                   $insert1 = DB::table('order_cart')
                ->where('varient_id', $request->varient_id)
                ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);
                   }
    		$message = array('status'=>'1', 'message'=>'Updated successfully', 'data'=>$service);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }

    public function delete_servicevariant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'varient_id' => 'required',
        ]);
        if ($validator->fails()) {
    		$message = array('status'=>'0', 'message'=>$validator->messages());
	        return $message;
        }
        
        $service = ServiceVarient::where('varient_id',$request->varient_id)->first();

    	if($service){
    	    $service->delete();
    		$message = array('status'=>'1', 'message'=>'Deleted successfully');
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
	        return $message;
    	}
     }


}
