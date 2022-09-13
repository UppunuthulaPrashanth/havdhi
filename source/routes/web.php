<?php
use App\Http\Controllers\Cityadmin\Fcm_Controller;


Route::get('/install_finish', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('key:generate');
	Artisan::call('jwt:secret');
  return redirect()->route('cityadminlogin');
});

Route::get('/clear-all', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

  return redirect()->route('cityadminlogin');
});
/////////////////////////////////////////////////	
/////////////for Vendor//////////////////////
////////////////////////////////////////////////
Route::group(['namespace'=>'Vendor', 'prefix'=>'vendors'],function(){	

	Route::get('orders/{id}','OrderController@orders');
	Route::get('orders_accepted/{id}','OrderController@orders_accepted');
	Route::get('orders_complete/{id}','OrderController@orders_complete');
	Route::get('orders_cancelled/{id}','OrderController@orders_cancelled');

	Route::get('product_orders/{id}','ProductOrderController@orders');
	Route::get('product_orders_accepted/{id}','ProductOrderController@orders_accepted');
	Route::get('product_orders_cancelled/{id}','ProductOrderController@orders_cancelled');

	Route::get('/', 'LoginController@vendorlogin')->name('vendorlogin');
    Route::post('/checklogin', 'LoginController@checkvendorLogin')->name('checkvendor-login');
    Route::get('index', 'HomeController@vendorIndex')->name('vendor-index');
    Route::get('complete_order_index', 'HomeController@complete_order')->name('complete_order_index');
    //Vendor logout
         Route::get('/vendor/edit/{id}','ProfileController@Editvendor')->name('vendor-edit');
      Route::post('update/profile/{id}','ProfileController@vendorUpdateProfile')->name('vendor-update');
      Route::get('logout','ProfileController@vendorLogout')->name('vendor-logout');
	    
	  	// for Galleries
    Route::get('vendorgalleries','BannervendorController@vendorgalleries')->name('vendorgalleries');
    Route::post('vendorgalleries','BannervendorController@vendorgalleriessave')->name('vendorgalleries');

 	      // for banner
         Route::get('bannervendor','BannervendorController@bannervendor')->name('bannervendor');
         Route::get('Addbannervendor','BannervendorController@Addbannervendor')->name('Addbannervendor');
         Route::post('AddNewbannervendor','BannervendorController@AddNewbannervendor')->name('AddNewbannervendor');
         Route::get('Editbannervendor/{id}','BannervendorController@Editbannervendor')->name('Editbannervendor');
         Route::post('Updatebannervendor/{id}','BannervendorController@Updatebannervendor')->name('Updatebannervendor');
         Route::get('deletebannervendor/{id}','BannervendorController@deletebannervendor')->name('deletebannervendor');
         


         // for Products
         
         Route::get('vendor-booking-amount','ProductController@vendor_booking_amount')->name('vendor-booking-amount');

         Route::get('vendorservice','ServiceController@service')->name('vendorservice');
         Route::get('vendoraddservice','ServiceController@Addservice')->name('vendoraddservice');
         Route::get('search_services','ServiceController@search_services')->name('search_services');
         Route::post('vendoraddnewservice','ServiceController@AddNewservice')->name('vendoraddnewservice');
         Route::get('vendoreditservice/{service_id}','ServiceController@Editservice')->name('vendoreditservice');
         Route::post('vendorupdateservice/{service_id}','ServiceController@Updateservice')->name('vendorupdateservice');
         Route::get('vendordeleteservice/{service_id}','ServiceController@vendordeleteservice')->name('vendordeleteservice');
         Route::post('searchproduct','ServiceController@searchproduct')->name('searchproduct');

         
         // for Products variant 
         
          Route::get('varient/{id}','VarientController@varient')->name('varient');
    Route::get('Addproductvariant/{id}','VarientController@Addproductvariant')->name('Addproductvariant');
    Route::post('AddNewproductvariant','VarientController@AddNewproductvariant')->name('AddNewproductvariant');
    Route::get('Editproductvariant/{id}','VarientController@Editproductvariant')->name('Editproductvariant');
    Route::post('Updateproductvariant/{id}','VarientController@Updateproductvariant')->name('Updateproductvariant');
    Route::get('deleteproductvariant/{id}','VarientController@deleteproductvariant')->name('deleteproductvariant');
         
         // for Shop Products

         Route::get('shopproduct','ProductController@shopproduct')->name('shopproduct');
         Route::get('add_shopproduct','ProductController@add_shopproduct')->name('add_shopproduct');
         Route::post('add_shop_new_product','ProductController@add_shop_new_product')->name('add_shop_new_product');
         Route::get('shopdeleteproduct/{product_id}','ProductController@shopdeleteproduct')->name('shopdeleteproduct');
         Route::get('shop_edit_product/{product_id}','ProductController@shop_edit_product')->name('shop_edit_product');
         Route::post('shop_update_product/{product_id}','ProductController@shop_update_product')->name('shop_update_product');



       Route::get('coupon', 'CouponController@allcoupons')->name('coupon');

         
  

        // for staff
      Route::get('staff','staffController@staff')->name('staff');
      Route::get('Addstaff','staffController@Addstaff')->name('Addstaff');
      Route::post('AddNewstaff','staffController@AddNewstaff')->name('AddNewstaff');
      Route::get('Editstaff/{id}','staffController@Editstaff')->name('Editstaff');
      Route::post('Updatestaff/{id}','staffController@Updatestaff')->name('Updatestaff');
      Route::get('deletestaff/{id}','staffController@deletestaff')->name('deletestaff');
                  
          	                         //About Us 
 	   Route::get('aboutus','TermConditionController@aboutus')->name('aboutus');
      Route::post('aboutusupdate/{id}','TermConditionController@aboutusupdate')->name('aboutusupdate');
       
      Route::get('timeslot','TimeSlotController@timeslot')->name('timeslot');
      Route::get('addtimeslot','TimeSlotController@addtimeslot')->name('addtimeslot');
      Route::post('addnewtimeslot','TimeSlotController@addnewtimeslot')->name('addnewtimeslot');
      Route::get('edittimeslot/{id}','TimeSlotController@edittimeslot')->name('edittimeslot');
      Route::post('timeslotupdate','TimeSlotController@timeslotupdate')->name('timeslotupdate');
      Route::get('deletetimeslot/{id}','TimeSlotController@deletetimeslot')->name('deletetimeslot');
	     
	       //for time slot for Staff availability
      Route::get('staff-timeslot','TimeSlotController@staff_timeslot')->name('staff_timeslot');
      Route::get('staff-addtimeslot','TimeSlotController@staff_addtimeslot')->name('staff_addtimeslot');
      Route::post('staff-addnewtimeslot','TimeSlotController@staff_addnewtimeslot')->name('staff_addnewtimeslot');
      Route::get('staff-edittimeslot/{id}','TimeSlotController@staff_edittimeslot')->name('staff_edittimeslot');
      Route::post('staff-timeslotupdate','TimeSlotController@staff_timeslotupdate')->name('staff_timeslotupdate');
      Route::get('staff-deletetimeslot/{id}','TimeSlotController@staff_deletetimeslot')->name('staff_deletetimeslot');


	       //for notification
     Route::get('vendor_notification', 'NotificationController@vendor_notification')->name('vendor-notification');
    Route::get('cityadmindelivery_boy','delivery_boyController@cityadmindelivery_boy')->name('cityadmindelivery_boy');
    
         Route::get('vendorsendrequest/{com_id}','ComissionController@vendorsendrequest')->name('vendorsendrequest');

         Route::get('vendor-earnings','OrderController@vendor_earnings')->name('vendor-earnings');
         Route::get('paid_to_admin','OrderController@paid_to_admin')->name('');
     
    });
    
   
