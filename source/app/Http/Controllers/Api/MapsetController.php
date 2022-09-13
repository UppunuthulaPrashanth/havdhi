<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\Translate;
class MapsetController extends Controller
{
       use Translate;
   public function mapby(Request $request)
    {  
        $paymentvia = DB::table('map_settings')
                   ->first();
                   
        if($paymentvia)   { 
            $message = array('status'=>'1', 'message'=>'map and places via', 'data'=>$paymentvia);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    
    public function google_map(Request $request)
    {  
        $mapapi = DB::table('map_api')
                   ->first();
                   
        if($mapapi)   { 
            $message = array('status'=>'1', 'message'=>'Google map api', 'data'=>$mapapi);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    public function mapbox(Request $request)
    {  
        $mapapi = DB::table('mapbox')
                   ->first();
                   
        if($mapapi)   { 
            $message = array('status'=>'1', 'message'=>'Mapbox api', 'data'=>$mapapi);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    
     
      public function referral(Request $request)
    {
         $getScratchCard = DB::table('referral_points')
                                ->first();
        $lang=$request->lang;
        $scratch_card_offers = json_decode($getScratchCard->points);
        $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

         $earn = "Refer and Earn Rewards Point between ".$scratch_card_offers->min." to ".$scratch_card_offers->max.". You can use it to book services";

        if($getScratchCard){
                $message = array('status'=>'1', 'message'=>'refer and earn', 'data'=>$earn);
                return $message;
                            }   
           else{
                 $message = array('status'=>'0', 'message'=>'No City Found', 'data'=>[]);
              return $message;
      }                    
    }
    
  
    
   public function translates(Request $request)
    {  
     $orderplacedmsg = $this->translate();  
    }
}