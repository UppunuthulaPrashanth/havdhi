<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

	protected $appends = ['statustext'];

	public function getStatustextAttribute()
    {
        $text_status = '';
		if($this->status==0){
            $text_status = 'Pending';
		}else if($this->status==1){
            $text_status = 'Pending';
		}else if($this->status==2){
            $text_status = 'Completed';
		}else if($this->status==3){
            $text_status = 'Payment Failed';
		}else if($this->status==4){
            $text_status = 'Cancelled';
		}else{
            $text_status = 'NA';
		}
        return $text_status;
    }

    public function details(){
        return $this->hasMany(ProductOrderDetails::class,'order_cart_id','cart_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }


    
}