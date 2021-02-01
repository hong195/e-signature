<?php

namespace App\Http\Controllers;

use App\Forms\DepartmentForm;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DeparmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 15);
        $page = $request->get('page', 1);

        $data =  Department::query()
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);

        return DeparmentResource::collection($data);
    }

    public function create(DepartmentForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(DepartmentRequest $request, Department $department): \Illuminate\Http\JsonResponse
    {
        $department->create($request->validated());

        return response()->json(['message' => 'Департамент создан'], 201);
    }

    public function show(Department $department): DeparmentResource
    {
        return DeparmentResource::make($department);
    }

    public function edit($id)
    {
        //
    }

    public function update(DepartmentRequest $request, Department $department): \Illuminate\Http\JsonResponse
    {
        $department->update($request->validated());

        return response()->json(['message' => 'Департамент обновлен'], 201);
    }

    public function destroy(Department $department): \Illuminate\Http\JsonResponse
    {
        $department->removed = true;
        return response()->json(['message' => 'Департамент удален']);
    }
}
