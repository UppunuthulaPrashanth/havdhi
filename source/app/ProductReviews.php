<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Notifiable, HasRoles, SoftDeletes;

class ProductReviews extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class,'product_id','product_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
   
    
}