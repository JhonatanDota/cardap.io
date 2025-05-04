<?php

namespace Tests\Feature\CompanyOpeningHour;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;

class ListCompanyOpeningHourTest extends TestCase
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
     * Test list company opening hour not logged.
     *
     * @return void
     */
    public function testListCompanyOpeningHourNotLogged(): void
    {
        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/opening-hours');

        $response->assertOk();
    }

    /**
     * Test list company opening hour logged.
     *
     * @return void
     */
    public function testListCompanyOpeningHourLogged(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/opening-hours');

        $response->assertOk();
    }

    /**
     * Test try list company opening hour with invalid company id.
     *
     * @return void
     */
    public function testTryListCompanyOpeningHourWithInvalidCompanyId(): void
    {
        $response = $this->json('GET', 'api/companies/9999/opening-hours');
        $response->assertNotFound();
    }

    /**
     * Test try list company opening hour with company that dont have opening hours.
     *
     * @return void
     */
    public function testTryListCompanyOpeningHourWithCompanyThatDontHaveOpeningHours(): void
    {
        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/opening-hours');
        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * Test try list company opening hour with company that have opening hours.
     *
     * @return void
     */
    public function testTryListCompanyOpeningHourWithCompanyThatHaveOpeningHours(): void
    {
        $openingHourCount = 3;
        $company = Company::factory()->hasOpeningHours($openingHourCount)->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/opening-hours');
        $response->assertOk();
        $response->assertExactJson($company->openingHours->toArray());
        $response->assertJsonStructure([
            [
                'id',
                'company_id',
                'week_day',
                'opening_hour',
                'closing_hour',
            ]
        ]);
        $response->assertJsonCount($openingHourCount);
    }
}