/////////////////////////////////////////////////	
/////////////for city admin//////////////////////
////////////////////////////////////////////////
Route::group(['namespace'=>'Cityadmin', 'prefix'=>'admin'],function(){	
	
	Route::get('/', 'LoginController@cityadminlogin')->name('cityadminlogin');
    Route::post('/checklogin', 'LoginController@checkcityadminLogin')->name('checkcityadmin-login');
  
});
      Route::group(['namespace'=>'Cityadmin', 'prefix'=>'admin'],function(){	
    /// for cityadmin home
      Route::get('index', 'HomeController@cityadminIndex')->name('cityadmin-index');

		// for banner
		Route::get('adminbanner','BannerImagesController@adminbanner')->name('adminbanner');
		Route::get('addadminbanner','BannerImagesController@addadminbanner')->name('addadminbanner');
		Route::post('addadminbanner','BannerImagesController@saveadminbanner')->name('addadminbanner');
		Route::get('editadminbanner/{id}','BannerImagesController@editadminbanner')->name('editadminbanner');
		Route::post('editadminbanner/{id}','BannerImagesController@updateadminbanner')->name('editadminbanner');
		Route::get('deleteadminbanner/{id}','BannerImagesController@deleteadminbanner')->name('deleteadminbanner');
  
		  
		Route::get('faq_list','FaqController@faq_list')->name('faq_list');
		Route::get('faq_add','FaqController@faq_add')->name('faq_add');
		Route::post('faq_add','FaqController@faq_add_save');
		Route::get('faq_edit/{id}','FaqController@faq_edit')->name('faq_edit');
		Route::post('faq_edit/{id}','FaqController@faq_edit_save');
		Route::get('faq_delete/{id}','FaqController@faq_delete')->name('faq_delete');

       

	Route::get('orders/{id}','OrderController@orders');
	Route::get('orders_accepted/{id}','OrderController@orders_accepted');
	Route::get('orders_cancelled/{id}','OrderController@orders_cancelled');

	Route::get('product_orders/{id}','ProductOrderController@orders');
	Route::get('product_orders_accepted/{id}','ProductOrderController@orders_accepted');
	Route::get('product_orders_cancelled/{id}','ProductOrderController@orders_cancelled');

 	    
    //cityadmin logout
      Route::get('logout','ProfileController@adminLogout')->name('cityadmin-logout');
      
        //for notification
    Route::get('UserNotification', 'notificationController@cityadminNotification')->name('cityadminNotification');
    Route::post('cityadminNotificationSend', 'notificationController@cityadminNotificationSend')->name('cityadminNotificationSend');
    
    //for vendor notification
    Route::get('CNotification_to_store', 'notificationController@CNotification_to_store')->name('CNotification_to_store');
    Route::post('CNotification_to_store_Send', 'notificationController@CNotification_to_store_Send')->name('CNotification_to_store_Send');
	 

    //for Terms & Conditions
          Route::get('termcondition','SettingController@termcondition')->name('termcondition');
          Route::post('termcondition_save','SettingController@termcondition_save')->name('termcondition_save');

		Route::get('cookies-policy','SettingController@cookies_policy')->name('cookies_policy');
		Route::post('cookies-policy','SettingController@cookies_policy_save');
		Route::get('privacy-policy','SettingController@privacy_policy')->name('privacy_policy');
		Route::post('privacy-policy','SettingController@privacy_policy_save');

    //for Google APIs
          Route::get('google_apis','SettingController@google_apis')->name('google_apis');
          Route::post('google_apis_save','SettingController@google_apis_save')->name('google_apis_save');
        
 
         

        
          Route::get('vendor','vendorController@vendor')->name('vendor');
          Route::get('vendor/add','vendorController@Addvendor')->name('add-vendor');
          Route::post('vendor/add/new','vendorController@AddNewvendor')->name('AddNewvendor');
          Route::get('vendor/edit/{id}','vendorController@Editvendor')->name('edit-vendor');
          Route::post('vendor/update/{id}','vendorController@Updatevendor')->name('update-vendor');
          Route::get('vendor/delete/{id}','vendorController@deletevendor')->name('delete-vendor');
          Route::get('vendor/approve/{id}','vendorController@approvevendor')->name('approve-vendor');
          Route::post('searchvendor','vendorController@searchvendor')->name('searchvendor');

       //for notification
       Route::get('send_notification', 'notiController@notification1')->name('notificationCA1');
       Route::post('send_notificationstep2', 'notiController@notification2')->name('notificationCA2');
       
    
       
       //vendor_order
  
       Route::get('vendorsecretlogin/{id}','vendorController@vendorsecretlogin')->name('vendorsecretlogin');

                 // for coupon
 	 
     Route::get('couponlist','CouponController@couponlist')->name('couponlist');
     Route::get('addcoupon','CouponController@addcoupon')->name('addcoupon');
     Route::post('addnewcoupon','CouponController@addnewcoupon')->name('addnewcoupon');
     Route::get('editcoupon/{coupon_id}','CouponController@editcoupon')->name('editcoupon');
     Route::post('updatecoupon','CouponController@updatecoupon')->name('updatecoupon');
     Route::get('deletecoupon/{coupon_id}','CouponController@deletecoupon')->name('deletecoupon');
	    
	    
	 Route::get('global_settings','ProfileController@Editadmin')->name('edit-admin');
     Route::post('update/profile/{id}','ProfileController@adminUpdateProfile')->name('update-admin');  
       Route::get('edit_sms_api', 'sms_apiController@edit_sms_api')->name('edit_sms_api');
	 Route::post('update_sms_api', 'sms_apiController@update_sms_api')->name('update_sms_api');
	 Route::post('twilio/update', 'sms_apiController@updatetwilio')->name('updatetwilio');
	 Route::post('msgoff', 'sms_apiController@msgoff')->name('msgoff');
	 
	 //FCM key
	 Route::get('edit_fcm_api', 'FcmController@edit_fcm_api')->name('edit_fcm_api');
	 Route::post('update_fcm_api', 'FcmController@update_fcm_api')->name('update_fcm');
	 // country code
     Route::get('edit_countrycode', 'FcmController@edit_countrycode')->name('edit_countrycode');
	 Route::post('update_countrycode', 'FcmController@update_countrycode')->name('update_countrycode');
	 // firebase
     Route::get('edit_firebase', 'FcmController@edit_firebase')->name('edit_firebase');
	 Route::post('update_firebase', 'FcmController@update_firebase')->name('update_firebase');
	 //payment_mode
	 Route::get('edit_payment_mode', 'paymentviaController@edit_payment_mode')->name('edit_payment_mode');
	 Route::post('update_payment_mode', 'paymentviaController@update_payment_mode')->name('update_payment_mode');
	  
      Route::get('map_api','SettingController@mapsettings')->name('mapapi');
      Route::post('map_api/update','SettingController@updategooglemap')->name('updatemap');
      Route::post('mapbox/update','SettingController@updatemapbox')->name('updatemapbox');
        Route::get('currency','currencyController@currency')->name('currency');
      Route::get('currency/edit/{id}','currencyController@Editcurrency')->name('edit-currency');
      Route::post('currency/update/{id}','currencyController@Updatecurrency')->name('update-currency');
         Route::post('gateway_option/change','paymentviaController@gateway_status')->name('gateway_status');
          Route::post('payment_gateway/update','paymentviaController@updatepymntvia')->name('updategateway');
          Route::get('scratch-earn','ScratchEarnController@adminScratchEarn')->name('adminScratchEarn');
		Route::get('scratch-earn/add','ScratchEarnController@adminScratchEarnAdd')->name('adminScratchEarnAdd');
		Route::post('scratch-earn/add/new','ScratchEarnController@adminScratchEarnAddNew')->name('adminScratchEarnAddNew');
		Route::get('scratch-earn/edit/{id}','ScratchEarnController@adminScratchEarnEdit')->name('adminScratchEarnEdit');
		Route::post('scratch-earn/update/{id}','ScratchEarnController@adminScratchEarnUpdate')->name('adminScratchEarnUpdate');
		Route::get('scratch-earn/delete/{id}','ScratchEarnController@adminScratchEarnDelete')->name('adminScratchEarnDelete');
		 Route::get('allusers','UserController@allusers')->name('allusers');
		  Route::get('user/block/{id}','UserController@block')->name('userblock');
		   Route::get('user/unblock/{id}','UserController@unblock')->name('userunblock');
		  Route::get('user/delete/{id}','UserController@del_user')->name('del_userfromlist');

          
         Route::get('admin-earnings/{vendor_id}','OrderController@admin_earnings')->name('admin-earnings');
         Route::get('paid_to_vendor/{vendor_id}','OrderController@paid_to_vendor')->name('paid_to_vendor');
        
        Route::get('lang_list','LanguageController@lang_list')->name('lang_list');
		Route::get('lang_add','LanguageController@lang_add')->name('lang_add');
		Route::post('lang_add','LanguageController@lang_add_save');
		Route::get('lang_edit/{id}','LanguageController@lang_edit')->name('lang_edit');
		Route::post('lang_edit/{id}','LanguageController@lang_edit_save');
		Route::get('lang_delete/{id}','LanguageController@lang_delete')->name('lang_delete'); 
		Route::post('translate_api_edit','LanguageController@api_edit_save')->name('update_tran_api');
          
      });	