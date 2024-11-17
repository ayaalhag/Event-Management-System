<?php

namespace App\Http\Resources;

use App\Models\Booking;
use App\Models\Place;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EventOneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $place= Place::find($this->place_id);
        $status=Status::find($this->status_id);
        $user=User::find($this->user_id);
        $booking=Booking::where('event_id',$this->id)->first();

        return [
            'id' => $this->id,
            'place_id' => $place ? $place->name : null,
            'type' => $this->type,
            'status_id' => $status ? $status->name : null,
            'user_id' => $user ? $user->name : null,
            'name' => $this->name,
            'picture_url' => $this->picture_url,
            'additions' => $this->additions,
            'nameOnTheCard' => $this->nameOnTheCard,
            'music' => $this->music,
            'assessment'=>$this->assessment,
            'totalPrice' => $this->price,
            'start_date'=>$booking ? $booking->start_date : null,
            'end_date'=>$booking ? $booking->end_date : null,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'part' => EventDetailsResource::collection($this->parts),
            "event_format" => new EventFormatResource($this->eventFormat)

        ];
    }
}
