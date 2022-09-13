<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class ProductController extends Controller
{
    private $product_vendor_id = 'product.vendor_id';
    private $shopproduct_vendor_id = 'shop_product.vendor_id';
    private $vendor_shopproduct_product = 'vendor.shopproduct.product';
    private $login_message = 'please login first';
    

    
    public function shopproduct(Request $request){
		if(Session::has('vendor')){
			$vendor_email = Session::get('vendor');
//			dd($this->shopproduct_vendor_id);
			$vendor = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$product = DB::table('shop_product')->where($this->shopproduct_vendor_id, $vendor->vendor_id)->paginate(10);
			$lang=DB::table('langs')
			     ->get();
			$currency = DB::table('currency')->select('currency_sign')->paginate(10);         
			return view($this->vendor_shopproduct_product,compact("vendor_email","product","vendor","currency","lang"));
		}else{
			return redirect()->route('vendorlogin')->withErrors($this->login_message);
		}
    }
    

    
     public function add_shopproduct(Request $request){
      if(Session::has('vendor')){
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
         $lang=DB::table('langs')
             ->get();
        return view('vendor.shopproduct.addproduct',compact("vendor_email","vendor","lang"));
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    
    
    


    
   public function add_shop_new_product(Request $request){
             $this->validate(
            $request,
                [
                    'product_name'=>'required',
                    'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'price'=>'required',
                    'quantity'=>'required',
                    'product_description'=>'required',

                ],[
                    'product_name.required'=> 'enter product name',
                    'price.required'=>'enter price',
                    'quantity.required'=>'enter varient',
                    'product_description.required'=>'enter description about product',
                    'product_image.required'=>'enter image product'

                ]
        );

         if(Session::has('vendor')){
            $vendor_email=Session::get('vendor');
            $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$vendor_id=$vendor->vendor_id;
			$product_id=$request->id;
			$product_name=$request->product_name;
			$price=$request->price;
			$quantity=$request->quantity;
			$old_product_image=$request->old_product_image;
			$description =$request->product_description;
			$date = date('d-m-Y');
			$created_at=date('d-m-Y h:i a');
			
			$product_image = $request->product_image;
			$fileName = date('dmyhisa').'-'.$product_image->getClientOriginalName();
			$fileName = str_replace(" ", "-", $fileName);
			$product_image->move('product/images/'.$date.'/', $fileName);
			$product_image = 'product/images/'.$date.'/'.$fileName;



			$insert = DB::table('shop_product')->insertGetId([
														'product_name'=>$product_name,
														'product_image'=>$product_image,
														'created_at'=>$created_at,
														'vendor_id'=>$vendor_id,
														'price'=>$price,
														'quantity'=>$quantity,
														'description'=>$description,
													]);
     if($insert){
   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_product_name';
                $t_product_name=$request->$tec; 
                if($t_product_name== NULL){
                    $t_product_name=$product_name;
                }
                 $tec2 = $langs->lang_prefix.'_description';
                 if($tec2== NULL){
                    $tec2=$description;
                }
                $t_des=$request->$tec2; 
                   $update2 = DB::table('shop_product')
                ->where('id',$insert)
                  ->update([$langs->lang_prefix.'_product_name'=>$t_product_name,$langs->lang_prefix.'_description'=>$t_des]);   
                   }			
         
        

         return back()->withErrors('successfully added');
     } else{
     return redirect()->back()->withErrors('something went wrong');
     }
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    



    public function shop_edit_product(Request $request){
		if(Session::has('vendor')){
			$product_id=$request->product_id;
			$vendor_email=Session::get('vendor');
			$vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$product = DB::table('shop_product')->where('id',$product_id)->first();
              $lang=DB::table('langs')
            ->get();
			return view('vendor.shopproduct.Editproduct',compact("vendor_email","vendor","product","product_id","lang"));
		}else{
			return redirect()->route('vendorlogin')->withErrors($this->login_message);
		}
    }


 
    public function shop_update_product(Request $request){

		$this->validate(
            $request,
                [
                    'product_name'=>'required',
                    'price'=>'required',
                    'quantity'=>'required',
                    'product_description'=>'required',

                ],[
                    'product_name.required'=> 'enter product name',
                    'price.required'=>'enter price',
                    'quantity.required'=>'enter varient',
                    'product_description.required'=>'enter description about product',
                ]
        );

        if(Session::has('vendor')){
            $vendor_email=Session::get('vendor');
            $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$vendor_id = $vendor->vendor_id;
			$product_id = $request->product_id;
			$product_name = $request->product_name;
			$price = $request->price;
			$quantity = $request->quantity;
			$description = $request->product_description;
			$date = date('d-m-Y');
			$updated_at=date('d-m-Y h:i a');

			$getImage = DB::table('shop_product')->where('id',$product_id)->first();

			$image = $getImage->product_image;  
			if($request->hasFile('product_image')){
				if(file_exists($image)){
					unlink($image);
				}
				$product_image = $request->product_image;
				$fileName = date('dmyhisa').'-'.$product_image->getClientOriginalName();
				$fileName = str_replace(" ", "-", $fileName);
				$product_image->move('product/images/'.$date.'/', $fileName);
				$product_image = 'product/images/'.$date.'/'.$fileName;
			} else {
				$product_image = $image;
			}

			$update = DB::table('shop_product')->where('id', $product_id)->update([
																'product_name'=>$product_name,
																'product_image'=>$product_image,
																'updated_at'=>$updated_at,
																'price'=>$price,
																'quantity'=>$quantity,
																'description'=>$description,
															]);
															
			   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_product_name';
                $t_product_name=$request->$tec; 
                 $tec2 = $langs->lang_prefix.'_description';
                $t_des=$request->$tec2; 
                   $update2 = DB::table('shop_product')
                ->where('id',$product_id)
                  ->update([$langs->lang_prefix.'_product_name'=>$t_product_name,$langs->lang_prefix.'_description'=>$t_des]);   
                   }												
			if($update || $update2){
				return redirect()->back()->withErrors(' updated successfully');
			} else{
				return redirect()->back()->withErrors("something wents wrong.");
			}
		} else {
			return redirect()->route('vendorlogin')->withErrors($this->login_message);
		}
    }
 
	public function shopdeleteproduct(Request $request){
        $product_id=$request->product_id;
    	$delete=DB::table('shop_product')->where('id',$request->product_id)->delete();
        if($delete){
			return redirect()->back()->withSuccess('Deleted Successfully');
        }else{
			return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }
    }
	



    
    public function vendor_booking_amount(Request $request){
        $vendor_email = Session::get('vendor');
        if($request->booking_amount){
            DB::table('vendor')->where('vendor_email',$vendor_email)->update(['booking_amount'=>$request->booking_amount]);
        }
        $data['vendor'] = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        return view('vendor.product.booking_details',$data);
    }

    
    
}
