<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class VarientController extends Controller
{
    public function varient(Request $request)
    {
         $id = $request->id;
          DB::table('service')
                 ->where('service_id', $id)
                ->first();
         
    	 
    	$vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
    	 $lang=DB::table('langs')
    	       ->get();
        $product= DB::table('service_varient')
                 ->where('service_id', $id)
                ->get();
        return view('vendor.product.varient.show_varient',compact("vendor_email","product","vendor","id","lang"));
    }
    
     public function Addproductvariant(Request $request)
    {
        $id = $request->id;  
        DB::table('service')
                 ->where('service_id', $id)
                ->first();
         
    	 
       $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
    	
        DB::table('service_varient')
                 ->where('service_id', $id)
                ->get();
       $lang=DB::table('langs')
           ->get();
         return view('vendor.product.varient.addvarient',compact("vendor_email","vendor","id","lang"));
    }
    
    
   public function AddNewproductvariant(Request $request)
    {
         $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $vendor_id=$vendor->vendor_id;
         
        $id = $request->id;
        $product =  DB::table('service')
                 ->where('service_id', $id)
                ->first();
        $price=$request->price;
        $varient=$request->varient;
        $time =$request->timet;
        $date = date('d-m-Y');

        $this->validate(
            $request,
                [
                    
                    'timet'=>'required',
                    'varient'=>'required',
                    'price'=>'required',
                ],
                [
                    
                    'timet.required'=>'enter service time minutes',
                    'quantity.required'=>'enter quantity',
                    'varient.required'=>'enter varient'
                ]
        );
                

        $ser=DB::table('service')
            ->where('service_id',$id)
            ->first();
        
        $insert =  DB::table('service_varient')
                        ->insertGetId(['service_id'=>$id,'service_name'=>$product->service_name, 'price'=>$price, 'varient'=>$varient, 'time'=>$time,'vendor_id'=>$vendor_id]);
     if($insert){
             $lang=DB::table('langs')
           ->get();
    
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_varient';
                $t_product_name=$request->$tec; 
                if($t_product_name==NULL){
                    $t_product_name=$varient;
                }
                   $update2 = DB::table('service_varient')
                 ->where('varient_id', $insert)
                  ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);   
                  
                   $insert1 = DB::table('order_cart')
                ->where('varient_id', $insert)
                ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);
                   }
         return redirect()->back()->withErrors('Successfully Added');
     }
     else{
     return redirect()->back()->withErrors('something went wrong');
     }
	
    }
    
    public function Editproductvariant(Request $request)
    {
 
       $varient_id=$request->id;

    	 $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
    	 
        $product= DB::table('service_varient')
                 ->where('varient_id', $varient_id)
                ->first();
                
        $p= DB::table('service')
                 ->where('service_id', $product->service_id)
                ->first();
         $lang=DB::table('langs')
              ->get();
    	 return view('vendor.product.varient.Editvarient',compact("vendor_email","vendor","product","varient_id","lang"));
   }
    public function Updateproductvariant(Request $request)
   {
      $lang=DB::table('langs')
              ->get();
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $vendor_id=$vendor->vendor_id;
         
        $varient_id = $request->id;
        $price=$request->price;
        $varient=$request->varient;
        $time =$request->timet;
        $date = date('d-m-Y');
        


       $varient_update = DB::table('service_varient')
                            ->where('varient_id', $varient_id)
                            ->update(['price'=>$price,'time'=>$time,'varient'=>$varient]);


          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_varient';
                $t_product_name=$request->$tec; 
                   $update2 = DB::table('service_varient')
                 ->where('varient_id', $varient_id)
                  ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);   
                  
                   $insert1 = DB::table('order_cart')
                ->where('varient_id', $varient_id)
                ->update([$langs->lang_prefix.'_varient'=>$t_product_name]);
                   }
        if($varient_update || $update2){
            

            return redirect()->back()->withErrors('Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong.");
        }
    }
  public function deleteproductvariant(Request $request)
    {
        $varient_id=$request->id;

     

    	$delete=DB::table('service_varient')->where('varient_id',$request->id)->delete();
        if($delete)
        {
        
         
         
        return redirect()->back()->withSuccess('Deleted Successfully');

        }
        else
        {
           return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }

    }
	
    
}
