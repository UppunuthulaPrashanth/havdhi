<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Notifiable, HasRoles, SoftDeletes;

class StaffReviews extends Model
{
    protected $table = 'staff_review';
    protected $primaryKey = 'rev_id';
    public $timestamps = false;

    public function staff(){
        return $this->hasOne(Staff::class,'staff_id','staff_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
   
    
}