<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

	protected $appends = ['statustext'];

    public function service(){
        return $this->hasOne(Service::class,'service_id','service_id');
    }

    public function varient(){
        return $this->hasOne(ServiceVarient::class,'varient_id','varient_id');
    }

    public function slot(){
        return $this->hasOne(StaffAvailabilityTimeSlot::class,'id','service_time');
    }

    public function items(){
        return $this->hasMany(OrderCart::class,'cart_id','cart_id');
    }

    public function staff(){
        return $this->hasOne(Staff::class,'staff_id','staff_id');
    }

    public function vendor(){
        return $this->hasOne(Vendor::class,'vendor_id','vendor_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function about(){
        return $this->hasOne(About::class,'vendor_id','vendor_id');
    }
    
	public function getStatustextAttribute()
    {
        $text_status = '';
		if($this->status==0){
            $text_status = 'Pending';
		}
		else if($this->status==1){
            $text_status = 'Pending';
		}
		else if($this->status==2){
            $text_status = 'Completed';
		}else if($this->status==3){
            $text_status = 'Payment Failed';
		}else if($this->status==4){
            $text_status = 'Cancelled';
		}else if($this->status==5){
            $text_status = 'Cancelled by Vendor';
		}else if($this->status==6){
            $text_status = 'Confirmed';
		}else{
            $text_status = 'NA';
		}
        return $text_status;
    }

    
}