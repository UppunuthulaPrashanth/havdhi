<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Lang;


class LanguageController extends Controller
{

  private $login_message = 'please login first';

    public function lang_list(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $adminlang = Lang::get();
            $getapi = DB::table('google_translate_api')
                    ->first();
            return view('cityadmin.langs.show_lang',compact("cityadmin_email","adminlang","cityadmin","getapi"));
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function lang_add(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            return view('cityadmin.langs.add_lang',compact("cityadmin_email","cityadmin"));
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function lang_add_save(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $l_p=$request->lang_prefix;
            $l_n=$request->lang_name;
            $test=Lang::where('lang_prefix',$l_p)->orWhere('lang_name',$l_n)->first();
            if($test){
              return back()->withErrors('language name or language prefix already used.');     
            }
            $adminlang = new Lang;
            $adminlang->lang_name = $request->lang_name;
            $adminlang->lang_prefix = $request->lang_prefix;
            $adminlang->save();
            
            if($adminlang->save()){
                  $api= DB::table('google_translate_api')
               ->first();
 ///add columns to database//// 
             Schema::table('shop_product', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                   
                    $table->string($request->lang_prefix.'_product_name')->collation('utf8mb4_unicode_ci')->nullable();
                     $table->longText($request->lang_prefix.'_description')->collation('utf8mb4_unicode_ci')->nullable();
                     
                }); 
                
           
             Schema::table('service', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_service_name')->collation('utf8mb4_unicode_ci')->nullable();
                });
                
           
            
            Schema::table('service_varient', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_varient')->collation('utf8mb4_unicode_ci')->nullable();
                    $table->string($request->lang_prefix.'_service_name')->collation('utf8mb4_unicode_ci')->nullable();
                }); 
                
           
                
            Schema::table('staff_profile', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->longText($request->lang_prefix.'_staff_description')->collation('utf8mb4_unicode_ci')->nullable();
                    
                });
                
           
                
                
              Schema::table('faq', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_question')->collation('utf8mb4_unicode_ci')->nullable();
                    $table->longText($request->lang_prefix.'_answer')->collation('utf8mb4_unicode_ci')->nullable();
                    
                });
                     
                
                    
            Schema::table('termcondition', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->longText($request->lang_prefix.'_termcondition')->collation('utf8mb4_unicode_ci')->nullable();
                    
                }); 
                
              
            
              Schema::table('cookies_policy', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->longText($request->lang_prefix.'_cookies_policy')->collation('utf8mb4_unicode_ci')->nullable();
                    
                }); 
                
             
           
            
            
                Schema::table('coupon', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_coupon_name')->collation('utf8mb4_unicode_ci')->nullable();
                    $table->longText($request->lang_prefix.'_coupon_description')->collation('utf8mb4_unicode_ci')->nullable();
                });
             
                
                Schema::table('privacy_policy', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->longText($request->lang_prefix.'_privacy_policy')->collation('utf8mb4_unicode_ci')->nullable();
                    
                }); 
                
            Schema::table('vendor', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->longText($request->lang_prefix.'_description')->collation('utf8mb4_unicode_ci')->nullable();
                    
                }); 
                
                
                
              Schema::table('order_cart', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_varient')->collation('utf8mb4_unicode_ci')->nullable();
                    $table->string($request->lang_prefix.'_service_name')->collation('utf8mb4_unicode_ci')->nullable();
                });
             
              Schema::table('product_order_details', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_product_name')->collation('utf8mb4_unicode_ci')->nullable();
                     $table->longText($request->lang_prefix.'_description')->collation('utf8mb4_unicode_ci')->nullable();
                     
                });
                
              
                 Schema::table('wishlist', function($table)
                {
                    $request=Lang::latest('lang_id')->first();
                    $table->string($request->lang_prefix.'_product_name')->collation('utf8mb4_unicode_ci')->nullable();
                     $table->longText($request->lang_prefix.'_description')->collation('utf8mb4_unicode_ci')->nullable();
                     
                });
                
           
 ///add columns to database////                 
            return back()->withErrors('Saved Successfully.');
            }else{
             return back()->withErrors('Something Wents Wrong.');   
            }
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    

    
    public function api_edit_save(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $api=DB::table('google_translate_api')
                ->update(['api_key'=>$request->api_key]);
            if($api){
            return back()->withErrors('Updated Successfully.');
            }else{
                return back()->withErrors('Something wents wrong.');
            }
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
    
    public function lang_delete(Request $request){
    	if(Session::has('cityadmin')){
            $cityadmin_email=Session::get('cityadmin');
            $cityadmin=DB::table('cityadmin')->where('cityadmin_email',$cityadmin_email)->first();
            $lang = Lang::where('lang_id',$request->id)->first();
            $l_p = $lang->lang_prefix;
            
             $langs = Lang::where('lang_id',$request->id)->delete();
            if($langs){
            Schema::table('shop_product', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_product_name');
                     $table->dropColumn($l_p.'_description');
                }); 
               
             Schema::table('service', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_service_name');
                }); 
            
            Schema::table('service_varient', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_varient');
                     $table->dropColumn($l_p.'_service_name');
                }); 
                
            Schema::table('staff_profile', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_staff_description');
                });
                    
            Schema::table('termcondition', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_termcondition');
                }); 
                
            Schema::table('vendor', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_description');
                }); 
                
              Schema::table('order_cart', function($table) use($l_p)
                {
                     $table->dropColumn($l_p.'_varient');
                     $table->dropColumn($l_p.'_service_name');
                
                });
                
              Schema::table('product_order_details', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_product_name');
                     $table->dropColumn($l_p.'_description');
                     
                }); 
             Schema::table('faq', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_question');
                     $table->dropColumn($l_p.'_answer');
                    
                });
              Schema::table('coupon', function($table) use($l_p)
                {
                     $table->dropColumn($l_p.'_coupon_name');
                     $table->dropColumn($l_p.'_coupon_description');
                
                });
                  Schema::table('cookies_policy', function($table) use($l_p)
                {
                     $table->dropColumn($l_p.'_cookies_policy');
                
                });
                  Schema::table('privacy_policy', function($table) use($l_p)
                {
                     $table->dropColumn($l_p.'_privacy_policy');
                
                });
                 Schema::table('wishlist', function($table) use($l_p)
                {
                    $table->dropColumn($l_p.'_product_name');
                     $table->dropColumn($l_p.'_description');
                     
                }); 
            
            return back()->withErrors('Deleted Successfully.');
            }else{
                  return back()->withErrors('Something went wrong.');
            }
        }else {
            return redirect()->route('cityadminlogin')->withErrors($this->login_message);
        }
    }
	

}


