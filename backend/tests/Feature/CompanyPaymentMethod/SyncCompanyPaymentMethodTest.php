<?php

namespace Tests\Feature\CompanyPaymentMethod;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyPaymentMethod;

use App\Enums\Financial\PaymentMethodsEnum;

class SyncCompanyPaymentMethodTest extends TestCase
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
     * Test try sync company payment method not logged.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodNotLogged(): void
    {
        $company = Company::factory()->create();

        $response = $this->json('POST', 'api/companies/' . $company->id . '/payment-methods');

        $response->assertUnauthorized();
    }

    /**
     * Test try sync company payment method with another user.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodWithAnotherUser(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods');

        $response->assertForbidden();
    }

    /**
     * Test try sync company payment method with invalid company id.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodWithInvalidCompanyId(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/9999/payment-methods');

        $response->assertNotFound();
    }

    /**
     * Test try sync company payment method with invalid data type.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodWithInvalidDataType(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => 'invalid'
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'methods' => [
                'The methods field must be an array.'
            ]
        ]);
    }

    /**
     * Test try sync company payment method empty payment methods.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodEmptyPaymentMethods(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => []
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'methods' => [
                'The methods field is required.'
            ]
        ]);
    }

    /**
     * Test try sync company payment method with invalid payment methods.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodWithInvalidPaymentMethods(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => [PaymentMethodsEnum::CREDIT_CARD->value, null, PaymentMethodsEnum::PIX->value]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'methods' => [
                'The methods has invalid payment methods.',
            ]
        ]);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => [PaymentMethodsEnum::CREDIT_CARD->value, 'invalid', PaymentMethodsEnum::PIX->value]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'methods' => [
                'The methods has invalid payment methods.',
            ]
        ]);
    }

    /**
     * Test try sync company payment method with duplicated payment methods.
     *
     * @return void
     */
    public function testTrySyncCompanyPaymentMethodWithDuplicatedPaymentMethods(): void
    {
        $this->actingAs($this->user);

        $paymentMethods = [
            PaymentMethodsEnum::CREDIT_CARD->value,
            PaymentMethodsEnum::CREDIT_CARD->value,
            PaymentMethodsEnum::PIX->value,
        ];

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => $paymentMethods
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'methods' => [
                'The methods field has duplicated values.'
            ]
        ]);
    }

    /**
     * Test sync company payment method with valid payment methods.
     *
     * @return void
     */
    public function testSyncCompanyPaymentMethodWithValidPaymentMethods(): void
    {
        $this->actingAs($this->user);

        $methods = [
            PaymentMethodsEnum::CREDIT_CARD->value,
            PaymentMethodsEnum::PIX->value,
        ];

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => $methods
        ]);

        $response->assertOk();
        $response->assertJsonStructure([[
            'id',
            'payment_method',
        ]]);

        $response->assertJsonCount(count($methods));
        $response->assertExactJson($this->company->paymentMethods->toArray());

        $this->assertDatabaseHas(CompanyPaymentMethod::class, [
            'company_id' => $this->company->id,
            'payment_method' => PaymentMethodsEnum::CREDIT_CARD->value,
        ]);

        $this->assertDatabaseHas(CompanyPaymentMethod::class, [
            'company_id' => $this->company->id,
            'payment_method' => PaymentMethodsEnum::PIX->value,
        ]);
    }

    /**
     * Test change company payment methods.
     *
     * @return void
     */
    public function testChangeCompanyPaymentMethods(): void
    {
        $this->actingAs($this->user);
        $this->company->paymentMethods()->create([
            'payment_method' => PaymentMethodsEnum::CREDIT_CARD->value,
        ]);

        $this->assertDatabaseHas(CompanyPaymentMethod::class, [
            'company_id' => $this->company->id,
            'payment_method' => PaymentMethodsEnum::CREDIT_CARD->value,
        ]);

        $response = $this->json('POST', 'api/companies/' . $this->company->id . '/payment-methods', [
            'methods' => [PaymentMethodsEnum::PIX->value]
        ]);

        $response->assertOk();
        $response->assertExactJson($this->company->paymentMethods->toArray());

        $this->assertDatabaseMissing(CompanyPaymentMethod::class, [
            'company_id' => $this->company->id,
            'payment_method' => PaymentMethodsEnum::CREDIT_CARD->value,
        ]);

        $this->assertDatabaseHas(CompanyPaymentMethod::class, [
            'company_id' => $this->company->id,
            'payment_method' => PaymentMethodsEnum::PIX->value,
        ]);
    }
}
