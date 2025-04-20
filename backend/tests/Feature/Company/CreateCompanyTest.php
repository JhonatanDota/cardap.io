<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Company\NameRules;

class CreateCompanyTest extends TestCase
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
     * Test try create company not logged.
     *
     * @return void
     */
    public function testTryCreateCompanyNotLogged(): void
    {
        $response = $this->json('POST', 'api/companies');
        $response->assertUnauthorized();
    }

    /**
     * Test try create company without name.
     *
     * @return void
     */
    public function testTryCreateCompanyWithoutName(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'name' => null
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try create company with too tiny name.
     *
     * @return void
     */
    public function testTryCreateCompanyWithTooTinyName(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'name' => Str::random(NameRules::MIN_LENGTH - 1)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field must be at least ' . NameRules::MIN_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company with too long name.
     *
     * @return void
     */
    public function testTryCreateCompanyWithTooLongName(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'name' => Str::random(NameRules::MAX_LENGTH + 1)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field must not be greater than ' . NameRules::MAX_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company without cnpj.
     *
     * @return void
     */
    public function testTryCreateCompanyWithoutCnpj(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'cnpj' => null
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'cnpj',
        ]);

        $response->assertJsonFragment([
            'cnpj' => ['The cnpj field is required.'],
        ]);
    }

    /**
     * Test try create company with cnpj that contains letters.
     *
     * @return void
     */
    public function testTryCreateCompanyWithCnpjThatContainsLetters(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'cnpj' => Str::random(CnpjRules::LENGTH)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'cnpj',
        ]);

        $response->assertJsonFragment([
            'cnpj' => ['The cnpj field format is invalid.'],
        ]);
    }

    /**
     * Test try create company with cnpj too tiny.
     *
     * @return void
     */
    public function testTryCreateCompanyWithCnpjTooTiny(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'cnpj' => $this->faker->numerify(str_repeat('#', CnpjRules::LENGTH - 1))
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'cnpj',
        ]);

        $response->assertJsonFragment([
            'cnpj' => ['The cnpj field must be ' . CnpjRules::LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company with cnpj too long.
     *
     * @return void
     */
    public function testTryCreateCompanyWithCnpjTooLong(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'cnpj' => $this->faker->numerify(str_repeat('#', CnpjRules::LENGTH + 1))
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'cnpj',
        ]);

        $response->assertJsonFragment([
            'cnpj' => ['The cnpj field must be ' . CnpjRules::LENGTH . ' characters.'],
        ]);
    }
}
