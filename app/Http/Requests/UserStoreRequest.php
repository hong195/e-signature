<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Models\User;

class UserStoreRequest extends AbstractRequest
{
    public function rules() : array
    {
        return [
            'department_id' => ['required', 'exists:'.Department::class.',id'],
            'name' => ['required'],
            'surname' => ['required'],
            'nickname' => ['required', 'unique:'. User::class . ',nickname', 'alpha_dash', 'bail'],
            'contacts.personal_email' => ['required', 'email'],
            'contacts.phone' => ['required'],
        ];
    }
}
