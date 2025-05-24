<?php

namespace Tests\Feature\CompanyOpeningHour;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyOpeningHour;

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
     * Test try sync company opening hour with duplicated week day.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithDuplicatedWeekDay(): void
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
                    'week_day' => WeekDaysEnum::FRIDAY->value,
                    'open_hour' => '22:00',
                    'close_hour' => '23:00',
                ],
            ]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrors([
            'opening_hours' => [
                'The opening hours has duplicated week day.'
            ]
        ]);
    }

    /**
     * Test try sync company opening hour with invalid open hour.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidOpenHour(): void
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
     * Test try sync company opening hour with invalid open hour minutes.
     *
     * @return void
     */
    public function testTrySyncCompanyOpeningHourWithInvalidOpenHourMinutes(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => [
                [
                    'week_day' => WeekDaysEnum::FRIDAY->value,
                    'open_hour' => '22:60',
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
    public function testTrySyncCompanyOpeningHourWithInvalidCloseHour(): void
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

    /**
     * Test sync company opening hour successfully.
     *
     * @return void
     */
    public function testSyncCompanyOpeningHourSuccessfully(): void
    {
        $this->actingAs($this->user);

        $openingHours = [
            [
                'week_day' => WeekDaysEnum::FRIDAY->value,
                'open_hour' => '20:00',
                'close_hour' => '23:30',
            ],
            [
                'week_day' => WeekDaysEnum::SATURDAY->value,
                'open_hour' => '22:00',
                'close_hour' => '23:00',
            ],
            [
                'week_day' => WeekDaysEnum::SUNDAY->value,
                'open_hour' => '15:20',
                'close_hour' => '20:00',
            ],
        ];


        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => $openingHours
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            [
                'id',
                'company_id',
                'week_day',
                'open_hour',
                'close_hour'
            ]
        ]);
        $response->assertExactJson($this->company->openingHours->toArray());

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::FRIDAY->value,
            'open_hour' => '20:00',
            'close_hour' => '23:30',
        ]);

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::SATURDAY->value,
            'open_hour' => '22:00',
            'close_hour' => '23:00',
        ]);

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::SUNDAY->value,
            'open_hour' => '15:20',
            'close_hour' => '20:00',
        ]);
    }

    /**
     * Test change company opening hours.
     *
     * @return void
     */
    public function testChangeCompanyOpeningHours(): void
    {
        $this->actingAs($this->user);

        $this->company->openingHours()->createMany([
            [
                'week_day' => WeekDaysEnum::THURSDAY->value,
                'open_hour' => '22:00',
                'close_hour' => '23:00',
            ],
            [
                'week_day' => WeekDaysEnum::MONDAY->value,
                'open_hour' => '10:33',
                'close_hour' => '17:02',
            ],
        ]);

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::THURSDAY->value,
            'open_hour' => '22:00',
            'close_hour' => '23:00',
        ]);

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::MONDAY->value,
            'open_hour' => '10:33',
            'close_hour' => '17:02',
        ]);

        $this->company->openingHours;

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/opening-hours', [
            'opening_hours' => [
                [
                    'week_day' => WeekDaysEnum::TUESDAY->value,
                    'open_hour' => '09:30',
                    'close_hour' => '10:32',
                ]
            ]
        ]);

        dd($this->company->openingHours);

        $response->assertOk();
        $response->assertExactJson($this->company->openingHours->toArray());

        $this->assertDatabaseMissing(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::THURSDAY->value,
            'open_hour' => '22:00',
            'close_hour' => '23:00',
        ]);

        $this->assertDatabaseMissing(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::MONDAY->value,
            'open_hour' => '10:33',
            'close_hour' => '17:02',
        ]);

        $this->assertDatabaseHas(CompanyOpeningHour::class, [
            'company_id' => $this->company->id,
            'week_day' => WeekDaysEnum::TUESDAY->value,
            'open_hour' => '09:30',
            'close_hour' => '10:32',
        ]);
    }
}
