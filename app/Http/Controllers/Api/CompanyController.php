<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyController extends ApiController
{

    public function __construct(protected CompanyService $companyService)
    {}

    /**
     * Display a listing of the resource.
     * Consultar todas las empresas registradas.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page');
            $page = $request->input('page');
            $companies = $this->companyService->findAll($perPage, $page);
            return $this->successResponse($companies, 'Companies retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve companies', 500, ['exception' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * Agregar nuevas empresas.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest  $request): JsonResponse
    {
        try {
            $company = $this->companyService->create($request->validated());
            return $this->successResponse($company, 'Company created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating company', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Consultar las empresas por nit.
     *
     * @param  string  $nit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $nit): JsonResponse
    {
        try {
            $company = $this->companyService->findByNit($nit);
            return $this->successResponse($company, 'Company retrieved successfully');
        }  catch (ModelNotFoundException $e) {
            return $this->errorResponse('Company not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving company', 500, ['exception' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     * Actualizar los datos de una empresa.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  string  $nit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCompanyRequest $request, string $nit): JsonResponse
    {
        try {
            $company = $this->companyService->update($nit, $request->validated());
            return $this->successResponse($company, 'Company updated successfully');
        }  catch (ModelNotFoundException $e) {
            return $this->errorResponse('Company not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating company', 500, ['exception' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * Borrar las empresas con estado inactivo.
     * This method will specifically delete companies with 'inactive' status.
     *
     * @param  string  $nit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->companyService->delete($id);
            return $this->successResponse(null, 'Company deleted successfully');
        }  catch (ModelNotFoundException $e) {
            return $this->errorResponse('Company not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 403);
        }
    }
}
