<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Models\User;

class UserRequest extends AbstractRequest
{
    public function rules() : array
    {
        return [
            //'department_id' => ['required', 'exists:'.Department::class.',id'],
            'name' => ['required'],
            'surname' => ['required'],
            'password' => ['nullable']
        ];
    }
}
