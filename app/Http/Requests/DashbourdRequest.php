<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as Password_rule;
use Illuminate\Passport\Facades\Auth;
class DashbourdRequest extends FormRequest
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
            'name' => 'required|max:55|string',
            'role' => 'required|string|in:admin',
            'phone' => 'required|digits:10',
            'email' => 'required|unique:users|email',
             'password' => [
                'required',
                'confirmed',
                Password_rule::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }
}
