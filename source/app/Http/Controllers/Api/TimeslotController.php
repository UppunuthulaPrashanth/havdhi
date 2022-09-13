<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use DateTime;

class TimeslotController extends Controller
{
  public function timeslot(Request $request)
    {
     $vendor_id = $request->vendor_id;       
    $current_time = Carbon::Now();
    $date = date('Y-m-d');
    
    $selected_date  = $request->selected_date;
     $day = date('l', strtotime($selected_date));
       $time_slot = DB::table('time_slot')
               ->where('vendor_id',$vendor_id)
               ->where('days',$day)
               ->first();
    $starttime  = $time_slot->open_hour;
    $staff_id = $request->staff_id;
    $orders = 1;
    $endtime  = $time_slot->close_hour;
    $duration  = 60;   
     
    $orders= 1; 
    $array_of_time = array ();
    $array_of_time1 = array ();
    $min = 10;
    $currenttime = strtotime ("+".$min." minutes", strtotime($current_time));
    $start_time    = strtotime ($starttime); //change to strtotime
    $end_time      = strtotime ($endtime); //change to strtotime

    $add_mins  = $duration * 60;
if(strtotime($date)==strtotime($selected_date)){
    while ($start_time <= $currenttime) // loop between time
    {
       $array_of_time[] = date ("h:i a", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time = array ();
    for($i = 0; $i < count($array_of_time) - 1; $i++)
    {
        $new_array_of_time[] = '' . $array_of_time[$i] . ' - ' . $array_of_time[$i + 1];
    }
    
$items=last($new_array_of_time);
$numbers = explode('-', $items);
$last_Number = end($numbers);
 $lastNumber    = strtotime ($last_Number);
 if($last_Number!= NULL){
while ($lastNumber <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("h:i a", $lastNumber);
       $lastNumber += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 1; $i < count($array_of_time1) - 1; $i++)
    {
         $totorders = DB::table('orders')
               ->where('service_date',$selected_date)
               ->where('service_time',$array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1])
               ->count();
       
        if($orders > $totorders){
            
            $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'true');
            
        }
        else{

             $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'false');
        }
        
    }
 }
 else{
     while ($start_time <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("h:i a", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 1; $i < count($array_of_time1) - 1; $i++)
    {
         $totorders = DB::table('orders')
               ->where('service_date',$selected_date)
               ->where('service_time',$array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1])
               ->count();
       
        if($orders > $totorders){
            
            $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'true');
            
        }
        else{

             $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'false');
        }
    }
 }
    
}
elseif(strtotime($date)>strtotime($selected_date)){
   
                $message = array('status'=>'0', 'message'=>"You can't select the back date");
            return $message; 
}
else{
    while ($start_time <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("h:i a", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 0; $i < count($array_of_time1) - 1; $i++)
    {
         $totorders = DB::table('orders')
               ->where('service_date',$selected_date)
               ->where('service_time',$array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1])
               ->count();
       
        if($orders > $totorders){
            
            $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'true');
            
        }
        else{

             $new_array_of_time1[] =array('timeslot'=>'' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1], 'availibility'=>'false');
        }
    }
    
}
    if(count($new_array_of_time1)>0){
       
  
        
            $message = array('status'=>'1', 'message'=>'Present time Slot', 'data'=>$new_array_of_time1);
            return $message;
            }
            else
            {
                $message = array('status'=>'0', 'message'=>'Oops No time slot present');
            return $message;
            }
    
    }
            
            
            
            
    
    
    
 
}