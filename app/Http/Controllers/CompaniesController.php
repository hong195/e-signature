<?php

namespace App\Http\Controllers;

use App\Forms\CompanyForm;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 15);
        $page = $request->get('page', 1);

        $data =  Company::query()
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);

        return CompanyResource::collection($data);
    }

    public function create(CompanyForm $form)
    {
        return response()->json(['form' => $form->get()]);
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

    public function edit(CompanyForm $form, int $id)
    {
        $attr = $this->companyRepository->findById($id);

        return response()->json(['form' => $form->fill($attr)->get()]);
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
