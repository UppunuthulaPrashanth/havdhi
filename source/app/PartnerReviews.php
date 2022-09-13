<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Notifiable, HasRoles, SoftDeletes;

class PartnerReviews extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function vendor(){
        return $this->hasOne(Vendor::class,'vendor_id','vendor_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
   
    
}