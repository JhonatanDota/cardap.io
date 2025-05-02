<?php

namespace Tests\Feature\Company;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use App\Enums\Address\StatesEnum;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Company\NameRules;
use App\Rules\Fields\Commom\EmailRules;
use App\Rules\Fields\Commom\PhoneRules;
use App\Rules\Fields\Address\StreetRules;
use App\Rules\Fields\Address\NumberRules;
use App\Rules\Fields\Address\ComplementRules;
use App\Rules\Fields\Address\NeighborhoodRules;
use App\Rules\Fields\Address\CityRules;

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

    /**
     * Test update company with null street.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullStreet(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'street' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['street']);

        $response->assertJsonFragment([
            'street' => [
                'The street field must be a string.',
                'The street field must be at least ' . StreetRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with empty street.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyStreet(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'street' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['street']);

        $response->assertJsonFragment([
            'street' => [
                'The street field must be a string.',
                'The street field must be at least ' . StreetRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with street too tiny.
     *
     * @return void
     */
    public function testUpdateCompanyWithStreetTooTiny(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'street' => Str::random(StreetRules::MIN_LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['street']);

        $response->assertJsonFragment([
            'street' => [
                'The street field must be at least ' . StreetRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with street too long.
     *
     * @return void
     */
    public function testUpdateCompanyWithStreetTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'street' => Str::random(StreetRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['street']);

        $response->assertJsonFragment([
            'street' => [
                'The street field must not be greater than ' . StreetRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid street.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidStreet(): void
    {
        $this->actingAs($this->user);

        $street = $this->faker->streetName;

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'street' => $street,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'street' => $street,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'street' => $street,
        ]);
    }

    /**
     * Test update company with null number.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullNumber(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'number' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['number']);

        $response->assertJsonFragment([
            'number' => [
                'The number field must be a string.',
            ],
        ]);
    }

    /**
     * Test try update company with empty number.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyNumber(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'number' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['number']);

        $response->assertJsonFragment([
            'number' => [
                'The number field must be a string.',
            ],
        ]);
    }

    /**
     * Test try update company with number too long.
     *
     * @return void
     */
    public function testUpdateCompanyWithNumberTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'number' => Str::random(NumberRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['number']);

        $response->assertJsonFragment([
            'number' => [
                'The number field must not be greater than ' . NumberRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid number.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidNumber(): void
    {
        $this->actingAs($this->user);

        $number = Str::random(NumberRules::MAX_LENGTH);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'number' => $number,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'number' => $number,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'number' => $number,
        ]);
    }

    /**
     * Test try update company with too long complement.
     *
     * @return void
     */
    public function testUpdateCompanyWithTooLongComplement(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'complement' => Str::random(ComplementRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['complement']);

        $response->assertJsonFragment([
            'complement' => [
                'The complement field must not be greater than ' . ComplementRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with null complement.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullComplement(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'complement' => null,
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'complement' => null,
        ]);
    }

    /** 
     * Test update company with valid complement.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidComplement(): void
    {
        $this->actingAs($this->user);

        $complement = $this->faker->word();

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'complement' => $complement,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'complement' => $complement,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'complement' => $complement,
        ]);
    }

    /**
     * Test update company with empty complement.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyComplement(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'complement' => '',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'complement' => null,
        ]);
    }

    /**
     * Test update company with null neighborhood.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullNeighborhood(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'neighborhood' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['neighborhood']);

        $response->assertJsonFragment([
            'neighborhood' => [
                'The neighborhood field must be a string.',
                'The neighborhood field must be at least ' . NeighborhoodRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with empty neighborhood.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyNeighborhood(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'neighborhood' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['neighborhood']);

        $response->assertJsonFragment([
            'neighborhood' => [
                'The neighborhood field must be a string.',
                'The neighborhood field must be at least ' . NeighborhoodRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with neighborhood too tiny.
     *
     * @return void
     */
    public function testUpdateCompanyWithNeighborhoodTooTiny(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'neighborhood' => Str::random(NeighborhoodRules::MIN_LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['neighborhood']);

        $response->assertJsonFragment([
            'neighborhood' => [
                'The neighborhood field must be at least ' . NeighborhoodRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with too long neighborhood.
     *
     * @return void
     */
    public function testUpdateCompanyWithTooLongNeighborhood(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'neighborhood' => Str::random(NeighborhoodRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['neighborhood']);

        $response->assertJsonFragment([
            'neighborhood' => [
                'The neighborhood field must not be greater than ' . NeighborhoodRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid neighborhood.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidNeighborhood(): void
    {
        $this->actingAs($this->user);

        $neighborhood = $this->faker->streetSuffix;

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'neighborhood' => $neighborhood,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'neighborhood' => $neighborhood,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'neighborhood' => $neighborhood,
        ]);
    }

    /**
     * Test update company with null city.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullCity(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'city' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['city']);

        $response->assertJsonFragment([
            'city' => [
                'The city field must be a string.',
                'The city field must be at least ' . CityRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with empty city.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyCity(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'city' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['city']);

        $response->assertJsonFragment([
            'city' => [
                'The city field must be a string.',
                'The city field must be at least ' . CityRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with city too tiny.
     *
     * @return void
     */
    public function testUpdateCompanyWithCityTooTiny(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'city' => Str::random(CityRules::MIN_LENGTH - 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['city']);

        $response->assertJsonFragment([
            'city' => [
                'The city field must be at least ' . CityRules::MIN_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with city too long.
     *
     * @return void
     */
    public function testUpdateCompanyWithCityTooLong(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'city' => Str::random(CityRules::MAX_LENGTH + 1),
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['city']);

        $response->assertJsonFragment([
            'city' => [
                'The city field must not be greater than ' . CityRules::MAX_LENGTH . ' characters.',
            ],
        ]);
    }

    /**
     * Test update company with valid city.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidCity(): void
    {
        $this->actingAs($this->user);

        $city = $this->faker->city;

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'city' => $city,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'city' => $city,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'city' => $city,
        ]);
    }

    /**
     * Test update company with null state.
     *
     * @return void
     */
    public function testUpdateCompanyWithNullState(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'state' => null,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['state']);

        $response->assertJsonFragment([
            'state' => [
                'The state field must be a string.',
                'The selected state is invalid.',
            ],
        ]);
    }

    /**
     * Test update company with empty state.
     *
     * @return void
     */
    public function testUpdateCompanyWithEmptyState(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'state' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['state']);

        $response->assertJsonFragment([
            'state' => [
                'The state field must be a string.',
                'The selected state is invalid.',
            ],
        ]);
    }

    /** 
     * Test update company with invalid state.
     *
     * @return void
     */
    public function testUpdateCompanyWithInvalidState(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'state' => 'invalid',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['state']);

        $response->assertJsonFragment([
            'state' => [
                'The selected state is invalid.',
            ],
        ]);
    }

    /**
     * Test update company with valid state.
     *
     * @return void
     */
    public function testUpdateCompanyWithValidState(): void
    {
        $this->actingAs($this->user);

        $state = $this->faker->randomElement(StatesEnum::values());

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, [
            'state' => $state,
        ]);

        $response->assertOk();

        $response->assertJsonFragment([
            'state' => $state,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'state' => $state,
        ]);
    }

    /**
     * Test update full company.
     *
     * @return void
     */
    public function testUpdateFullCompany(): void
    {
        $this->actingAs($this->user);

        $data = [
            'name' => $this->faker->name,
            'cnpj' => $this->faker->numerify(str_repeat('#', CnpjRules::LENGTH)),
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify(str_repeat('#', PhoneRules::LENGTH)),
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional()->word(),
            'neighborhood' => $this->faker->streetSuffix(),
            'city' => $this->faker->city,
            'state' => $this->faker->randomElement(StatesEnum::values()),
        ];

        $response = $this->json('PATCH', 'api/companies/' . $this->company->id, $data);

        $response->assertOk();

        $response->assertJsonFragment([
            'id' => $this->company->id,
            'name' => $data['name'],
            'cnpj' => $data['cnpj'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'street' => $data['street'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],
            'created_at' => $this->company->created_at,
            'updated_at' => $this->company->updated_at,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'name' => $data['name'],
            'cnpj' => $data['cnpj'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'street' => $data['street'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],
        ]);
    }
}
