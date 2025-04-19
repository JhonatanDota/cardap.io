<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;

class MyCompanyTest extends TestCase
{
    private User $user;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test try access my company not logged.
     *
     * @return void
     */
    public function testTryAccessMyCompanyNotLogged(): void
    {
        $response = $this->json('GET', 'api/companies/my-company');
        $response->assertUnauthorized();
    }

    /**
     * Test try access my company without company.
     *
     * @return void
     */
    public function testTryAccessMyCompanyWithoutCompany(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('GET', 'api/companies/my-company');

        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * Test access my company successfully.
     *
     * @return void
     */
    public function testAccessMyCompanySuccessfully(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create([
            'owner_id' => $this->user->id
        ]);

        $response = $this->json('GET', 'api/companies/my-company');

        $response->assertOk();
        $response->assertExactJson($company->toArray());
    }
}
