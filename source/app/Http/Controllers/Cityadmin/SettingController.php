<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use Carbon\Carbon;

class SettingController extends Controller
{

	public function termcondition(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
        $lang=DB::table('langs')
             ->get();
        $termcondition = DB::table('termcondition')->first();

        return view('cityadmin.termcondition',compact("cityadmin_email","cityadmin","termcondition","lang"));
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }

	public function termcondition_save(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

        $termcondition = DB::table('termcondition')->update(['termcondition'=>$request->termcondition]);
        	   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_termcondition';
                $t_product_name=$request->$tec;

                   $update2 = DB::table('termcondition')
                  ->update([$langs->lang_prefix.'_termcondition'=>$t_product_name]);
                   }
		if($termcondition || $update2){
		return back()->withErrors('Saved successfully');
        }else{
         return back()->withErrors('Something wents wrong');
        }
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }


	public function google_apis(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

		$map_settings = DB::table('map_settings')->first();
		$map_api = DB::table('map_api')->first();
		$mapbox = DB::table('mapbox')->first();

        return view('cityadmin.google_apis',compact("cityadmin_email","cityadmin","map_api","map_settings","mapbox"));
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }

	public function google_apis_save(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

		if($request->map_api_type=='mapbox'){
			$map_settings = DB::table('map_settings')->update(['mapbox'=>1,'google_map'=>0]);
		}
		if($request->map_api_type=='google_map'){
			$map_settings = DB::table('map_settings')->update(['mapbox'=>0,'google_map'=>1]);
		}
		$map_api = DB::table('map_api')->update(['map_api_key'=>$request->map_api_key]);
		$mapbox = DB::table('mapbox')->update(['mapbox_api'=>$request->mapbox_api]);

		return back()->with('message','Saved');
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }

      public function mapsettings(Request $request)
    {

        $admin_email=Session::get('admin');
        $admin=DB::table('admin')
        ->where('admin_email',$admin_email)
        ->first();

          $g = DB::table('map_api')
                ->first();
          $m = DB::table('mapbox')
                ->first();
          $mset = DB::table('map_settings')
                ->first();
         return view('admin.map',compact("admin_email","admin",'g','m','mset'));
    }




    public function updategooglemap(Request $request)
    {

        $api_key = $request->api;
        $this->validate(
            $request,
                [
                    'api'=>'required',
                ],
                [
                    'api.required' =>'Enter api key',
                ]
        );


        $check = DB::table('map_api')
               ->first();


      if($check){
        $update = DB::table('map_api')
                ->update(['map_api_key'=> $api_key]);

      }
      else{
          $update = DB::table('map_api')
                ->insert(['map_api_key'=> $api_key]);

      }
       $ue = DB::table('map_settings')
                ->update(['mapbox'=> 0,'google_map'=> 1]);
     if($ue){

        return redirect()->back()->withSuccess('Updated Successfully');
     }
     else{
         return redirect()->back()->withErrors('Nothing to Update');
     }
    }

    public function updatemapbox(Request $request)
    {

        $mapbox = $request->mapbox;
        $this->validate(
            $request,
                [
                    'mapbox' => 'required'
                ],
                [
                    'mapbox.required' => 'Enter Mapbox API.',
                ]
        );


        $check = DB::table('mapbox')
               ->first();


      if($check){


        $update = DB::table('mapbox')
                ->update(['mapbox_api'=> $mapbox]);

      }
      else{
          $update = DB::table('mapbox')
                ->insert(['mapbox_api'=> $mapbox]);
      }
       $ue = DB::table('map_settings')
            ->update(['mapbox'=> 1,'google_map'=> 0]);

     if($ue){

        return redirect()->back()->withSuccess('Updated Successfully');
     }
     else{
         return redirect()->back()->withErrors('Nothing to Update');
     }
    }


/*============ cookies policy and privacy policy =================*/



	public function cookies_policy(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

        $cookies_policy = DB::table('cookies_policy')->first();
        $lang=DB::table('langs')
             ->get();
        return view('cityadmin.cookies_policy',compact("cityadmin_email","cityadmin","cookies_policy","lang"));
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }

	public function cookies_policy_save(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

        $cookies_policy = DB::table('cookies_policy')->update(['cookies_policy'=>$request->cookies_policy]);
          $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_cookies_policy';
                $t_product_name=$request->$tec;

                   $update2 = DB::table('cookies_policy')
                  ->update([$langs->lang_prefix.'_cookies_policy'=>$t_product_name]);
                   }
	if($cookies_policy || $update2){
		return back()->withErrors('Saved successfully');
        }else{
         return back()->withErrors('Something wents wrong');
        }
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }


	public function privacy_policy(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
        $lang=DB::table('langs')
             ->get();
        $privacy_policy = DB::table('privacy_policy')->first();

        return view('cityadmin.privacy_policy',compact("cityadmin_email","cityadmin","privacy_policy","lang"));
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }

	public function privacy_policy_save(Request $request){
     if(Session::has('cityadmin')){
        $cityadmin_email = Session::get('cityadmin');
        $cityadmin = DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();

        $privacy_policy = DB::table('privacy_policy')->update(['privacy_policy'=>$request->privacy_policy]);
         $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_privacy_policy';
                $t_product_name=$request->$tec;

                   $update2 = DB::table('privacy_policy')
                  ->update([$langs->lang_prefix.'_privacy_policy'=>$t_product_name]);
                   }
        if($privacy_policy || $update2){
		return back()->withErrors('Saved successfully');
        }else{
         return back()->withErrors('Something wents wrong');
        }
     }else{
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }




}
