<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api', 'prefix'=>''],function(){	
   Route::post('signup', [UserController::class,'signUp']);
    Route::post('verify_via_firebase', [UserController::class,'verifyotpfirebase']);
    Route::post('social_login', [UserController::class,'social_login']);
    Route::get('validate', [UserController::class,'validates'])->name('login');
    Route::post('login_with_email', [UserController::class,'login_with_email']);
    Route::post('login_with_phone', [UserController::class,'login_with_phone']);
    Route::post('login_verifyotpfirebase', [UserController::class,'login_verifyotpfirebase']);
     Route::post('forget_password', 'UserController@forgotPassword');
    Route::post('verify_otp', 'UserController@verifyOtp');
    Route::post('change_password', 'UserController@changePassword');
   
    
    Route::post('getnearbysalons', 'ServicesController@getnearbysalons');
    Route::post('services', 'ServicesController@services');
    Route::post('getnearbanner', 'ServicesController@getnearbanner');
    Route::post('popular_barber', 'ServicesController@popular_barber');
    Route::post('salon_desc', 'VendorController@salon_desc');
    Route::post('similar_salon', 'VendorController@similar_salon');
    Route::post('salon_products', 'VendorproductController@salon_products');
    Route::post('service_salons', 'VendorproductController@service_salons');
    Route::post('barber_desc', 'BarberController@barber_desc');
    Route::post('product_det', 'BarberController@product_desc');
    
     Route::get('terms', 'PagesController@terms');
    
    Route::get('mapby','MapsetController@mapby');
    Route::get('google_map','MapsetController@google_map');
    Route::get('mapbox','MapsetController@mapbox');
         //currency//
     Route::get('currency', 'CurrencyController@currency');
    
      Route::get('delete_all_user_data', [UserController::class,'del_users']);   
       Route::get('cookies', 'PagesController@cookies');
        Route::get('privacy', 'PagesController@privacy');
        Route::post('product_orders', 'CartController@ongoing');
         Route::post('all_booking', 'BookingController@ongoing');
       Route::get('refer_n_earn', 'MapsetController@referral');
        Route::get('langlist', 'CurrencyController@langlist');
       
});
Route::group(['namespace'=>'Api','middleware' => 'jwt.verify', 'prefix'=>''],function(){	
    Route::post('myprofile', [UserController::class,'myprofile']);
     Route::post('profile_edit', 'UserController@profile_edit');
     Route::post('add_salon_rating', 'RatingController@add_salon_rating');
    Route::post('add_staff_rating', 'RatingController@add_staff_rating');
    Route::post('add_product_rating', 'RatingController@add_product_rating');
    Route::post('book_now', 'BookingController@book_now');
       /////time slot////// 
     Route::post('timeslot', 'TimeslotController@timeslot');
     Route::get('payment_gateways', 'CurrencyController@gatewaysettings'); 
     Route::post('apply_coupon_or_rewards', 'CouponController@apply_coupon');
    Route::post('couponlist', 'CouponController@coupon_list');
    Route::post('checkout', 'BookingController@checkout');
    Route::post('getnearcouponlist', 'CouponController@getnearcouponlist');
     Route::post('booking_appointment', 'BookingController@vendor_desc');
   
     Route::post('add_to_cart', 'CartController@add_to_cart');
     Route::post('show_cart', 'CartController@show_cart');
     Route::post('del_frm_cart', 'CartController@del_frm_cart');
   Route::post('clear_cart', 'CartController@clear_cart');
   Route::post('product_cart_checkout', 'CartController@cart_checkout');
   Route::get('cancel_reasons', 'BookingController@cancel_for');
   Route::post('cancel_booking', 'BookingController@delete_order');
     
     Route::post('cancel_product_orders', 'CartController@delete_order');
           //notifications//
     Route::post('allnotifications', 'NotificationController@notificationlist');
     Route::post('read_by_user', 'NotificationController@read_by_user');
     Route::post('mark_all_read', 'NotificationController@mark_all_as_read');
     Route::post('delete_all_notifications', 'NotificationController@delete_all'); 
      Route::post('user_scratch_cards', 'RewardController@scratchCard');
     Route::post('scratch', 'RewardController@userReward'); 
     Route::post('add_to_fav', 'FavouriteController@add_to_favourites');
     Route::post('show_fav', 'FavouriteController@show_fav');
  
});


