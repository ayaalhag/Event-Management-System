<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'place_id'=>'required|integer|exists:places,id',
            'name'=>'required|string',
            'type'=>'required|string',
            'additions' => 'nullable|string',
            'nameOnTheCard' => 'nullable|string|max:255',
            'music' => 'nullable|string',
            'booking.start_date' => 'required|date',
            'booking.end_date' => 'required|date|after:booking.start_date',
            'parts' =>  ['required','array'],
            'parts.*.id' => 'required|exists:parts,id',
            'parts.*.number' => 'required|integer|min:1',
        ];
    }
}
