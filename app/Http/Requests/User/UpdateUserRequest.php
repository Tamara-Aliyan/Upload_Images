<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user'); // Assuming your route parameter is named 'user'

        return [
            'name'  => ['required', 'string', 'max:50', "unique:users,name,{$userId}"],
            'email' => [
                'required',
                'email',
                "unique:users,email,{$userId}", // Check uniqueness for email excluding the current user
                "unique:users,name,{$userId}"   // Additional check to ensure name remains unique
            ],
        ];
    }
}
