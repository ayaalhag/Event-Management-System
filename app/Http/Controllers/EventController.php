<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEventRequest;
use App\Http\Requests\DeleteEventRequest;
use App\Http\Requests\EditEventRequest;
use App\Http\Requests\StatusEventRequest;
use App\Http\Resources\EventOneResource;
use App\Http\Resources\EventResource;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Part;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends BaseController
{
    public function ShowAll()
    {
        $events = Event::all();
        $modifiedEvents = [];
        foreach ($events as $event) {
            $booking = $event->bookings()->first();
             $cost = $booking->calculateCost();
            $totalPrice = $event->calculateCost();
            $event->price = $totalPrice + $cost;
            $modifiedEvents[] = $event;
        }
        $eventResources = EventResource::collection($modifiedEvents);
        return $this->sendResponse($eventResources, "Events:");
    }

    //top done
    public function showById(DeleteEventRequest $request)
    {
        $event = Event::find($request->event_id);
        $booking = $event->bookings()->first();
        $cost = $booking->calculateCost();
        $totalPrice = $event->calculateCost();
        $event->price = $totalPrice + $cost;
        $eventResource = new EventOneResource($event);
        return $this->sendResponse($eventResource, "done");
    }
    public function showBystatus(StatusEventRequest $request)
    {
        if ($request->input('name') == 'Completed') {
            $status_name = $request->input('name');
            $status_id = Status::where('name', $status_name)->value('id');
            $user = auth()->user();
            $events = $user->events->where('status_id', $status_id);
        } else if ($request->input('name') == 'notCompleted') {
            $status_id = Status::where('name', 'Completed')->value('id');
            $user = auth()->user();
            $events = $user->events()->whereNotIn('status_id', [$status_id])->get();
        }

        $modifiedEvents = [];
        foreach ($events as $event) {
            $booking = $event->bookings()->first();
            $cost = $booking->calculateCost();
            $totalPrice = $event->calculateCost();
            $event->price = $totalPrice + $cost;
            $modifiedEvents[] = $event;
        }
        $eventResource = EventResource::collection($modifiedEvents);
        return $this->sendResponse($eventResource, "done");
    }
    public function add(AddEventRequest $request)
    {
        $overlappingBookings = null;
        $event = null;
        DB::transaction(function () use ($request, &$event, &$overlappingBookings) {
            $status_id = Status::where('name', 'Sent')->value('id');
            $event = Event::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'status_id' => $status_id,
                'place_id' => $request->place_id,
                'name' => $request->name,
                'additions' => $request->additions,
                'nameOnTheCard' => $request->nameOnTheCard,
                'music' => $request->music,
                'assessment' => '0',
            ]);

            $bookingData = $request->input('booking');
            $bookingData['place_id'] = $request->input('place_id');
            $bookingData['event_id'] = $event->id;
            $overlappingBookings = Booking::where('place_id', $bookingData['place_id'])
                ->whereBetween('start_date', [$bookingData['start_date'], $bookingData['end_date']])
                ->orWhereBetween('end_date', [$bookingData['start_date'], $bookingData['end_date']])
                ->first();
            if ($overlappingBookings) {
                throw new \Exception('There is already a booking for this place at the same time.');
            }
            $booking = Booking::create($bookingData);
            $cost = $booking->calculateCost();
            $totalPrice = 0;
            $parts = $request->input('parts', []);
            foreach ($parts as $part) {
                $partInstance = Part::find($part['id']);
                $event->parts()->attach($partInstance->id, ['number' => $part['number']]);
                $totalPrice += $partInstance->price * $part['number'];
            }
            $event->save();
            $event['price'] = $totalPrice + $cost;
            $user = User::findOrFail($request->user_id);
            if ($user->balance <= $event['price']) {
                throw new \Exception('Insufficient balance to create the event.');
            }
            return $event;
        });
        $eventResource = new EventOneResource($event);
        return $this->sendResponse($eventResource, 'Event created successfully.');
    }
    public function delete(DeleteEventRequest $request)
    {
        $event = Event::where('id', $request->event_id)->first()->delete();
        return $this->sendResponse(null, "delete done");
    }

    public function edit(EditEventRequest $request)
    {
        $validatedData = $request->validated();
        $updateData = array_intersect_key($validatedData, array_flip([
            'place_id',
            'name',
            'additions',
            'nameOnTheCard',
            'music',
            'assessment',
        ]));
        $event = Event::where('id', $request->event_id)->first();
        DB::transaction(function () use ($request, &$event, &$updateData) {
            $event->update($updateData);
            if ($request->has('booking') || $request->has('place_id')) {
                $bookingData = $request->input('booking', []);
                $booking = $event->bookings()->first();
                if (!$request->has('booking') && $request->has('place_id')) {
                    $bookingData['start_date'] = $booking->start_date;
                    $bookingData['end_date'] = $booking->end_date;
                }
                $bookingData['place_id'] = $event->place_id;
                $bookingData['event_id'] = $event->id;
                $startTime = $bookingData['start_date'];
                $endTime = $bookingData['end_date'];
                $overlappingBookings = Booking::where('place_id', $bookingData['place_id'])
                    ->where('event_id', '!=', $event->id)
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->whereBetween('start_date', [$startTime, $endTime])
                            ->orWhereBetween('end_date', [$startTime, $endTime]);
                    })->first();
                if ($overlappingBookings) {
                    throw new \Exception('There is already a booking for this place at the same time.');
                }
                $booking = $event->bookings()->first();
                $booking->update($bookingData);
            }
            if ($request->has('parts')) {
                $parts = $request->input('parts', []);
                $event->parts()->sync($parts);
            }
            $event->save();
            $cost = $event->bookings()->first()->calculateCost();
            $totalPrice = $event->calculateCost();
            $event['price'] = $totalPrice + $cost;
            $user = User::findOrFail($request->user_id);
            if ($user->balance <= $event['price']) {
                throw new \Exception('Insufficient balance to create the event.');
            }
            return $event;
        });

        $eventResource = new EventOneResource($event);
        return $this->sendResponse($eventResource, "Edited successfully");
    }
    public function addImge(EditEventRequest $request)
    {
        if ($request->hasFile('picture_url')) {
            $ext = $request->file('picture_url')->getClientOriginalExtension();
            $path = 'picture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('picture_url')->move(public_path($path), $name);
            $picture_url = $path . $name;

            Event::where('id', $request->event_id)->update([
                'picture_url' => $picture_url,
            ]);
            $event = Event::find($request->event_id);
            $data['event'] = new EventOneResource($event);
            return $this->sendResponse($event, "Edited successfully");
        } else {
            return $this->sendError("not found img");
        }

        // if ($request->hasFile("picture_url")) {
        //     $image = $request->file('picture_url');
        //     $imgpath = $image->store('images', 'public');
        //     Event::where('id', $request->event_id)->update([
        //         'picture_url' => $imgpath,
        //     ]);
        //     $event = Event::find($request->event_id);
        //     $data['event'] = new EventOneResource($event);
        //     return $this->sendResponse($event, "Edited successfully");
        // } else {
        //     return $this->sendError("not found img");
        // }
    }

    public function searchByTypeLike(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json([
                'status' => 400,
                'message' => 'search term is required',
            ]);
        }

        $events = Event::where('type', 'LIKE', "%{$search}%")->get();

        return response()->json([
            'status' => 200,
            'message' => 'Events retrieved successfully',
            'events' => $events
        ]);
    }

}
