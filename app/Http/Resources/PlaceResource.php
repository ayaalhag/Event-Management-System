<?php

namespace App\Http\Resources;

use App\Models\CategoryPlace;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $catgory_palce = CategoryPlace::find($this->category_place_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location'=>$this->location,
            'phone'=>$this->phone,
            'category_name' => $catgory_palce ? $catgory_palce->name : null,
            'category_place_id'=>$this->category_place_id,
            'picture_url' => $this->pictture_url,
            'assessment' => $this->assessment,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