Route::group(['namespace'=>'Partner', 'prefix'=>'partner'],function(){	

     Route::post('partner_login', 'PartnerController@login');
     Route::post('partner_register', 'PartnerController@partner_reg');
     Route::post('partner_profile', 'PartnerController@partner_profile');
     Route::post('update_profile', 'PartnerController@update_profile');
     Route::post('profile_change_password', 'PartnerController@profile_change_password');
     Route::post('forget_password', 'PartnerController@forget_password');
     Route::post('verifyOtp', 'PartnerController@verifyOtp');
     Route::post('change_password', 'PartnerController@change_password');

     Route::post('add_expert', 'ExpertController@add');
     Route::post('list_expert', 'ExpertController@list');
     Route::post('edit_expert', 'ExpertController@edit');
     Route::post('delete_expert', 'ExpertController@delete');
     Route::post('list_service', 'ServiceController@list');
     Route::post('add_service', 'ServiceController@add');
     Route::post('edit_service', 'ServiceController@edit');
     Route::post('delete_service', 'ServiceController@delete');
     Route::post('list_servicevariant', 'ServiceController@list_servicevariant');
     Route::post('add_servicevariant', 'ServiceController@add_servicevariant');
     Route::post('edit_servicevariant', 'ServiceController@edit_servicevariant');
     Route::post('delete_servicevariant', 'ServiceController@delete_servicevariant');
     Route::post('list_gallery', 'GalleryController@list');
     Route::post('add_gallery', 'GalleryController@add');
     Route::post('delete_gallery', 'GalleryController@delete');
     Route::post('list_coupon', 'CouponController@list');
     Route::post('add_coupon', 'CouponController@add');
     Route::post('edit_coupon', 'CouponController@edit');
     Route::post('delete_coupon', 'CouponController@delete');
     Route::post('appointments', 'AappointmentController@list');
    Route::post('appointment_history', 'OrderController@appointment_history');
    Route::post('pending_orders', 'OrderController@pending_orders');
    Route::post('completed_orders', 'OrderController@completed_orders');
    Route::post('payment_failed_orders', 'OrderController@payment_failed_orders');
    Route::post('cancelled_orders', 'OrderController@cancelled_orders');
    Route::post('cancelled_by_partner_orders', 'OrderController@cancelled_by_partner_orders');
    Route::post('booking_details', 'OrderController@booking_details');
    Route::post('booking_cancel', 'OrderController@booking_cancel');
    Route::post('booking_confirm', 'OrderController@booking_confirm');
    Route::post('booking_complete', 'OrderController@booking_complete');
    Route::post('home_page', 'OrderController@home_page');
    Route::post('earnings', 'OrderController@vendor_earnings');
    Route::post('paid_to_admin', 'OrderController@paid_to_admin');

    Route::post('notifications', 'NotificationController@notifications');
    Route::post('product_list','ProductController@product_list');
    Route::post('product_add','ProductController@product_add');
    Route::post('product_edit','ProductController@product_edit');
    Route::post('product_delete','ProductController@product_delete');
     Route::post('wallet', 'WalletController@wallet');
     Route::post('wallet_admin_share', 'WalletController@wallet_admin_share');
     Route::post('wallet_vedonr_share', 'WalletController@wallet_vedonr_share');
     Route::post('currency', 'SettingController@currency');
     Route::post('faqs', 'SettingController@faqs');

     Route::post('product_orders', 'ProductOrderController@product_orders');
     Route::post('product_orders_complete', 'ProductOrderController@complete_order');

     Route::post('privacy_policy', 'SettingController@privacy_policy');
     Route::post('shop_setting', 'SettingController@shop_setting');
     
      Route::get('vendor_verify', 'PartnerverifyController@partner_verify');
     Route::get('vendor_delete', 'PartnerverifyController@vendor_delete');
        Route::post('partner_reviews', 'ReviewsController@partner_reviews');
     Route::post('expert_reviews', 'ReviewsController@expert_reviews');
     Route::post('product_reviews', 'ReviewsController@product_reviews');
      Route::post('product_orders_cancel', 'ProductOrderController@product_orders_cancel');
   
});
