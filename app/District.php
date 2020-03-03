<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }
}
