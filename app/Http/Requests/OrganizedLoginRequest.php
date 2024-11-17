<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizedLoginRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => 'required|email',
             'password' => [
                'required'
            ],
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'email filed is required',
            'email.email'=>'should be email',
            'passowrd.required' => 'password filed is required',
        ];
}
}
