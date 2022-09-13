<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrderDetails extends Model
{
    protected $table = 'product_order_details';
    protected $primaryKey = 'store_order_id';
    public $timestamps = false;

	protected $appends = ['statustext', 'product_name', 'description'];
    

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


    public function vendor(){
        return $this->hasOne(Vendor::class,'vendor_id','vendor_id');
    }

    public function order(){
        return $this->hasOne(ProductOrder::class,'cart_id','order_cart_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getProductNameAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['product_name'] = $this->attributes[request()->lang.'_product_name'];
        }else{
            return $this->attributes['product_name'];
        }
    }

    public function getDescriptionAttribute()
    {
        $lang = \App\Lang::where('lang_prefix',request()->lang)->first();
        if($lang){
            return $this->attributes['description'] = $this->attributes[request()->lang.'_description'];
        }else{
            return $this->attributes['description'];
        }
    }


}