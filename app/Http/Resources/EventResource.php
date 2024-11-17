<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Booking;
use App\Models\Status;
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $status= Status::find($this->status_id);
        $booking= Booking::where('event_id',$this->id)->first();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'type'=>$this->type,
            'status' => $status ? $status->name : null,
            'picture_url'=>$this->picture_url,
            'total_pric'=>$this->price,
            'assessment'=>$this->assessment,
            'start_date' => $booking ? $booking->start_date : null,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }


}

