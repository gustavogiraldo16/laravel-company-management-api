<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CompanyService
{
    /**
     * Retrieve all companies with pagination.
     *
     * @param int|null $perPage
     * @param int|null $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAll(?int $perPage = null, ?int $page = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? Company::DEFAULT_PAGINATION_SIZE;
        $page = $page ?? 1;

        return Company::paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create a new company.
     *
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company
    {
        if (isset($data['status'])) {
            $data['status'] = strtolower($data['status']);
        }

        return Company::create($data);
    }

    /**
     * Find a company by its NIT.
     *
     * @param string $nit
     * @return Company
     * @throws ModelNotFoundException
     */
    public function findByNit(string $nit): Company
    {
        return Company::where('nit', $nit)->firstOrFail();
    }

    /**
     * Update an existing company.
     *
     * @param string $nit
     * @param array $data
     * @return Company
     * @throws ModelNotFoundException
     */
    public function update(string $nit, array $data): Company
    {
        $company = $this->findByNit($nit);

        unset($data['nit']);

        if (isset($data['status'])) {
            $data['status'] = strtolower($data['status']);
        }

        $company->update($data);

        return $company;
    }

    /**
     * Delete a company by its NIT if its status is 'inactive'.
     *
     * @param string $nit
     * @return bool True if deleted, false otherwise.
     * @throws ModelNotFoundException If company not found.
     * @throws \App\Exceptions\CannotDeleteActiveCompanyException If company is active.
     */
    public function delete(string $nit): bool
    {
        $company = $this->findByNit($nit);

        if ($company->status !== 'inactive') {
            throw new Exception('Only companies with "inactive" status can be deleted');
        }

        return $company->delete();
    }
}
