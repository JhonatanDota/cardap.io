<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Str;

use App\Rules\Fields\User\NameRules;
use App\Rules\Fields\User\PasswordRules;
use App\Rules\Fields\Commom\EmailRules;

class RegisterTest extends TestCase
{
    /**
     * Test try register without name.
     *
     * @return void
     */
    public function testTryRegisterWithoutName(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try register with too tiny name.
     *
     * @return void
     */
    public function testTryRegisterWithTooTinyName(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'name' => Str::random(NameRules::MIN_LENGTH - 1),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field must be at least ' . NameRules::MIN_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try register with too long name.
     *
     * @return void
     */
    public function testTryRegisterWithTooLongName(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'name' => Str::random(NameRules::MAX_LENGTH + 1),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'name',
        ]);

        $response->assertJsonFragment([
            'name' => ['The name field must not be greater than ' . NameRules::MAX_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try register without email.
     *
     * @return void
     */
    public function testTryRegisterWithoutEmail(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
        ]);
    }

    /**
     * Test try register with invalid email.
     *
     * @return void
     */
    public function testTryRegisterWithInvalidEmail(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => 'invalid@mail',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field format is invalid.'],
        ]);
    }

    /**
     * Test try register with email too long.
     *
     * @return void
     */
    public function testTryRegisterWithEmailTooLong(): void
    {
        $password = $this->faker->password();

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => Str::random(EmailRules::MAX_LENGTH + 1) . '@mail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email field must not be greater than ' . EmailRules::MAX_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try register with duplicated email.
     *
     * @return void
     */
    public function testTryRegisterWithDuplicatedEmail(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();

        $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'email',
        ]);

        $response->assertJsonFragment([
            'email' => ['The email has already been taken.'],
        ]);
    }

    /**
     * Test try register without password.
     *
     * @return void
     */
    public function testTryRegisterWithoutPassword(): void
    {
        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'password',
        ]);

        $response->assertJsonFragment([
            'password' => ['The password field is required.'],
        ]);
    }

    /**
     * Test try register without password confirmation.
     *
     * @return void
     */
    public function testTryRegisterWithoutPasswordConfirmation(): void
    {
        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'password',
        ]);

        $response->assertJsonFragment([
            'password' => ['The password field confirmation does not match.'],
        ]);
    }

    /**
     * Test try register with too tiny password.
     *
     * @return void
     */
    public function testTryRegisterWithTooTinyPassword(): void
    {
        $password = Str::random(PasswordRules::MIN_LENGTH - 1);

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'password',
        ]);

        $response->assertJsonFragment([
            'password' => ['The password field must be at least ' . PasswordRules::MIN_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try register with too long password.
     *
     * @return void
     */
    public function testTryRegisterWithTooLongPassword(): void
    {
        $password = Str::random(PasswordRules::MAX_LENGTH + 1);

        $response = $this->json('POST', 'api/register/', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'password',
        ]);

        $response->assertJsonFragment([
            'password' => ['The password field must not be greater than ' . PasswordRules::MAX_LENGTH . ' characters.'],
        ]);
    }

    /**
     * Test try register successfully.
     *
     * @return void
     */
    public function testTryRegisterSuccessfully(): void
    {
        $password = $this->faker->password();

        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->json('POST', 'api/register/', $userData);
        $responseData = $response->json();

        $response->assertCreated();

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ]);

        $response->assertJsonFragment([
            'name' => $userData['name'],
            'email' => $userData['email']
        ]);

        $this->assertArrayNotHasKey('password', $responseData);
        $this->assertArrayNotHasKey('password_confirmation', $responseData);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }
}
