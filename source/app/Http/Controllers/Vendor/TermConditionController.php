<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class TermConditionController extends Controller
{
    
    public function aboutus(Request $request){
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();

        $id = $request->id;
        
        $reedem = DB::table('about_us')->whereVendor_id($vendor->vendor_id)->get();

        if($reedem->count()==0){
            $time_dup = DB::table('about_us')->select('description','vendor_id')->whereVendor_id(0)->get()->toArray();
            foreach($time_dup as $index=>$time_dup_single){
                $time_dup[$index] = (array)$time_dup_single;
                $time_dup[$index]['vendor_id'] = $vendor->vendor_id;
            }
            DB::table('about_us')->insert($time_dup);
        }
        $reedem = DB::table('about_us')->whereVendor_id($vendor->vendor_id)->first();

        return view('vendor.app_setting.about_us', compact('vendor_email',"reedem",'vendor'));    
        
        
    }

    
    public function aboutusupdate(Request $request)
    {
        $id = $request->id;
        $description = $request->description;
    	 DB::table('about_us')
    	            ->where('id',$id)
                    ->update([
                        'description'=>$description,
                        ]);
     
    return redirect()->back()->withSuccess('Updated Successfully');

    }
    
 
    

}

