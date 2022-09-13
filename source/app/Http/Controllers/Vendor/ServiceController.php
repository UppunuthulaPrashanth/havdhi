<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Lang;

class ServiceController extends Controller
{

    private $product_vendor_id = 'product.vendor_id';
    private $shopproduct_vendor_id = 'shop_product.vendor_id';
    private $vendor_product_product = 'vendor.product.product';
    private $vendor_shopproduct_product = 'vendor.shopproduct.product';
    private $login_message = 'please login first';
    
    public function service(Request $request){
    if(Session::has('vendor'))
     {
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $product= DB::table('service')
                 ->where('vendor_id', $vendor->vendor_id)
               ->paginate(10);
        $currency =  DB::table('currency')
               ->select('currency_sign')
                ->paginate(10);  
          $lang=Lang::get();      
            
        return view($this->vendor_product_product,compact("vendor_email","product","vendor","currency","lang"));
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    

    
     public function Addservice(Request $request){
      if(Session::has('vendor'))
      {
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $lang=Lang::get();
         return view('vendor.product.addproduct',compact("vendor_email","vendor","lang"));
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    
 
    
     public function search_services(Request $request)
    {
      if(Session::has('vendor'))
      {
		$query = $request->get('query');
        $vendor_email=Session::get('vendor');
        $products = DB::table('service')->select("service_name as name")->where("service_name","LIKE","%{$query}%")->distinct()->get();
        $data['products'] = $products;
		return response()->json($products);
		
        return view('vendor.product.addproduct',compact("vendor_email","products"));
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    

   public function AddNewservice(Request $request){
             $this->validate(
            $request,
                [
                    'product_name'=>'required',
                    'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                ],
                [    
                    'product_name.required'=> 'enter service name',
                    'product_image.required'=>'enter image product'

                ]
        );

         if(Session::has('vendor'))
        {
             $vendor_email=Session::get('vendor');
             $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
          
        $vendor_id=$vendor->vendor_id;
        $product_id=$request->id;
        $product_name=$request->product_name;
      
        $old_product_image=$request->old_product_image;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
        $product_image = $request->product_image;
        $fileName = date('dmyhisa').'-'.$product_image->getClientOriginalName();
        $fileName = str_replace(" ", "-", $fileName);
        $product_image->move('product/images/'.$date.'/', $fileName);
        $product_image = 'product/images/'.$date.'/'.$fileName;
        
        

        $insert = DB::table('service')
                  ->insertGetId(['service_name'=>$product_name,'service_image'=>$product_image,'created_at'=>$created_at,'vendor_id'=>$vendor_id
                  ]);
     if($insert){
           $lang=DB::table('langs')
           ->get();
           
           
           foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_service_name';
                $t_product_name=$request->$tec; 
                if($t_product_name == NULL){
                    $t_product_name=$product_name;
                }
                   $update2 = DB::table('service')
                ->where('service_id',$insert)
                  ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);   
                   }
     
         return redirect()->back()->withErrors('successfully added');
     }
     else{
     return redirect()->back()->withErrors('something went wrong');
     }
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
    


    public function Editservice(Request $request)
    {
      if(Session::has('vendor'))
      {	
       $product_id=$request->service_id;
    	 $vendor_email=Session::get('vendor');
    	 
         $vendor=DB::table('vendor')
                ->where('vendor_email',$vendor_email)
                ->first();       
    	 $product= DB::table('service')
    	 		  ->where('service_id',$product_id)
    	 		  ->first();
    	 $lang=Lang::get();
    	 return view('vendor.product.Editproduct',compact("vendor_email","vendor","product","product_id","lang"));
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }

    }


    public function Updateservice(Request $request)
   {
     if(Session::has('vendor'))
     {
        $product_id=$request->service_id;
        $product_name=$request->product_name;
        $old_product_image=$request->old_product_image;
      $lang=Lang::get();
        $date = date('d-m-Y');
        $updated_at = date("d-m-y h:i a");
        $date=date('d-m-y');
        
        $this->validate(
            $request,
                [
                     'product_name'=>'required',
                    'product_image' => 'mimes:jpeg,png,jpg|max:400',
                    'old_product_image'=>'required',
                ],
                [
        
                    'product_name.required'=> 'enter service name',
                    'old_product_image.required' => 'choose picture.',
                ]
        );

        $getImage = DB::table('service')
                     ->where('service_id',$product_id)
                    ->first();

        $image = $getImage->service_image;  

        if($request->hasFile('product_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $product_image = $request->product_image;
            $fileName = date('dmyhisa').'-'.$product_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $product_image->move('product/images/'.$date.'/', $fileName);
            $product_image = 'product/images/'.$date.'/'.$fileName;
        }
        else{
            $product_image = $old_product_image;
        }

        $update = DB::table('service')
                 ->where('service_id', $product_id)
                 ->update(['service_name'=>$product_name,'service_image'=>$product_image,'updated_at'=>$updated_at]);
         foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_service_name';
                $t_product_name=$request->$tec; 
                   $update2 = DB::table('service')
                ->where('service_id',$product_id)
                  ->update([$langs->lang_prefix.'_service_name'=>$t_product_name]);   
                   }
        if($update || $update2){
           
            return redirect()->back()->withErrors(' updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
	 }
	else
	 {
	    return redirect()->route('vendorlogin')->withErrors($this->login_message);
	 }
    }
 
 	public function vendordeleteservice(Request $request){
        $product_id=$request->service_id;
    	$delete=DB::table('service')->where('service_id',$request->service_id)->delete();
        if($delete){
			DB::table('service_varient')->where('service_id',$request->service_id)->delete();  
			return redirect()->back()->withSuccess('Deleted Successfully');
        }else{
			return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }
    }

    public function searchproduct(Request $request){
      $this->validate($request,[
         'productname' => 'required',
     ]);
      $productname=$request->productname;

    	if(Session::has('vendor'))
          {
                 $vendor_email=Session::get('vendor');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
                    $id=$vendor->vendor_id;
               If($productname!=null && $id!=null){
                 

    			$vendor_email = Session::get('vendor');
    			$vendor = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
    			$product = DB::table('shop_product')->where($this->shopproduct_vendor_id, $vendor->vendor_id)->where('product_name','like', '%' . $request->productname . '%')->paginate(10);
    			$lang=DB::table('langs')
    			     ->get();
    			$currency = DB::table('currency')->select('currency_sign')->paginate(10);         
    			return view($this->vendor_shopproduct_product,compact("vendor_email","product","vendor","currency","lang"));

               }else{

                $product= DB::table('service')
                
                 ->where('vendor_id', $vendor->vendor_id)
                ->get();

                                 return view($this->vendor_product_product,compact("vendor_email","product","vendor"));
                }
            
          }
        else
             {
                return redirect()->route('vendorlogin')->withErrors($this->login_message);
             }


    }
    public function getSearch($productname,$id)
{
    if($productname!=null && $id!=null){
        
     $od = DB::table('service')
     ->join('subcat',$this->product_subcat_id, '=', $this->subcat_subcat_id)
     ->join('tbl_category',$this->subcat_category_id, '=', $this->tbl_category_category_id)
     ->where($this->product_vendor_id, $id)
     ->where([['product_name','=',$productname]])->get();
       return $od;
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
