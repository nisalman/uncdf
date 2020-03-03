<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class union extends Model
{
    public function upazilas()
    {
        return $this->belongsTo(upazila::class);
    }
}
