<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    
    public function location()
    {
        return $this->hasOne(BusinessLocation::class);
    }

    public function categories()
    {
        return $this->hasMany(BusinessCategory::class);
    }
}
