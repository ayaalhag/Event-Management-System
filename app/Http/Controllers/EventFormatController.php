<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteEventRequest;
use App\Http\Resources\EventFormatResource;
use App\Models\Event;
use App\Models\EventFormat;

class EventFormatController extends BaseController
{
    public function show(DeleteEventRequest $request)
    {
        $eventFormat = EventFormat::where('event_id', $request->event_id)->get();
        $eventFormatResource = EventFormatResource::collection($eventFormat);
        return $this->sendResponse($eventFormatResource, 'eventFormatResource:');
    }
    public function add(DeleteEventRequest $request)
    {
        $request->validate([
            'eventFormats' => 'required|array',
            'Format.*.hour' => 'required|string',
            'Format.*.description' => 'required|string',
        ]);
        foreach ($request->eventFormats as $Format) {
            EventFormat::create([
                'event_id' => $request->event_id,
                'hour' => $Format['hour'],
                'description' => $Format['description'],
            ]);
        }
        $eventFormat = Event::find($request->event_id)->eventFormat()->get();
        $eventFormatResource = EventFormatResource::collection($eventFormat);
        return $this->sendResponse($eventFormatResource, 'Event formats added successfully');
    }

    public function edit(DeleteEventRequest $request)
    {
        $request->validate([
            'eventFormats' => 'required|array',
            'Format.*.id' => 'required|exists:event_formats,id',
            'Format.*.hour' => 'required|string',
            'Format.*.description' => 'required|string',
        ]);

        foreach ($request->eventFormats as $Format) {
            $eventFormat = EventFormat::find($Format['id']);
            $eventFormat->update([
                'hour' => $Format['hour'],
                'description' => $Format['description'],
            ]);
        }
        $eventFormat = Event::find($request->event_id)->eventFormat()->get();
        $eventFormatResource = EventFormatResource::collection($eventFormat);
        return $this->sendResponse($eventFormatResource, 'Event formats added successfully');
    }

    public function delete(DeleteEventRequest $request)
    {
        $event = Event::findOrFail($request->event_id);
        $event->eventFormat()->delete();
        return $this->sendResponse(null,"delete done");
    }
    public function deleteLine(DeleteEventRequest $request)
    {
       $validate= $request->validate([
            'format_id' => 'required|exists:event_formats,id',
        ]);
        $eventFormat = EventFormat::where('event_id', $request->event_id)
        ->where('id', $validate['format_id'])
        ->first();
        $eventFormat->delete();
        return $this->sendResponse(null,"delete done");
    }

}
