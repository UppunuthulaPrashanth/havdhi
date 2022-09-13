<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorNotification extends Model
{
    protected $table = 'vendor_notification';
    protected $primaryKey = 'not_id';
    public $timestamps = false;


}