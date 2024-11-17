<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'user_id' => [ 'required','exists:users,id'],
            'name'=>'sometimes|string',
            'email'=>'sometimes|email|unique:users,email',
            'phone'=>'sometimes|numeric|digits:10',
            'bio'=>'sometimes|string',
        ];
    }
}
