<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPlaceRequest extends FormRequest
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
            'name'=>['required'],
            'location'=>['required'],
            'picture_url'=>['nullable','file'],
            'phone'=>['required'],
            //'assessment'=>['required'],
            'category_place_id'=>['required','exists:catgories_place,id'],
        ];
    }
}
