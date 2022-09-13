<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff_profile';
    protected $primaryKey = 'staff_id';
    public $timestamps = false;

    
}
