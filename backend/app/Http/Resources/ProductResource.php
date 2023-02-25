<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'details'     => $this->details,
            'price'       => $this->price,
            'image'       => asset($this->image),
            'category'    => $this->category->name,
            'category_id' => $this->category_id,
            'user'        => $this->user->name,
            'created_at'  => date('jS F, Y', strtotime($this->created_at)),
        ];
    }
}
