<?php

namespace App\Http\Requests;

class CompanyRequest extends AbstractRequest
{
    public function rules() : array
    {
        return [
            'name' => ['required'],
        ];
    }
}
