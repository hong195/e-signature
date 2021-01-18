<?php

namespace App\Http\Requests;

use App\Models\Company;

class DepartmentRequest extends AbstractRequest
{
    public function rules() : array
    {
        return [
            'name' => ['required'],
            'company_id' => ['required', 'exists:'.Company::class.',id'],
        ];
    }
}
