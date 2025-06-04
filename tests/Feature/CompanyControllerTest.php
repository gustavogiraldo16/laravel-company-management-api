<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker; // Useful for generating fake data for requests
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test; // For PHPUnit 11+ attributes

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test
    use WithFaker;     // Provides faker methods for generating test data

    /**
     * Base URL for the API endpoints.
     * @var string
     */
    protected $baseUrl = '/api/v1/companies';

    #[Test]
    public function it_can_retrieve_all_companies()
    {
        // Create some companies for testing the index endpoint
        Company::factory()->count(10)->create();

        $response = $this->getJson($this->baseUrl);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         'current_page',
                         'data' => [
                             '*' => ['id', 'nit', 'name', 'address', 'phone', 'status', 'created_at', 'updated_at']
                         ],
                         'first_page_url',
                         'from',
                         'last_page',
                         'last_page_url',
                         'links',
                         'next_page_url',
                         'path',
                         'per_page',
                         'prev_page_url',
                         'to',
                         'total'
                     ]
                 ])
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Companies retrieved successfully'
                 ]);

        $this->assertCount(Company::DEFAULT_PAGINATION_SIZE, $response->json('data.data')); // Check default page size
    }

    #[Test]
    public function it_can_retrieve_all_companies_with_custom_pagination()
    {
        Company::factory()->count(25)->create();

        $response = $this->getJson($this->baseUrl . '?per_page=5&page=3');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data.data')
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'current_page' => 3,
                         'per_page' => 5,
                         'total' => 25
                     ]
                 ]);
    }

    #[Test]
    public function it_can_create_a_company()
    {
        $companyData = [
            'nit' => $this->faker->unique()->numerify('##########-#'),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'status' => 'active'
        ];

        $response = $this->postJson($this->baseUrl, $companyData);

        $response->assertStatus(201) // 201 Created
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Company created successfully',
                     'data' => $companyData // Check that the returned data matches the sent data
                 ]);

        $this->assertDatabaseHas('companies', ['nit' => $companyData['nit']]);
    }

    #[Test]
    public function it_returns_validation_errors_when_creating_a_company_with_invalid_data()
    {

        $existingShortInvalidNit = '123-0';
        Company::factory()->create(['nit' => $existingShortInvalidNit]);

        $invalidCompanyData = [
            'nit' => $existingShortInvalidNit, // Fallará por 'min' y 'unique'
            'name' => '',      // Nombre vacío
            'status' => 'invalid_status' // Estado inválido
        ];

        $response = $this->postJson($this->baseUrl, $invalidCompanyData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nit', 'name', 'status'])
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'The nit field must be at least 6 characters. (and 2 more errors)',
                     'errors' => [
                         'nit' => [
                             'The nit field must be at least 6 characters.',
                             'The NIT is already registered.',
                         ],
                         'name' => ['The company name is required.'],
                         'status' => ['The status must be "active" or "inactive".'],
                     ]
                 ]);
    }

    #[Test]
    public function it_can_retrieve_a_single_company_by_nit()
    {
        $company = Company::factory()->create();

        $response = $this->getJson($this->baseUrl . '/' . $company->nit);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Company retrieved successfully',
                     'data' => [
                         'nit' => $company->nit,
                         'name' => $company->name,
                     ]
                 ]);
    }

    #[Test]
    public function it_returns_404_when_retrieving_non_existent_company_by_nit()
    {
        $response = $this->getJson($this->baseUrl . '/NONEXISTENTNIT');

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Company not found',
                 ]);
    }

    #[Test]
    public function it_can_update_a_company()
    {
        $company = Company::factory()->create(['status' => 'active']); // Create an active company
        $updateData = [
            'name' => 'Updated Company Name',
            'address' => 'Updated Address',
            'status' => 'inactive'
        ];

        $response = $this->putJson($this->baseUrl . '/' . $company->nit, $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Company updated successfully',
                     'data' => [
                         'nit' => $company->nit, // NIT should remain the same
                         'name' => 'Updated Company Name',
                         'address' => 'Updated Address',
                         'status' => 'inactive'
                     ]
                 ]);

        $this->assertDatabaseHas('companies', [
            'nit' => $company->nit,
            'name' => 'Updated Company Name',
            'address' => 'Updated Address',
            'status' => 'inactive'
        ]);
    }

    #[Test]
    public function it_does_not_update_nit_via_put_request()
    {
        $company = Company::factory()->create(['nit' => 'ORIGINALNIT']);
        $updateData = [
            'nit' => $this->faker->unique()->numerify('##########-#'),
            'name' => 'New Name for Company'
        ];

        $response = $this->putJson($this->baseUrl . '/' . $company->nit, $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'nit' => 'ORIGINALNIT', // Assert that NIT remained original
                         'name' => 'New Name for Company'
                     ]
                 ]);

        $this->assertDatabaseHas('companies', ['nit' => 'ORIGINALNIT', 'name' => 'New Name for Company']);
        $this->assertDatabaseMissing('companies', ['nit' => 'NEWNITSHOULDNOTBEUPDATED']);
    }


    #[Test]
    public function it_returns_404_when_updating_non_existent_company()
    {
        $updateData = [
            'name' => 'Non Existent Update'
        ];

        $response = $this->putJson($this->baseUrl . '/NONEXISTENTNITFORUPDATE', $updateData);

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Company not found',
                 ]);
    }

    #[Test]
    public function it_can_delete_an_inactive_company()
    {
        $company = Company::factory()->create(['status' => 'inactive']); // Create an inactive company

        $response = $this->deleteJson($this->baseUrl . '/' . $company->nit);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Company deleted successfully',
                 ]);

        $this->assertDatabaseMissing('companies', ['nit' => $company->nit]);
    }

    #[Test]
    public function it_returns_403_when_deleting_an_active_company()
    {
        $company = Company::factory()->create(['status' => 'active']); // Create an active company

        $response = $this->deleteJson($this->baseUrl . '/' . $company->nit);

        $response->assertStatus(403)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Only companies with "inactive" status can be deleted',
                 ]);

        $this->assertDatabaseHas('companies', ['nit' => $company->nit]); // Should still exist
    }

    #[Test]
    public function it_returns_404_when_deleting_non_existent_company()
    {
        $response = $this->deleteJson($this->baseUrl . '/NONEXISTENTNITFORDELETE');

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Company not found',
                 ]);
    }
}
