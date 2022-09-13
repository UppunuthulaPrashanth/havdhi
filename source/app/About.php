<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
  protected $table = 'about_us';
  protected $primaryKey = 'id';
    public $timestamps = false;
}