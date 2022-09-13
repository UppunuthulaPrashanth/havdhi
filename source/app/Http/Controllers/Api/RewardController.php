<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RewardController extends Controller
{
    public function scratchCard(Request $request)
    {
        $user_id = $request->user_id;

    	$userScratchCard = DB::table('tbl_user_scratch_card')
                            ->join('tbl_scratch_card', 'tbl_scratch_card.id', '=', 'tbl_user_scratch_card.scratch_id')
                            ->where('tbl_user_scratch_card.user_id', $user_id)
                            ->select('tbl_user_scratch_card.*', 'tbl_scratch_card.scratch_card_image as scratch_card_image')
    					    ->get();

    	if(count($userScratchCard)>0){
            $message = array('status'=>'1', 'message'=>'scratch card', 'data'=>$userScratchCard);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'no scratch card found');
        	return $message;
    	}
    }

   

    public function userReward(Request $request)
    {
        $user_id = $request->user_id;
        $scratch_id = $request->scratch_id;
        
         $Reward = DB::table('tbl_user_scratch_card')
                        ->where('user_id', $user_id)
                        ->where('scratch_id', $scratch_id)
                        ->first();
         $earning = $Reward->earn_points;
         $user =  DB::table('users')
                ->where('id', $user_id)
                ->first();
        $rewa = $user->rewards + $earning;       
        

        $userReward = DB::table('tbl_user_scratch_card')
                        ->where('user_id', $user_id)
                        ->where('scratch_id', $scratch_id)
                        ->update([
                            'is_scratch'=>'1',
                        ]);

        if($userReward){
            $user =  DB::table('users')
                ->where('id', $user_id)
                ->update(['rewards'=>$rewa]);
            $getReward = DB::table('tbl_user_scratch_card')
                            ->where('user_id', $user_id)
                            ->where('scratch_id', $scratch_id)
                            ->first();
           
            $message = array('status'=>'1', 'message'=>$getReward->earning, 'data'=>$getReward);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something wrong');
            return $message;
        }
    }
}