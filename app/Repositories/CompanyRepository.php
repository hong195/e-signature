<?php


namespace App\Repositories;


use App\Models\Company;

class CompanyRepository extends AbstractRepository
{
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }
}
