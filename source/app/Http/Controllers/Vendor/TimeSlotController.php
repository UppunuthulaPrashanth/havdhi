<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class TimeSlotController extends Controller
{
    public function timeslot(Request $request)
    {
        $vendor_email=Session::get('vendor');
        
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        /*$vendor_id = $vendor->vendor_id;
        $time = DB::table('time_slot')->where('vendor_id',$vendor_id)->get();
        if($time->count()==0){
            $time_dup[0] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Monday','vendor_id'=>$vendor_id];
            $time_dup[1] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Tuesday','vendor_id'=>$vendor_id];
            $time_dup[2] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Wednesday','vendor_id'=>$vendor_id];
            $time_dup[3] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Thursday','vendor_id'=>$vendor_id];
            $time_dup[4] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Friday','vendor_id'=>$vendor_id];
            $time_dup[5] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Saturday','vendor_id'=>$vendor_id];
            $time_dup[6] = ['open_hour'=>'10:00','close_hour'=>'20:00','days'=>'Sunday','vendor_id'=>$vendor_id];
            DB::table('time_slot')->insert($time_dup);
        }*/
        
        $time = DB::table('time_slot')->where('vendor_id',$vendor->vendor_id)->get();
        
                
        return view('vendor.time_slot.time_slot', compact("vendor_email",'vendor','time'));    
        
        
    }
    public function addtimeslot(Request $request)
    {
          $vendor_email=Session::get('vendor');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
                
                
        return view('vendor.time_slot.addtime_slot', compact("vendor_email",'vendor'));    
        
        
    }

    public function addnewtimeslot(Request $request)
    {
        $vendor_email=Session::get('vendor');
        
        $vendor=DB::table('vendor')
        ->where('vendor_email',$vendor_email)
        ->first();
        $vendor_id =  $vendor->vendor_id;
        $open_hrs = $request->open_hour;
        $close_hrs = $request->close_hour;
        $day = $request->day;
        

         DB::table('time_slot')
                    ->insert([
                        'open_hour'=>$open_hrs,
                        'close_hour'=>$close_hrs,
                        'days'=>$day,
                        'vendor_id'=>$vendor_id
                        ]);
     
         return redirect()->back()->withErrors('insert Successfully');

    }

    public function edittimeslot(Request $request)
    {
          $vendor_email=Session::get('vendor');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
                    $time_slot_id=$request->id;

                    $time= DB::table('time_slot')
                    ->where('time_slot_id',$time_slot_id)
                    ->first();
                
        return view('vendor.time_slot.edittime_slot', compact("vendor_email",'vendor','time'));    
        
        
    }

    public function timeslotupdate(Request $request)
    {
        $time_slot_id = $request->time_slot_id;
        $open_hrs = $request->open_hour;
        $close_hrs = $request->close_hour;
        $days = $request->days;
        $status = $request->status;

        

         DB::table('time_slot')
                    ->where('time_slot_id',$time_slot_id)
                    ->update([
                        'open_hour'=>$open_hrs,
                        'close_hour'=>$close_hrs,
                        'days'=>$days,
                        'status'=>$status

                        ]);
     
         return redirect()->back()->withErrors('Updated Successfully');

    }

    
    public function deletetimeslot(Request $request)
    {
if(Session::has('vendor'))
{

   $delete=DB::table('time_slot')->where('time_slot_id',$request->id)->delete();
   if($delete)
   {
    
   return redirect()->back()->withErrors('delete successfully');

   }
   else
   {
      return redirect()->back()->withErrors('unsuccessfull delete'); 
   }
    }
else
    {
       return redirect()->route('vendorlogin')->withErrors('please login first');
    }

}


    
    
    
    /*============================= Staff Availability Codes ==============================*/
    
    public function staff_timeslot(Request $request)
    {
        $vendor_email=Session::get('vendor');
        
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        $time_slot = DB::table('staff_availability_time_slot')->where('vendor_id',$vendor->vendor_id)->get();
        $data['vendor'] = $vendor;
        $data['time_slot'] = $time_slot;
        return view('vendor.time_slot.staff_time_slot', $data);    
        
        
    }
    public function staff_addtimeslot(Request $request)
    {
          $vendor_email=Session::get('vendor');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
                
                
        return view('vendor.time_slot.staff_addtime_slot', compact("vendor_email",'vendor'));    
        
        
    }

    public function staff_addnewtimeslot(Request $request)
    {
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        $vendor_id =  $vendor->vendor_id;
        $open_hrs = $request->open_hour;
        $close_hrs = $request->close_hour;

         DB::table('staff_availability_time_slot')
                    ->insert([
                        'open_hour'=>$open_hrs,
                        'close_hour'=>$close_hrs,
                        'vendor_id'=>$vendor_id,
                        'created_at'=>date('Y-m-d H:i:s'),
                        ]);
     
         return redirect()->back()->withErrors('Inserted Successfully');

    }

    public function staff_edittimeslot(Request $request)
    {
        $vendor_email=Session::get('vendor');
        $vendor=DB::table('vendor')->where('vendor_email',$vendor_email)->first();
        $time_slot_id=$request->id;

        $time= DB::table('staff_availability_time_slot')->where('id',$time_slot_id)->first();
                
        return view('vendor.time_slot.staff_edittime_slot', compact("vendor_email",'vendor','time'));    
        
        
    }

  

    
    
    
    
    
}