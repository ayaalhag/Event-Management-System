<?php

namespace App\Http\Resources;

use App\Models\CategoryPart;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $catgory_part = CategoryPart::find($this->catgory_part_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_name' => $catgory_part ? $catgory_part->name : null,
            'category_part_id'=>$this->catgory_part_id,
            'picture_url' => $this->pictture_url,
            'price' => $this->price,
            'assessment' => $this->assessment,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
