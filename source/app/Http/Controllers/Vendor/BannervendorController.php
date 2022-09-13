<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class BannervendorController extends Controller
{

     public $login_check_message = 'please login first';

    public function bannervendor(Request $request)
    {
     if(Session::has('vendor'))
     {   
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $banner= DB::table('banner')
        ->where('vendor_id',$vendor->vendor_id)
        ->get();
        return view('vendor.banner.bannervendor',compact("vendor_email","banner","vendor"));
        
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function Addbannervendor(Request $request)
         {
          if(Session::has('vendor'))
     {
       
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
    
         return view('vendor.banner.addbanner',compact("vendor_email","vendor"));
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function AddNewbannervendor(Request $request)
         {
          $date = date('d-m-Y');
          $this->validate($request,[
               'banner_name' => 'required',
               'banner_keyword' => 'required',
               'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

           ]);
      if(Session::has('vendor'))
     {
      
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $vendor_id = $vendor->vendor_id ;
        $banner_name = $request->banner_name;
        $keyword = $request->banner_keyword;

        $created_at=date('d-m-Y h:i a');
        $banner_image = $request->banner_image;
        $fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
        $fileName = str_replace(" ", "-", $fileName);
        $banner_image->move('banner/images/'.$date.'/', $fileName);
        $banner_image = 'banner/images/'.$date.'/'.$fileName;


        DB::table('banner')->insert(['vendor_id'=>$vendor_id,'keyword'=>$keyword,'banner_name'=>$banner_name,'banner_image'=>$banner_image,'created_at'=>$created_at]);
     
     return redirect('vendors/bannervendor')->withErrors('Added successfully');
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }

    }
	
    public function Editbannervendor(Request $request)
         {
          if(Session::has('vendor'))
      {	
  
       $banner_id=$request->id;
    	 $vendor_email=Session::get('vendor');
    	 
         $vendor=DB::table('vendor')
                ->where('vendor_email',$vendor_email)
                ->first();       
    	 $banner= DB::table('banner')
    	 		  ->where('banner_id',$banner_id)
    	 		  ->first();
   		  
    	 return view('vendor.banner.Editbanner',compact("vendor_email","vendor","banner_id","banner"));
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }


    }
    
    public function Updatebannervendor(Request $request)
         {
          $date = date('d-m-Y');
          if(Session::has('vendor'))
      {
        $banner_id=$request->id;
        $banner_name=$request->banner_name;
        $keyword=$request->banner_keyword;
        $old_banner_image=$request->old_banner_image;
        $updated_at = date("d-m-y h:i a");

        $getImage = DB::table('banner')
                     ->where('banner_id',$banner_id)
                    ->first();

        $image = $getImage->banner_image;  

        if($request->hasFile('banner_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $banner_image = $request->banner_image;
            $fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $banner_image->move('banner/images/'.$date.'/', $fileName);
            $banner_image = 'banner/images/'.$date.'/'.$fileName;
        }
        else{
            $banner_image = $old_banner_image;
        }

        $update = DB::table('banner')
                 ->where('banner_id', $banner_id)
                 ->update(['banner_name'=>$banner_name,'keyword'=>$keyword, 'banner_image'=>$banner_image,'updated_at'=>$updated_at]);

        if($update){

             

            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }
    }
    
    public function deletebannervendor(Request $request)
         {
          if(Session::has('vendor'))
     {
        $banner_id=$request->id;

        $getfile=DB::table('banner')
                ->where('banner_id',$banner_id)
                ->first();

        $banner_image=$getfile->banner_image;

    	$delete=DB::table('banner')->where('banner_id',$request->id)->delete();
        if($delete)
        {
        
            if(file_exists($banner_image)){
                unlink($banner_image);
            }
         
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }
         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }

    }

	
    public function vendorgalleries(Request $request){
		if(Session::has('vendor')){
			$vendor_email = Session::get('vendor');
			$vendor = DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$galleries = DB::table('galleries')->where('vendor_id',$vendor->vendor_id)->get();
			if($request->gallery_id){
				DB::table('galleries')->whereId($request->gallery_id)->delete();
				return back()->withErrors('Deleted successfully');
			}
			return view('vendor.banner.galleries',compact("vendor_email","vendor",'galleries'));
        }else {
			return redirect()->route('vendorlogin')->withErrors($login_check_message);
        }
    }
    
    public function vendorgalleriessave(Request $request){
		$date = date('d-m-Y');
		$this->validate($request,[
			'galleries_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);
		if(Session::has('vendor')){
			$vendor_email=Session::get('vendor');
			$vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
			$vendor_id = $vendor->vendor_id ;

			if($request->hasFile('galleries_image')){
				$galleries = [];
				foreach($request->file('galleries_image') as $index=>$image){
					$destinationPath = 'banner/galleries/'.$date.'/';
					$fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
					$fileName = str_replace(" ", "-", $fileName);
					$image->move($destinationPath, $fileName);
					$filename_save = 'banner/galleries/'.$date.'/'.$fileName;
					$galleries[$index]['image'] = $filename_save;
					$galleries[$index]['vendor_id'] = $vendor_id;
				}
			}

			DB::table('galleries')->insert($galleries);

			return back()->withErrors('Added successfully');
         }else{
            return redirect()->route('vendorlogin')->withErrors($login_check_message);
         }

    }
	
	
	
	    
    
}
