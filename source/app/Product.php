<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

   public $fillable = ['subcat_id','product_name', 'mrp', 'price', 'subscription_price','qty', 'product_image','description', 'stock', 'unit', 'created_at', 'updated_at'];

   public function subcat(){
        return $this->hasOne(Subcat::class,'subcat_id','subcat_id');
    }

}