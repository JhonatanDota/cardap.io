<?php

namespace Tests\Feature\CompanyOpeningHour;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;

use App\Enums\Date\WeekDaysEnum;

class SyncCompanyOpeningHourTest extends TestCase
{
    private User $user;
    private Company $company;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create([
            'owner_id' => $this->user->id
        ]);
    }

    /**
     * Test try sync company opening hour not logged.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourNotLogged(): void
    {
        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours');

        $response->assertUnauthorized();
    }

    /**
     * Test try sync company opening hour with another user.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithAnotherUser(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours');

        $response->assertForbidden();
    }

    /**
     * Test try sync company opening hour with invalid company id.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidCompanyId(): void
    {
        $response = $this->json('POST', 'api/companies/9999/opening-hours');

        $response->assertNotFound();
    }

    /**
     * Test try sync company opening hour with invalid week day.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidWeekDay(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => [
                [
                    'week_day' => WeekDaysEnum::FRIDAY->value,
                    'opening_hour' => '21:00',
                    'closing_hour' => '23:00',
                ],
                [
                    'week_day' => 'UNKNOWN',
                    'opening_hour' => '22:00',
                    'closing_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours.1.week_day' => [
                'The opening_hours.1.week_day field is invalid.'
            ]
        ]);
    }

    /**
     * Test try sync company opening hour with invalid opening hour.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidOpeningHour(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => [
                [
                    'week_day' => WeekDaysEnum::FRIDAY->value,
                    'opening_hour' => 'UNKNOWN',
                    'closing_hour' => '23:00',
                ],
                [
                    'week_day' => WeekDaysEnum::SATURDAY->value,
                    'opening_hour' => '22:00',
                    'closing_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours.0.opening_hour' => [
                'The opening_hours.0.opening_hour field must match the format H:i.'
            ]
        ]);
    }

    /**
     * Test try sync company opening hour with invalid closing hour.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidClosingHour(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => [
                [
                    'week_day' => WeekDaysEnum::FRIDAY->value,
                    'opening_hour' => '23:00',
                    'closing_hour' => 'UNKNOWN',
                ],
                [
                    'week_day' => WeekDaysEnum::SATURDAY->value,
                    'opening_hour' => '22:00',
                    'closing_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours.0.closing_hour' => [
                'The opening_hours.0.closing_hour field must match the format H:i.'
            ]
        ]);
    }
}
