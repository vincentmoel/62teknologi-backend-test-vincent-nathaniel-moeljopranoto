<?php

namespace App\Traits;

use Carbon\Carbon;

trait FilterQuery
{
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['offset'] ?? false, function ($query, $offset) use ($filters) {

            $filters['limit'] = $filters['limit'] ?? 1;

            return $query->offset($offset)->limit($filters['limit']);
        });

        $query->when($filters['limit'] ?? false, function ($query, $limit) use ($filters) {

            return $query->limit($filters['limit']);
        });

        $query->when($filters['categories'] ?? false, function ($query, $categories) use ($filters) {

            $categories = explode(",", $categories);
            
            return $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('alias', $categories);
            });
        });
        
        $query->when($filters['price'] ?? false, function ($query, $price) use ($filters) {

            $price = array_map(function ($number) {
                return str_repeat('$', $number);
            }, explode(",", $price));

            return $query->whereIn('price', $price);
        });

        $query->when($filters['open_at'] ?? false, function ($query, $openAt) use ($filters) {

            $unixTimestamp = Carbon::createFromTimestamp($openAt);
            $currentTime = $unixTimestamp->format('H:i:s');

            return $query->where('open_time', '=', $currentTime);

        });



        $query->when($filters['orderBy'] ?? false, function ($query, $orderBy) use ($filters) {

            $filters['orderBy'] = json_decode($filters['orderBy']);
            foreach ($filters['orderBy'] as $orderBy) {
                $query->orderBy($orderBy[0], $orderBy[1]);
            }

            return $query;
        });

        $query->when($filters['filter'] ?? false, function ($query, $filter) use ($filters) {

            $filters['filter'] = json_decode($filters['filter']);

            $query = $query->where($filters['filter']);

            return $query;
        });
    }
}
