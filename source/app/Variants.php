<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variants extends Model
{
    protected $table = 'product_varient';
    protected $primaryKey = 'varient_id';
    public $timestamps = false;

    
}
