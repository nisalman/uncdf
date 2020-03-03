<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onboard_mm extends Model
{
    //protected $table = "onboard_mms";
    protected $fillable = [
        'id_mm', 'id_profile', 'division_id','district_id','upazila_id','union_id','joining_date','is_active'
    ];
}
