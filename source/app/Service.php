<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Notifiable, HasRoles, SoftDeletes;

class Service extends Model
{
    protected $table = 'service';
    protected $primaryKey = 'service_id';
    public $timestamps = false;

    public function varients(){
        return $this->hasMany(ServiceVarient::class,'service_id','service_id');
    }
   
    
}