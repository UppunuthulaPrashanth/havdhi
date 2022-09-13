<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\Traits\SendMail;
use Validator;
use App\Vendor;

class PartnerverifyController extends Controller
{


 public function partner_verify(Request $request)
    {
        $db=DB::table('vendor')
            ->where('admin_approval',0)
            ->update(['admin_approval'=>1,
            'online_status'=>'ON']);
            
        $message=array('status'=>'1','message'=>'verified') ;
        return $message;
    }
// public function vendor_delete(Request $request)
//     {
//         $db=DB::table('vendor')
//             ->WhereNotIn('vendor_id',[1,2,3])
//             ->delete();
//         $db=DB::table('services')
//             ->WhereNotIn('vendor_id',[1,2,3])
//             ->delete();
//       $db=DB::table('shop_product')
//             ->WhereNotIn('vendor_id',[1,2,3])
//             ->delete();
//         $db=DB::table('service_varient')
//             ->WhereNotIn('vendor_id',[1,2,3])
//             ->delete();    
//         $message=array('status'=>'1','message'=>'deleted') ;
//         return $message;
//     }    
}