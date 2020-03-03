<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class upazila extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function unions()
    {
        return $this->hasMany(union::class);
    }
}
