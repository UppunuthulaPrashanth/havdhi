<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  protected $table = 'cart';
  protected $primaryKey = 'cart_id';
    public $timestamps = false;

	public function staff()
    {
        return $this->hasOne(\App\Staff::class,'staff_id','staff_id');
    }
    
}