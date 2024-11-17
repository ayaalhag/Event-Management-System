<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPartsIdRequest extends FormRequest
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
            'category_id' => ['required', 'exists:catgories_part,id'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category_id field is required.',
            'category_id.exists' => 'The selected category_id is invalid.',
        ];
    }
}
