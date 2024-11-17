<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPartRequest extends FormRequest
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
            'price'=>['required'],
            'pictture_url'=>['somtimes','file'],
            'assessment'=>['required'],
            'category_part_id'=>['required','exists:catgories_part,id'],
        ];
    }
}
