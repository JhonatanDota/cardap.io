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
                    'open_hour' => '21:00',
                    'close_hour' => '23:00',
                ],
                [
                    'week_day' => 'UNKNOWN',
                    'open_hour' => '22:00',
                    'close_hour' => '23:00',
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
     * Test try sync company opening hour with invalid open hour.
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
                    'open_hour' => 'UNKNOWN',
                    'close_hour' => '23:00',
                ],
                [
                    'week_day' => WeekDaysEnum::SATURDAY->value,
                    'open_hour' => '22:00',
                    'close_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours.0.open_hour' => [
                'The opening_hours.0.open_hour field must match the format H:i.'
            ]
        ]);
    }

    /**
     * Test try sync company opening hour with invalid close hour.
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
                    'open_hour' => '23:00',
                    'close_hour' => 'UNKNOWN',
                ],
                [
                    'week_day' => WeekDaysEnum::SATURDAY->value,
                    'open_hour' => '22:00',
                    'close_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours.0.close_hour' => [
                'The opening_hours.0.close_hour field must match the format H:i.'
            ]
        ]);
    }
}
