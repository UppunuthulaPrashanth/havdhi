<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponVendor extends Model
{
    protected $table = 'coupon_vendor';
    protected $primaryKey = 'coupon_vendor_id';
    public $timestamps = false;

}