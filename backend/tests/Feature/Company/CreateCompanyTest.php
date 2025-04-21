<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Commom\PhoneRules;
use App\Rules\Fields\Company\NameRules;
use App\Rules\Fields\Commom\EmailRules;
use App\Rules\Fields\Address\StreetRules;

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

    /**
     * Test try create company without email.
     *
     * @return void
     */
    public function testTryCreateCompanyWithoutEmail(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'email' => null
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
        ]);
    }

    /**
     * Test try create company with invalid email.
     *
     * @return void
     */
    public function testTryCreateCompanyWithInvalidEmail(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'email' => 'invalid@mail'
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field format is invalid.'],
        ]);
    }

    /**
     * Test try create company with email too long.
     *
     * @return void
     */
    public function testTryCreateCompanyWithEmailTooLong(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'email' => Str::random(EmailRules::MAX_LENGTH + 1) . '@mail.com',
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field must not be greater than ' . EmailRules::MAX_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company with duplicated email.
     *
     * @return void
     */
    public function testTryCreateCompanyWithDuplicatedEmail(): void
    {
        $this->actingAs($this->user);

        $email = $this->faker->email();

        Company::factory(['email' => $email])->create();

        $data = Company::factory([
            'email' => $email,
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email has already been taken.'],
        ]);
    }

    /**
     * Test try create company without phone.
     *
     * @return void
     */
    public function testTryCreateCompanyWithoutPhone(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'phone' => null
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'phone',
        ]);

        $response->assertJsonFragment([
            'phone' => ['The phone field is required.'],
        ]);
    }

    /**
     * Test try create company with phone that contains letters.
     *
     * @return void
     */
    public function testTryCreateCompanyWithPhoneThatContainsLetters(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'phone' => Str::random(PhoneRules::LENGTH)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'phone',
        ]);

        $response->assertJsonFragment([
            'phone' => ['The phone field format is invalid.'],
        ]);
    }

    /**
     * Test try create company with phone too tiny.
     *
     * @return void
     */
    public function testTryCreateCompanyWithPhoneTooTiny(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'phone' => $this->faker->numerify(str_repeat('#', PhoneRules::LENGTH - 1))
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'phone',
        ]);

        $response->assertJsonFragment([
            'phone' => ['The phone field must be ' . PhoneRules::LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company with phone too long.
     *
     * @return void
     */
    public function testTryCreateCompanyWithPhoneTooLong(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'phone' => $this->faker->numerify(str_repeat('#', PhoneRules::LENGTH + 1))
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'phone',
        ]);

        $response->assertJsonFragment([
            'phone' => ['The phone field must be ' . PhoneRules::LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company without street.
     *
     * @return void
     */
    public function testTryCreateCompanyWithoutStreet(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'street' => null
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'street',
        ]);

        $response->assertJsonFragment([
            'street' => ['The street field is required.'],
        ]);
    }

    /**
     * Test try create company with street too tiny.
     *
     * @return void
     */
    public function testTryCreateCompanyWithStreetTooTiny(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'street' => Str::random(StreetRules::MIN_LENGTH - 1)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'street',
        ]);

        $response->assertJsonFragment([
            'street' => ['The street field must be at least ' . StreetRules::MIN_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try create company with street too long.
     *
     * @return void
     */
    public function testTryCreateCompanyWithStreetTooLong(): void
    {
        $this->actingAs($this->user);

        $data = Company::factory([
            'street' => Str::random(StreetRules::MAX_LENGTH + 1)
        ])->make()->toArray();

        $response = $this->json('POST', 'api/companies', $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'street',
        ]);

        $response->assertJsonFragment([
            'street' => ['The street field must not be greater than ' . StreetRules::MAX_LENGTH . ' characters.']
        ]);
    }
}
