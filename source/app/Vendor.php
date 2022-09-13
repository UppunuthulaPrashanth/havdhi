<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'vendor_id';
    public $timestamps = false;
    
    public function getShopTypeAttribute($value)
    {
        if($value==1){
            return 'Male';
        }else if($value==2){
            return 'Female';
        }else if($value==3){
            return 'Unisex';
        }
    }

    public function about(){
        return $this->hasOne(About::class,'vendor_id','vendor_id');
    }
    
}
