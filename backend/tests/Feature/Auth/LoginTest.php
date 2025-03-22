<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /**
     * Test try login without credentials.
     *
     * @return void
     */
    public function testTryLoginWithoutCredentials(): void
    {
        $response = $this->json('POST', 'api/auth/');

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email', 'password']);
        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
    }

    /**
     * Test try login without email.
     *
     * @return void
     */
    public function testTryLoginWithoutEmail(): void
    {
        $response = $this->json('POST', 'api/auth/', ['password' => '12345']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment(['email' => ['The email field is required.']]);
    }

    /**
     * Test try login with invalid email.
     *
     * @return void
     */
    public function testTryLoginWithInvalidEmail(): void
    {
        $response = $this->json(
            'POST',
            'api/auth/',
            ['email' => 'invalid_email', 'password' => '12345']
        );

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment(['email' => ['The email field must be a valid email address.']]);
    }

    /**
     * Test try login without password.
     *
     * @return void
     */
    public function testTryLoginWithoutPassword(): void
    {
        $response = $this->json('POST', 'api/auth/', ['email' => 'test@email.com']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
        $response->assertJsonFragment(['password' => ['The password field is required.']]);
    }

    /**
     * Test try login with invalid credentials.
     *
     * @return void
     */
    public function testTryLoginWithInvalidCredentials(): void
    {
        $response = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => 'test@email.com',
                'password' => '12345'
            ]
        );

        $response->assertUnauthorized();
    }

    /**
     * Test login successfully.
     *
     * @return void
     */
    public function testLoginSuccessfully(): void
    {
        $email = 'test@email.com';
        $password = '54321';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }
}
