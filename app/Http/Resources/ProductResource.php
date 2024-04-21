<?php

namespace App\Http\Resources;

use App\Models\Variant;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    //variants
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'variants'=> VariantResource::collection($this->variants),
        ];
    }
}
