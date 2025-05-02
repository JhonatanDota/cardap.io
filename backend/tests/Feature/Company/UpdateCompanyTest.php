<?php

namespace Tests\Feature\Company;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Company\NameRules;
use App\Rules\Fields\Commom\EmailRules;
use App\Rules\Fields\Commom\PhoneRules;

class UpdateCompanyTest extends TestCase
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
            'owner_id' => $this->user->id,
        ]);
    }

    /**
     * Test try update company not logged.
     *
     * @return void
     */
    public function testTryUpdateCompanyNotLogged(): void
    {
        $response = $this->json('PATCH', 'api/companies/' . $this->company->id);
        $response->assertUnauthorized();
    }

    /**
     * Test try update company with invalid company id.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithInvalidCompanyId(): void
    {
        $response = $this->json('PATCH', 'api/companies/9999');
        $response->assertNotFound();
    }

    /**
     * Test try update company with another user.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithAnotherUser(): void
    {
        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, $this->company->toArray());
        $response->assertForbidden();
    }

    /**
     * Test try update company with null name.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithNullName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'name' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);

        $response->assertJsonFragment([
            'name' => [
                'The name field must be a string.',
                'The name field must be at least ' . NameRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with empty name.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithEmptyName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'name' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);

        $response->assertJsonFragment([
            'name' => [
                'The name field must be a string.',
                'The name field must be at least ' . NameRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with too tiny name.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithTooTinyName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'name' => Str::random(NameRules::MIN_LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);

        $response->assertJsonFragment([
            'name' => [
                'The name field must be at least ' . NameRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with too long name.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithTooLongName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'name' => Str::random(NameRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);

        $response->assertJsonFragment([
            'name' => [
                'The name field must not be greater than ' . NameRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid name.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidName(): void
    {
        $this->actingAs($this->user);

        $name = $this->faker->name;

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'name' => $name,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'name' => $name,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'name' => $name,
        ]);
    }

    /**
     * Test try update company with null cnpj.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithNullCnpj(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj field must be a string.',
                'The cnpj field format is invalid.',
                'The cnpj field must be ' . CnpjRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with empty cnpj.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithEmptyCnpj(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj field must be a string.',
                'The cnpj field format is invalid.',
                'The cnpj field must be ' . CnpjRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with cnpj than contains letters.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithCnpjThatContainsLetters(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => Str::random(CnpjRules::LENGTH),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj field format is invalid.',
            ],
        ]);
    }

    /**
     * Test try update company with cnpj too tiny.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithCnpjTooTiny(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => Str::random(CnpjRules::LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj field format is invalid.',
                'The cnpj field must be ' . CnpjRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with cnpj too long.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithCnpjTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => Str::random(CnpjRules::LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj field format is invalid.',
                'The cnpj field must be ' . CnpjRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test try update company with duplicated cnpj.
     *
     * @return void
     */
    public function testTryUpdateCompanyWithDuplicatedCnpj(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create();

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => $company->cnpj,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['cnpj']);

        $response->assertJsonFragment([
            'cnpj' => [
                'The cnpj has already been taken.',
            ],
        ]);
    }

    /** Test update company with valid cnpj.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidCnpj(): void
    {
        $this->actingAs($this->user);

        $cnpj = $this->faker->numerify(str_repeat('#', CnpjRules::LENGTH));

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'cnpj' => $cnpj,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'cnpj' => $cnpj,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'cnpj' => $cnpj,
        ]);
    }

    /**
     * Test update company with null email.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullEmail(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'email' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment([
            'email' => [
                'The email field must be a string.',
                'The email field must be a valid email address.',
                'The email field format is invalid.',
            ],
        ]);
    }

    /**
     * Test update company with empty email.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyEmail(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'email' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment([
            'email' => [
                'The email field must be a string.',
                'The email field must be a valid email address.',
                'The email field format is invalid.',
            ],
        ]);
    }

    /**
     * Test update company with invalid email.
     *
     * @return void
     */
    public function testUpdateCompanyWithInvalidEmail(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'email' => 'invalid-email',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment([
            'email' => [
                'The email field format is invalid.',
                'The email field must be a valid email address.',
            ],
        ]);
    }

    /**
     * Test update company with email too long.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmailTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'email' => Str::random(EmailRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment([
            'email' => [
                'The email field must be a valid email address.',
                'The email field format is invalid.',
                'The email field must not be greater than ' . EmailRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid email.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidEmail(): void
    {
        $this->actingAs($this->user);

        $email = $this->faker->email;

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'email' => $email,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'email' => $email,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'email' => $email,
        ]);
    }

    /**
     * Test update company with null phone.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullPhone(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['phone']);

        $response->assertJsonFragment([
            'phone' => [
                'The phone field must be a string.',
                'The phone field format is invalid.',
                'The phone field must be ' . PhoneRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with empty phone.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyPhone(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['phone']);

        $response->assertJsonFragment([
            'phone' => [
                'The phone field must be a string.',
                'The phone field format is invalid.',
                'The phone field must be ' . PhoneRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with phone that contains letters.
     *
     * @return void
     */
    public function testUpdateCompanyWithPhoneThatContainsLetters(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => Str::random(PhoneRules::LENGTH),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['phone']);

        $response->assertJsonFragment([
            'phone' => [
                'The phone field format is invalid.',
            ],
        ]);
    }

    /**
     * Test update company with phone too tiny.
     *
     * @return void
     */
    public function testUpdateCompanyWithPhoneTooTiny(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => Str::random(PhoneRules::LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['phone']);

        $response->assertJsonFragment([
            'phone' => [
                'The phone field format is invalid.',
                'The phone field must be ' . PhoneRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with phone too long.
     *
     * @return void
     */
    public function testUpdateCompanyWithPhoneTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => Str::random(PhoneRules::LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['phone']);

        $response->assertJsonFragment([
            'phone' => [
                'The phone field format is invalid.',
                'The phone field must be ' . PhoneRules::LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid phone.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidPhone(): void
    {
        $this->actingAs($this->user);

        $phone = $this->faker->numerify(str_repeat('#', PhoneRules::LENGTH));

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'phone' => $phone,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'phone' => $phone,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'phone' => $phone,
        ]);
    }
}
