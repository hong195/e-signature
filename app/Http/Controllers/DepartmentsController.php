<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DeparmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
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

    public function update(Request $request, Department $department): \Illuminate\Http\JsonResponse
    {
        $department->update($request->validated());

        return response()->json(['message' => 'Департамент обновлен'], 201);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Department::destroy($id);
        return response()->json(['message' => 'Департамент удален']);
    }
}
