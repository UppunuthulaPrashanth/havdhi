<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use App\Traits\SendMail;
use App\Gallery;

class GalleryController extends Controller
{
	use SendMail;

    public function list(Request $request){
		$gallery = Gallery::where('vendor_id',$request->vendor_id)->get();
    	if(count($gallery)>0){
    		$message = array('status'=>'1', 'message'=>'Gallery list', 'data'=>$gallery);
	        return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no Gallery list');
	        return $message;
    	}
     }
    
	public function add(Request $request){
        if($request->vendor_id){
            $vendor_id = $request->vendor_id;
			$galleries = [];
		    $date = date('d-m-Y');
    		if($request->hasFile('image')){
    			foreach($request->file('image') as $index=>$image){
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

            $ven =  DB::table('galleries')->where('vendor_id', $vendor_id)->get();

            $message = array('status'=>'1', 'message'=>'Added successfully', 'data'=>$ven);
            return $message;	
        }
        else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    
    }

	public function delete(Request $request){
        $gallery = Gallery::where('id', $request->gallery_id)->first();
        if($gallery){
            $gallery->delete();
            $message = array('status'=>'1', 'message'=>'Deleted successfully');
            return $message;	
        } else{
           $message = array('status'=>'0', 'message'=>'Something went wrong! Try again later');
                return $message;	  
        }
    }   



}
