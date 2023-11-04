<?php

namespace App\Models;

use App\Traits\FilterQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes, FilterQuery;

    protected $guarded = ['id'];

    
    public function location()
    {
        return $this->hasOne(BusinessLocation::class);
    }

    public function categories()
    {
        return $this->hasMany(BusinessCategory::class);
    }

    public function scopeFilterQuery($query)
    {
        return $query->filter(request(['offset', 'limit', 'categories', 'price', 'open_at']));
    }
}
