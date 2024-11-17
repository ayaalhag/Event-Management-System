<?php

namespace App\Http\Resources;

use App\Models\CategoryPart;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categoryPart= CategoryPart::find($this->catgory_part_id);
        return [
            "id"=>$this->catgory_part_id ,
            'catgory_part'=>$categoryPart ? $categoryPart->name : null,
            "name"=>$this->name ,
            "price"=>$this->price ,
            "pictture_url"=>$this->pictture_url ,
            "number"=>$this->pivot-> number,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            "event_format" => new EventFormatResource($this->eventFormat)
        ];
       
    }
}
