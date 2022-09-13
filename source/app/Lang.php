<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    protected $table = 'langs';
    protected $primaryKey = 'lang_id';
    public $timestamps = false;


}   