<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CompanyRequest $request, Company $company): \Illuminate\Http\JsonResponse
    {
        $company->create($request->validated());

        return response()->json(['message' => 'Компания создана']);
    }

    public function show(Company $company): CompanyResource
    {
        return CompanyResource::make($company);
    }

    public function edit($id)
    {
        //
    }

    public function update(CompanyRequest $request, Company $company): \Illuminate\Http\JsonResponse
    {
        $company->update($request->validated());

        return response()->json(['message' => 'Компания обновлена']);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Company::destroy($id);
        return response()->json(['message' => 'Компания удалена']);
    }
}
