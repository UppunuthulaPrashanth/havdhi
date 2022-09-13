<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{

    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    public $timestamps = false;

    public function variant(){
        return $this->hasOne(Variants::class,'varient_id','varient_id');
    }
    
}
