<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Faqs;


class FaqController extends Controller
{

  private $login_message = 'please login first';

    public function faq_list(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $adminfaq = Faqs::get();
            $lang=DB::table('langs')
                 ->get();
            return view('cityadmin.faq.show_faq',compact("cityadmin_email","adminfaq","cityadmin","lang"));
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function faq_add(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $lang=DB::table('langs')
                 ->get();
            return view('cityadmin.faq.add_faq',compact("cityadmin_email","cityadmin","lang"));
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function faq_add_save(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $adminfaq = new Faqs;
            $adminfaq->question = $request->question;
            $adminfaq->answer = $request->answer;
            $adminfaq->save();
            if( $adminfaq->save()){
              $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_question';
                $t_product_name=$request->$tec; 
                if($t_product_name == NULL){
                    $t_product_name= $request->question;
                }
                 $tec2 = $langs->lang_prefix.'_answer';
                $t_des=$request->$tec2; 
                 if($t_des == NULL){
                    $t_des=$request->answer;
                }
                   $update2 = DB::table('faq')
                 ->where('faq_id',$adminfaq->faq_id)
                  ->update([$langs->lang_prefix.'_question'=>$t_product_name,$langs->lang_prefix.'_answer'=>$t_des]);   
                   }	
       return back()->withErrors('Saved Successfully.');
            }else{
      return back()->withErrors('Something Went Wrong.'); 
            }
           
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function faq_edit(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $faq = Faqs::where('faq_id',$request->id)->first();
            $lang=DB::table('langs')
                 ->get();
            return view('cityadmin.faq.update_faq',compact("cityadmin_email","cityadmin","faq","lang"));
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function faq_edit_save(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $adminfaq = Faqs::where('faq_id',$request->id)->first();
            if(!$adminfaq){
                return back()->withErrors('Invalid ID');
            }
            $adminfaq->question = $request->question;
            $adminfaq->answer = $request->answer;
            $adminfaq->save();
            	   $lang=DB::table('langs')
             ->get();
          foreach($lang as $langs){
                  $tec = $langs->lang_prefix.'_question';
                $t_product_name=$request->$tec; 
                 $tec2 = $langs->lang_prefix.'_answer';
                $t_des=$request->$tec2; 
                   $update2 = DB::table('faq')
                 ->where('faq_id',$request->id)
                  ->update([$langs->lang_prefix.'_question'=>$t_product_name,$langs->lang_prefix.'_answer'=>$t_des]);   
                   }	
            if($adminfaq->save() || $update2){
            return back()->withErrors('Updated Successfully.');
            }else{
              return back()->withErrors('Something wents wrong.');  
            }
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function faq_delete(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $faq = Faqs::where('faq_id',$request->id)->delete();
            return back()->withErrors('Deleted Successfully.');
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
	

}

