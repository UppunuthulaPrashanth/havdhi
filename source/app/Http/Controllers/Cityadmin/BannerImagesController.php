<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class BannerImagesController extends Controller
{
    public function adminbanner(Request $request){

		$admin_email = Session::get('cityadmin');
		$cityadmin = DB::table('cityadmin')->where('cityadmin_email',$admin_email)->first();
		$banner= DB::table('admin_banner')->select('admin_banner.*','vendor.vendor_name')->join('vendor','vendor.vendor_id','admin_banner.vendor_id')->get();
		return view('cityadmin.banner.bannerlist',compact("admin_email",'cityadmin',"banner"));
    }

    public function addadminbanner(Request $request)
    {
		$admin_email 	= Session::get('cityadmin');
        $cityadmin 		= DB::table('cityadmin')->where('cityadmin_email',$admin_email)->first();
		$vendors 		= DB::table('vendor')->get();
    	return view('cityadmin.banner.addbanner',compact("admin_email","vendors","cityadmin"));
    }
    public function saveadminbanner(Request $request)
    {
    	$banner_name	= $request->banner_name;
    	$vendor_id		= $request->vendor_id;
    	$date = date('d-m-Y');

        if($request->hasFile('banner_image')){
			$banner_image = $request->banner_image;
			$fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
			$fileName = str_replace(" ", "-", $fileName);
			$banner_image->move('images/admin/admin_banner/'.$date.'/', $fileName);
			$banner_image = 'images/admin/admin_banner/'.$date.'/'.$fileName;
		}else{
			$banner_image = 'N/A';
		}

		 DB::table('admin_banner')->insert(['banner_name'=>$banner_name,'banner_image'=>$banner_image,'vendor_id'=>$vendor_id]);
		return redirect()->back()->withErrors('successfully');
	}

    public function editadminbanner(Request $request)
{
		$admin_email 	= Session::get('cityadmin');
        $cityadmin 		= DB::table('cityadmin')->where('cityadmin_email',$admin_email)->first();
		$vendors 		= DB::table('vendor')->get();
		$banner			= DB::table('admin_banner')->where('banner_id',$request->id)->first();
		return view('cityadmin.banner.edit_banner',compact("admin_email","vendors","cityadmin",'banner'));
	}

	public function updateadminbanner(Request $request){
    	$banner_id	= $request->id;
    	$banner_name	= $request->banner_name;
    	$vendor_id		= $request->vendor_id;
    	$date = date('d-m-Y');
        $getImage = DB::table('admin_banner')->where('banner_id', $banner_id)->first();

        $image = $getImage->banner_image;
        if($request->hasFile('banner_image')){
             if(file_exists($image)){
                unlink($image);
            }
			$banner_image = $request->banner_image;
			$fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
			$fileName = str_replace(" ", "-", $fileName);
			$banner_image->move('images/admin/admin_banner/'.$date.'/', $fileName);
			$banner_image = 'images/admin/admin_banner/'.$date.'/'.$fileName;
		}else{
			$banner_image = $image;
		}

        DB::table('admin_banner')->where('banner_id', $banner_id)->update(['banner_name'=>$banner_name,'banner_image'=>$banner_image,'vendor_id'=>$vendor_id]);
		return redirect()->back()->withErrors('successfully');
    }

     public function deleteadminbanner(Request $request){
        $banner_id	= $request->id;
        $getfile	= DB::table('admin_banner')->where('banner_id',$banner_id)->first();
        $city_image	= $getfile->banner_image;
    	$delete		= DB::table('admin_banner')->where('banner_id',$request->id)->delete();
        if($delete)
        {
            if(file_exists($city_image)){
                unlink($city_image);
            }
			return redirect()->back()->withErrors('delete successfully');
        }else{
           return redirect()->back()->withErrors('unsuccessfull delete');
        }
    }


}

