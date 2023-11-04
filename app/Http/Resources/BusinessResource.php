<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $original = parent::toArray($request);

        $original["transaction"] = json_decode($this->transaction);
        $original["created_at"] = $this->created_at->format('d-m-Y H:i');
        $original["updated_at"] = $this->updated_at->format('d-m-Y H:i');

        $original['categories'] = BusinessCategoryResource::collection($this->categories);
        $original['location'] = BusinessLocationResource::make($this->location);

        return $original;
    }
}
