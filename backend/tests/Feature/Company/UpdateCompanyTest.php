<?php

namespace Tests\Feature\Company;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use App\Rules\Fields\Commom\CnpjRules;
use App\Rules\Fields\Company\NameRules;

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
}
