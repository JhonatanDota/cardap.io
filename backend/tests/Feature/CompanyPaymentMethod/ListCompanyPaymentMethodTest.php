<?php

namespace Tests\Feature\CompanyPaymentMethod;

use Tests\TestCase;

use App\Models\User;
use App\Models\Company;

class ListCompanyPaymentMethodTest extends TestCase
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
     * Test list company payment method not logged.
     *
     * @return void
     */
    public function testListCompanyPaymentMethodNotLogged(): void
    {
        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/payment-methods');

        $response->assertOk();
    }

    /**
     * Test list company payment method logged.
     *
     * @return void
     */
    public function testListCompanyPaymentMethodLogged(): void
    {
        $this->actingAs($this->user);

        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/payment-methods');

        $response->assertOk();
        $response->assertJsonFragment([]);
    }

    /**
     * Test try list company payment method with invalid company id.
     *
     * @return void
     */
    public function testTryListCompanyPaymentMethodWithInvalidCompanyId(): void
    {
        $response = $this->json('GET', 'api/companies/9999/payment-methods');
        $response->assertNotFound();
    }

    /**
     * Test list company payment method than dont have payment methods.
     *
     * @return void
     */
    public function testListCompanyPaymentMethodThanDontHavePaymentMethods(): void
    {
        $company = Company::factory()->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/payment-methods');

        $response->assertOk();
        $response->assertExactJson([]);
        $response->assertJsonCount(0);
    }

    /**
     * Test list company payment method than have payment methods.
     *
     * @return void
     */
    public function testListCompanyPaymentMethodThanHavePaymentMethods(): void
    {
        $paymentMethodCount = 3;
        $company = Company::factory()->hasPaymentMethods($paymentMethodCount)->create();

        $response = $this->json('GET', 'api/companies/' . $company->id . '/payment-methods');

        $response->assertOk();
        $response->assertExactJson($company->paymentMethods->toArray());
        $response->assertJsonStructure([
            [
                'id',
                'company_id',
                'payment_method',
            ]
        ]);
        $response->assertJsonCount($paymentMethodCount);
    }
}
