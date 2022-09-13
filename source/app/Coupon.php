<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    public $timestamps = false;

    public function vcoupon(){
        return $this->hasMany(CouponVendor::class,'coupon_id','coupon_id');
    }




}