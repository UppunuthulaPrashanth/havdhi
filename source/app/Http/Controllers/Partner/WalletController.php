<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;
use App\ShopProduct;

class WalletController extends Controller
{

    public function wallet(Request $request){
		return $message = array('status'=>'0', 'message'=>'');
    }
    
	public function wallet_admin_share(Request $request){
		return $message = array('status'=>'0', 'message'=>'');
    }

	public function wallet_vedonr_share(Request $request){
		return $message = array('status'=>'0', 'message'=>'');
    }


}
