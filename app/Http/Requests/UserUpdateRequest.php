<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'department_id' => ['required', 'exists:'.Department::class.',id'],
            'name' => ['required'],
            'surname' => ['required'],
            'status' => ['required'],
            'contacts.personal_email' => ['required', 'email'],
            'contacts.phone' => ['required'],
            'password' => ['nullable']
        ];
    }
}
