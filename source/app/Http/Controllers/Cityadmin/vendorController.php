<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use App\Traits\SendMail;
use App\Traits\SendSms;
use App\Vendor;

class vendorController extends Controller
{

  private $login_message = 'please login first';



  use SendMail;
    use SendSms;
    public function vendor(Request $request)
    {
     if(Session::has('cityadmin'))
     {

        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $vendor= DB::table('vendor')

        ->paginate(10);

        return view('cityadmin.vendor.vendor',compact("cityadmin_email","vendor","cityadmin"));
     }
     else
     {
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
     }
    }

    public function Addvendor(Request $request)
    {

     if(Session::has('cityadmin'))
     {
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();

                    $map1 = DB::table('map_api')
                         ->first();
                     $map = $map1->map_api_key;
                     $mapset = DB::table('map_settings')
                            ->first();
                    $mapbox = DB::table('mapbox')
                            ->first();

                $lang=DB::table('langs')
               ->get();
         return view('cityadmin.vendor.addvendor',compact("cityadmin_email","cityadmin","map1","mapset","mapbox","map","lang"));
     }
     else
         {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
         }
    }


    public function AddNewvendor(Request $request)
    {
		$this->validate($request,[
		   'vendor_name' => 'required',
		   'owner_name' => 'required',
		   'vendor_email' => 'required',
		   'vendor_phone' => 'required',
		   'password1' => 'required',
		   'password2' => 'required',
		   'vendor_address' => 'required',
		   'description' => 'required',
		   'shop_type' => 'required',
		   'admin_share' => 'required',
		  'vendor_image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'

	   ]);
    if(Session::has('cityadmin'))
     {

         $logo = DB::table('logo')
                ->where('logo_id', '1')
                ->first();
          $app_name =  $logo->logo_name;

        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;

        $vendor_id=$request->id;


        $vendor_name=$request->vendor_name;
        $owner = $request->owner_name;
        $vendor_email=$request->vendor_email;
        $vendor_phone=$request->vendor_phone;
        $password=$request->password1;
        $password2=$request->password2;
        $address = $request->vendor_address;
        $description = $request->description;
        $shop_type = $request->shop_type;
        $admin_share = $request->admin_share;
        $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);


         $checkmap = DB::table('map_api')
                  ->first();
         $mapset= DB::table('map_settings')
                ->first();

        $chkstorphon = DB::table('vendor')
                      ->where('vendor_phone', $vendor_phone)
                      ->first();
         $chkstoremail = DB::table('vendor')
                      ->where('vendor_email', $vendor_email)
                      ->first();

          if($chkstorphon && $chkstoremail){
             return redirect()->back()->withErrors('This Phone Number and Email Are Already Registered With Another Vendor');
        }

        if($chkstorphon){
             return redirect()->back()->withErrors('This Phone Number is Already Registered With Another Vendor');
        }
        if($chkstoremail){
             return redirect()->back()->withErrors('This Email is Already Registered With Another Vendor');
        }


           if($mapset->mapbox == 0 && $mapset->google_map == 1){
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$checkmap->map_api_key));

         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        }
        else{
           $lat = $request->lat;
           $lng = $request->lng;
        }


        $old_vendor_image=$request->old_vendor_image;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
        if($request->vendor_image){
            $vendor_image = $request->vendor_image;
            $fileName = date('dmyhisa').'-'.$vendor_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $vendor_image->move('vendor_img/images/'.$date.'/', $fileName);
            $vendor_image = 'vendor_img/images/'.$date.'/'.$fileName;
        }else{
            $vendor_image = $old_vendor_image;
        }
        if($password!=$password2){
             return redirect()->back()->withErrors('password are not same');
        }

       else{
        $new_pass=Hash::make($password);
        $insert = DB::table('vendor')
                  ->insertGetId(['cityadmin_id'=>$cityadmin_id,'vendor_name'=>$vendor_name,'vendor_logo'=>$vendor_image,'vendor_email'=> $vendor_email,'vendor_phone'=> $vendor_phone, 'vendor_pass'=>$new_pass,'vendor_loc'=>$address,'lat'=>$lat,'lng'=>$lng,'owner'=>$owner, 'created_at'=>$created_at,'online_status'=>'ON','description'=>$description,'shop_type'=>$shop_type,'admin_share'=>$admin_share]);

        $vendor_id = $insert;
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
        }


           
              $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                 $tec2 = $langs->lang_prefix.'_description';
                $t_des=$request->$tec2;
                if($t_des != NULL){
                   $update2 = DB::table('vendor')
                 ->where('vendor_id', $insert)
                  ->update([$langs->lang_prefix.'_description'=>$t_des]);
                }else{
                  $update2 = DB::table('vendor')
                 ->where('vendor_id', $insert)
                  ->update([$langs->lang_prefix.'_description'=>$description]);
                }
                   }
           
    
     return redirect()->back()->withErrors('successfully Created');
       }
     }

   else
     {
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
     }
    }



    public function Editvendor(Request $request)
    {
     if(Session::has('cityadmin'))
      {

       $vendor_id=$request->id;
    	 $cityadmin_email=Session::get('cityadmin');

         $cityadmin=DB::table('cityadmin')
                ->where('cityadmin_email',$cityadmin_email)
                ->first();
    	 $vendor= DB::table('vendor')
    	 		  ->where('vendor_id',$vendor_id)
    	 		  ->first();
    	 		  	 $map1 = DB::table('map_api')
             ->first();
         $map = $map1->map_api_key;
         $mapset = DB::table('map_settings')
                ->first();
        $mapbox = DB::table('mapbox')
                ->first();
          $lang=DB::table('langs')
               ->get();
    	 return view('cityadmin.vendor.Editvendor',compact("cityadmin_email","cityadmin","vendor_id","vendor","map1","mapset","mapbox","map","lang"));

      }
     else
      {
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
      }


    }
    public function Updatevendor(Request $request)
   {
     if(Session::has('cityadmin'))
      {

        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;

        $vendor_id=$request->id;
        $vendor_name=$request->vendor_name;
        $owner = $request->owner_name;
        $vendor_email=$request->vendor_email;
        $vendor_phone=$request->vendor_phone;
        $password=$request->password1;
        $password2=$request->password2;
        $address = $request->vendor_address;
        $description = $request->description;
        $shop_type=$request->shop_type;
        $admin_share = $request->admin_share;
        $old_vendor_image= $request->old_vendor_image;
        $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
        $new_pass=Hash::make($password);


        $checkmap = DB::table('map_api')
                  ->first();
         $mapset= DB::table('map_settings')
                ->first();


           if($mapset->mapbox == 0 && $mapset->google_map == 1){
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$checkmap->map_api_key));

         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        }
        else{
           $lat = $request->lat;
           $lng = $request->lng;
        }

        $updated_at = date("d-m-y h:i a");
        $date=date('d-m-y');


        $getImage = DB::table('vendor')
                     ->where('vendor_id',$vendor_id)
                    ->first();

        $image = $getImage->vendor_logo;

       if($password!=$password2){
             return redirect()->back()->withErrors('password are not same');
        }

       else{
        if($request->hasFile('vendor_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $vendor_image = $request->vendor_image;
            $fileName = date('dmyhisa').'-'.$vendor_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $vendor_image->move('vendor_img/images/'.$date.'/', $fileName);
            $vendor_image = 'vendor_img/images/'.$date.'/'.$fileName;
        }
        else{
            $vendor_image = $old_vendor_image;
        }

         if($password!="" && $password2!="")
        {
            if($password!=$password2){
                return redirect()->back()->withErrors('password are not same');
            }
            else
            {
                $new_pass=Hash::make($password);
                $value=array('cityadmin_id'=>$cityadmin_id,'vendor_name'=>$vendor_name,'vendor_logo'=>$vendor_image,'vendor_email'=> $vendor_email,'vendor_phone'=> $vendor_phone, 'vendor_loc'=>$address,'lat'=>$lat,'lng'=>$lng,'owner'=>$owner,'updated_at'=>$updated_at,'vendor_pass'=>$new_pass,'shop_type'=>$shop_type,'admin_share'=>$admin_share,'description'=>$description);
            }
        }
        else
        {
            $value=array('cityadmin_id'=>$cityadmin_id,'vendor_name'=>$vendor_name,'vendor_logo'=>$vendor_image,'vendor_email'=> $vendor_email,'vendor_phone'=> $vendor_phone, 'vendor_pass'=>$new_pass,'vendor_loc'=>$address,'lat'=>$lat,'lng'=>$lng,'owner'=>$owner,'updated_at'=>$updated_at,'shop_type'=>$shop_type,'admin_share'=>$admin_share,'description'=>$description);
        }

        $update = DB::table('vendor')
                 ->where('vendor_id', $vendor_id)
                 ->update($value);

         	   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                 $tec2 = $langs->lang_prefix.'_description';
                $t_des=$request->$tec2;
                   $update2 = DB::table('vendor')
                 ->where('vendor_id', $vendor_id)
                  ->update([$langs->lang_prefix.'_description'=>$t_des]);
                   }

        if($update || $update2){



            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
      }
     else
      {
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
      }
}

  public function deletevendor(Request $request)
    {
     if(Session::has('cityadmin'))
       {

        $vendor_id=$request->id;

        $getfile=DB::table('vendor')
                ->where('vendor_id',$vendor_id)
                ->first();

        $vendor_image=$getfile->vendor_logo;

    	$delete=DB::table('vendor')->where('vendor_id',$request->id)->delete();
        if($delete)
        {

            if(file_exists($vendor_image)){
                unlink($vendor_image);
            }

        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('Unsuccessfull delete');
        }

      }
     else
      {
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
      }

    }

  public function approvevendor(Request $request){
     if(Session::has('cityadmin')){
        $vendor_id=$request->id;
        $vendor = Vendor::where('vendor_id',$vendor_id)->first();
        $vendor->admin_approval = 1;
        $vendor->save();

        return redirect()->back()->withErrors('Vendor Approved Successfully');
      }
     else{
        return redirect()->route('cityadminlogin')->withErrors($this->login_message);
      }

    }


    public function searchvendor(Request $request)
    {

      $this->validate($request,[
         'vendorname' => 'required',
     ]);
      $vendorname=$request->vendorname;

    	if(Session::has('cityadmin'))
          {
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')
            ->where('cityadmin_email',$cityadmin_email)
            ->first();
                    $id=$cityadmin->cityadmin_id;
               If($vendorname!=null && $id!=null){
                  $vendor = $this->getSearch($vendorname,$id);


                  return view('cityadmin.vendor.vendor',compact("cityadmin_email","vendor","cityadmin"));

               }else{

                $vendor= DB::table('vendor')
                ->where('cityadmin_id', $cityadmin->cityadmin_id)
                ->get();
                return view('cityadmin.vendor.vendor',compact("cityadmin_email","vendor","cityadmin"));
                }

          }
        else
             {
                return redirect()->route('cityadminlogin')->withErrors($this->login_message);
             }


    }
    public function getSearch($vendorname,$id)
    {
    if($vendorname!=null && $id!=null){

     $od = DB::table('vendor')
     ->where('cityadmin_id', $id)
     ->where([['vendor_name','=',$vendorname]])->get();
       return $od;
    }
}

        public function vendorsecretlogin(Request $request)
    {
        $id=$request->id;
        $checkcityadminLogin = DB::table('vendor')
    	                   ->where('vendor_id',$id)
    	                   ->first();

    	if($checkcityadminLogin){

           session::put('vendor',$checkcityadminLogin->vendor_email);
           return redirect()->route('vendor-index');

    	}else
         {
         	return redirect()->route('cityadmin')->withErrors('Something Wents Wrong');
         }
    }

}
