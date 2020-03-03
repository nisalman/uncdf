<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class division extends Model
{
    public function districts()
    {
        return $this->hasMany(district::class);
    }
    public function upazilas()
    {
        return $this->hasManyThrough(Upazila::class, District::class);
    }

}
