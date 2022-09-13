<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{
  protected $table = 'order_cart';
  protected $primaryKey = 'order_cart_id';
    public $timestamps = false;

    public function service(){
        return $this->hasOne(Service::class,'service_id','service_id');
    }

    public function vendor(){
        return $this->hasOne(Vendor::class,'vendor_id','vendor_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

	public function staff()
    {
        return $this->hasOne(\App\Staff::class,'staff_id','staff_id');
    }
    
	protected $appends = ['varient','service_name'];
    
    public function getVarientAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['varient'] = $this->attributes[request()->lang.'_varient'];
        }else{
            return $this->attributes['varient'];
        }
    }
    
    public function getServiceNameAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['service_name'] = $this->attributes[request()->lang.'_service_name'];
        }else{
            return $this->attributes['service_name'];
        }
    }

    
}