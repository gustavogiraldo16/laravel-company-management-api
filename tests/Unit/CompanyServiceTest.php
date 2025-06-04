<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception; // For catching the generic exception from delete method

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test

    protected CompanyService $companyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyService = new CompanyService();
    }

    #[Test]
    public function it_can_retrieve_all_companies_with_pagination()
    {
        // Create some companies for testing
        Company::factory()->count(15)->create();

        // Test default pagination
        $companies = $this->companyService->findAll();
        $this->assertCount(Company::DEFAULT_PAGINATION_SIZE, $companies->items());
        $this->assertEquals(15, $companies->total());
        $this->assertEquals(1, $companies->currentPage());

        // Test custom pagination
        $companies = $this->companyService->findAll(5, 2);
        $this->assertCount(5, $companies->items());
        $this->assertEquals(2, $companies->currentPage());
    }

    #[Test]
    public function it_can_create_a_company()
    {
        $data = [
            'nit' => '123456789-1',
            'name' => 'Test Company One',
            'address' => '123 Main St',
            'phone' => '123-456-7890',
            'status' => 'active',
        ];

        $company = $this->companyService->create($data);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertDatabaseHas('companies', ['nit' => '123456789-1', 'status' => 'active']);
        $this->assertEquals('Test Company One', $company->name);
    }

    #[Test]
    public function it_creates_a_company_with_default_active_status_if_not_provided()
    {
        $data = [
            'nit' => '987654321-0',
            'name' => 'Default Status Co.',
            'address' => '456 Oak Ave',
            'phone' => '987-654-3210',
            // 'status' is intentionally left out
        ];

        $company = $this->companyService->create($data);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals('active', $company->status);
        $this->assertDatabaseHas('companies', ['nit' => '987654321-0', 'status' => 'active']);
    }

    #[Test]
    public function it_can_find_a_company_by_nit()
    {
        $company = Company::factory()->create(['nit' => 'NIT123TEST']);
        $foundCompany = $this->companyService->findByNit('NIT123TEST');

        $this->assertInstanceOf(Company::class, $foundCompany);
        $this->assertEquals($company->id, $foundCompany->id);
        $this->assertEquals('NIT123TEST', $foundCompany->nit);
    }

    #[Test]
    public function it_throws_exception_when_company_not_found_by_nit()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->companyService->findByNit('NONEXISTENT_NIT');
    }

    #[Test]
    public function it_can_update_a_company()
    {
        $company = Company::factory()->create(['nit' => 'UPDATE_NIT_TEST', 'status' => 'active']);
        $data = [
            'name' => 'Updated Name',
            'phone' => '111-222-3333',
            'status' => 'inactive',
        ];

        $updatedCompany = $this->companyService->update('UPDATE_NIT_TEST', $data);

        $this->assertInstanceOf(Company::class, $updatedCompany);
        $this->assertEquals('Updated Name', $updatedCompany->name);
        $this->assertEquals('111-222-3333', $updatedCompany->phone);
        $this->assertEquals('inactive', $updatedCompany->status);
        $this->assertDatabaseHas('companies', [
            'nit' => 'UPDATE_NIT_TEST',
            'name' => 'Updated Name',
            'phone' => '111-222-3333',
            'status' => 'inactive',
        ]);
    }

    #[Test]
    public function it_does_not_update_nit_when_updating_a_company()
    {
        $company = Company::factory()->create(['nit' => 'ORIGINAL_NIT']);
        $data = [
            'nit' => 'NEW_NIT_SHOULD_BE_IGNORED',
            'name' => 'New Name',
        ];

        $updatedCompany = $this->companyService->update('ORIGINAL_NIT', $data);

        $this->assertEquals('ORIGINAL_NIT', $updatedCompany->nit);
        $this->assertEquals('New Name', $updatedCompany->name);
        $this->assertDatabaseHas('companies', ['nit' => 'ORIGINAL_NIT', 'name' => 'New Name']);
        $this->assertDatabaseMissing('companies', ['nit' => 'NEW_NIT_SHOULD_BE_IGNORED']);
    }

    #[Test]
    public function it_can_delete_an_inactive_company()
    {
        $company = Company::factory()->create(['nit' => 'DELETE_TEST_NIT', 'status' => 'inactive']);

        $deleted = $this->companyService->delete('DELETE_TEST_NIT');

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('companies', ['nit' => 'DELETE_TEST_NIT']);
    }

    #[Test]
    public function it_throws_exception_when_deleting_an_active_company()
    {
        $company = Company::factory()->create(['nit' => 'ACTIVE_COMPANY_NIT', 'status' => 'active']);

        $this->expectException(Exception::class); // Expect a generic exception based on current service implementation
        $this->expectExceptionMessage('Only companies with "inactive" status can be deleted');

        $this->companyService->delete('ACTIVE_COMPANY_NIT');
    }

    #[Test]
    public function it_throws_exception_when_deleting_non_existent_company()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->companyService->delete('NONEXISTENT_NIT_FOR_DELETE');
    }
}
