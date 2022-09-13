<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffAvailabilityTimeSlot extends Model
{
    protected $table = 'staff_availability_time_slot';
    protected $primaryKey = 'id';
    public $timestamps = false;

    
}