<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'place_id' => ['sometimes', 'exists:places,id'],
            'name' => 'sometimes|string',
            'nameOnTheCard' => 'sometimes|string',
            'additions' => 'sometimes|string',
            'music' => 'sometimes|string',
            'picture_url' => 'nullable | file',
            'assessment' => 'sometimes|min:0|max:5|numeric',
            'booking.start_date' => 'sometimes|date',
            'booking.end_date' => 'sometimes|date|after:booking.start_date',
            'parts' => ['sometimes', 'array'],
            'parts.*.id' => 'sometimes|exists:parts,id',
            'parts.*.number' => 'sometimes|integer|min:1',
        ];
    }
}
