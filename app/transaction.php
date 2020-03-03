<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    //protected $table = "transaction";
    protected $fillable = [
        'id_mm', 'is_order_completed', 'reference','amount','commision','district_id','upazila_id','union_id','joining_date','is_active'
    ];
}
