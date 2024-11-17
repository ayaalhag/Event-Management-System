<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashbourdLoginRequest extends FormRequest
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
          //  'role' => 'required|string|in:admin',
            'email' => 'required|email',
             'password' => [
                'required'
            ],
        ];
    }
}
