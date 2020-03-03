<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mm_profile extends Model
{

    protected $fillable = [
        'id_mm_profile', 'mm_name', 'mm_shopname', 'joining_date',
    ];
}
