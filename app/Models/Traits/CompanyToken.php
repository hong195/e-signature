<?php


namespace App\Models\Traits;


use App\Models\CompanySetting;

trait CompanyToken
{
    public function getCompanyToken(int $companyId)
    {
        if (!$companyId) {
            return;
        }

        $token = CompanySetting::token()->where('company_id', $companyId)->first();

        if (!$token) {
            return;
        }

        return $token->value;
    }
}
