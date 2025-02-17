<?php

namespace PrestaShopCorp\Billing\Tests\Unit\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Psr7\Response as Psr7Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use PHPUnit\Framework\TestCase;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;
use PrestaShopCorp\Billing\Clients\BillingClient;
use Psr\Http\Message\RequestInterface;

class testClient extends Client implements HttpClientInterface
{
    public static $response;

    public function __construct($configClient, $mockResponse)
    {
        parent::__construct($configClient);
        testClient::$response = $mockResponse;
    }

    public function sendRequest(RequestInterface $request)
    {
        return new Psr7Response(200, [], json_encode(testClient::$response));
    }
}

class BillingClientTest extends TestCase
{
    protected $customer;
    protected $subscription;
    protected $plans;

    protected function setUp()
    {
        parent::setUp();
        $this->customer = [
            'id' => 'b2581e4b-0030-4fc8-9bf2-7f01c550a946',
            'email' => 'takeshi.daveau@prestashop.com',
            'auto_collection' => 'on',
            'created_at' => 1646842866,
            'billing_address' => [
                'first_name' => 'Takeshi',
                'last_name' => 'Daveau',
                'company' => 'TDA',
                'line1' => 'Rue des rue',
                'city' => 'Lilas',
                'country' => 'FR',
                'zip' => '93333',
            ],
            'card_status' => 'valid',
            'primary_payment_source_id' => 'pm_AzqMGNSzhOTDa1BEP',
            'payment_method' => [
                'type' => 'card',
                'gateway' => 'stripe',
                'gateway_account_id' => 'gw_Azqe1TSLVjdNhdI',
                'status' => 'valid',
                'reference_id' => 'cus_LIQGgPFSj2r39T/card_1KbpQHGp5Dc2lo8uEdDJv8ac',
            ],
            'cf_shop_id' => 'b2581e4b-0030-4fc8-9bf2-7f01c550a946',
            'cf_consent' => 'False',
        ];
        $this->subscription = [
            'id' => '169lnASzhOWay1EQN',
            'plan_id' => 'rbm-advanced',
            'customer_id' => 'b2581e4b-0030-4fc8-9bf2-7f01c550a946',
            'status' => 'in_trial',
            'currency_code' => 'EUR',
            'has_scheduled_changes' => false,
            'billing_period' => 1,
            'billing_period_unit' => 'month',
            'due_invoices_count' => 0,
            'meta_data' => [
                'module' => 'rbm_example',
            ],
            'plan_amount' => 2000,
            'plan_quantity' => 1,
            'plan_unit_price' => 2000,
            'subscription_items' => [
                [
                    'item_price_id' => 'rbm-advanced',
                    'amount' => 2000,
                    'item_type' => 'plan',
                    'quantity' => 1,
                    'unit_price' => 2000,
                ],
            ],
            'created_at' => 1646931926,
            'cancelled_at' => 1648335600,
            'started_at' => 1646866800,
            'updated_at' => 1646934561,
            'trial_end' => 1648335599,
            'coupon' => [
                'coupon_id' => 'TDATEST20PERCENT',
                'applied_count' => 1,
                'coupon_code' => 'tda6359-20',
                'apply_till' => 1654811999,
            ],
            'is_free_trial_used' => true,
        ];
        $this->plans = [
            'limit' => 100,
            'offset' => null,
            'results' => [
                [
                    'id' => 'rbm-free',
                    'name' => 'rbm free',
                    'details_plan' => [
                        'title' => 'rbm free',
                        'features' => [
                            'Fonctionnalité 1 du rbm free',
                            'Fonctionnalité 2 du rbm free',
                            'Fonctionnalité 3 du rbm free',
                            'Fonctionnalité 4 du rbm free',
                        ],
                    ],
                    'price' => 100,
                    'period' => 1,
                    'currency_code' => 'EUR',
                    'period_unit' => 'month',
                    'trial_period' => 7,
                    'trial_period_unit' => 'day',
                    'pricing_model' => 'flat_fee',
                    'meta_data' => [
                        'module' => 'rbm_example',
                    ],
                ],
                [
                    'id' => 'rbm-advanced',
                    'name' => 'rbm advanced',
                    'details_plan' => [
                        'title' => 'rbm advanced',
                        'features' => [
                            'Fonctionnalité 1 du rbm advanced',
                            'Fonctionnalité 2 du rbm advanced',
                            'Fonctionnalité 3 du rbm advanced',
                            'Fonctionnalité 4 du rbm advanced',
                        ],
                    ],
                    'price' => 2000,
                    'period' => 1,
                    'currency_code' => 'EUR',
                    'period_unit' => 'month',
                    'trial_period' => 7,
                    'trial_period_unit' => 'day',
                    'pricing_model' => 'flat_fee',
                    'meta_data' => [
                        'module' => 'rbm_example',
                    ],
                ],
                [
                    'id' => 'rbm-ultimate',
                    'name' => 'rbm ultimate',
                    'details_plan' => [
                        'title' => 'rbm ultimate',
                        'features' => [
                            'Fonctionnalité 1 du rbm ultimate',
                            'Fonctionnalité 2 du rbm ultimate',
                            'Fonctionnalité 3 du rbm ultimate',
                            'Fonctionnalité 4 du rbm ultimate',
                        ],
                    ],
                    'price' => 10000,
                    'period' => 1,
                    'currency_code' => 'EUR',
                    'period_unit' => 'month',
                    'trial_period' => 7,
                    'trial_period_unit' => 'day',
                    'pricing_model' => 'flat_fee',
                    'meta_data' => [
                        'module' => 'rbm_example',
                    ],
                ],
                [
                    'id' => 'rbm-exempl-test',
                    'name' => 'rbm exempl test',
                    'details_plan' => null,
                    'price' => 999900,
                    'period' => 1,
                    'currency_code' => 'EUR',
                    'period_unit' => 'month',
                    'pricing_model' => 'flat_fee',
                    'meta_data' => [
                        'module' => 'rbm_example',
                    ],
                ],
            ],
        ];
    }

    public function testRetrieveCustomerById()
    {
        $billingClient = $this->getBillingClient($this->customer);
        $result = $billingClient->retrieveCustomerById('b2581e4b-0030-4fc8-9bf2-7f01c550a946');

        // Test the format and the content
        $this->assertEquals($result['success'], true);
        $this->assertEquals($result['httpStatus'], 200);
        $this->assertEquals($result['body'], $this->customer);
    }

    public function testRetrieveSubscriptionByCustomerId()
    {
        $billingClient = $this->getBillingClient($this->subscription);
        $result = $billingClient->retrieveSubscriptionByCustomerId('b2581e4b-0030-4fc8-9bf2-7f01c550a946');

        // Test the format and the content
        $this->assertEquals($result['success'], true);
        $this->assertEquals($result['httpStatus'], 200);
        $this->assertEquals($result['body'], $this->subscription);
    }

    public function testRetrievePlansShouldCallTheProperRoute()
    {
        $billingClient = $this->getBillingClient($this->plans);
        $result = $billingClient->retrievePlans('fr');

        // Test the format and the content
        $this->assertEquals($result['success'], true);
        $this->assertEquals($result['httpStatus'], 200);
        $this->assertEquals($result['body'], $this->plans);
    }

    /**
     * getBillingClientAndContainer
     *
     * @param $mockData
     *
     * @return BillingClient
     */
    private function getBillingClient($mockData)
    {
        $response = new Response(200, [], Stream::factory(json_encode($mockData)));
        $mock = new Mock([
            $response,
        ]);

        $client = new testClient([
            'base_url' => 'http://localhost/',
            'defaults' => [
                'timeout' => 20,
                'exceptions' => true,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IjM1MDM0MmIwMjU1MDAyYWI3NWUwNTM0YzU4MmVjYzY2Y2YwZTE3ZDIiLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoiUHJlc3RhU2hvcCIsImlzcyI6Imh0dHBzOi8vc2VjdXJldG9rZW4uZ29vZ2xlLmNvbS9wcmVzdGFzaG9wLXJlYWR5LXByb2QiLCJhdWQiOiJwcmVzdGFzaG9wLXJlYWR5LXByb2QiLCJhdXRoX3RpbWUiOjE2MzMxMDIzNzgsInVzZXJfaWQiOiJNbjZvdTg2dUFUUkJydFlqRlVua1pmNkZjNWUyIiwic3ViIjoiTW42b3U4NnVBVFJCcnRZakZVbmtaZjZGYzVlMiIsImlhdCI6MTYzMzcwNDcxNywiZXhwIjoxNjMzNzA4MzE3LCJlbWFpbCI6InRha2VzaGlfZGVtby1uaWFrX3ByZXN0YXNob3BfbmV0LTJhNjVhNDVhZUBwc2FjY291bnRzLnBzZXNzZW50aWFscy5uZXQiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZW1haWwiOlsidGFrZXNoaV9kZW1vLW5pYWtfcHJlc3Rhc2hvcF9uZXQtMmE2NWE0NWFlQHBzYWNjb3VudHMucHNlc3NlbnRpYWxzLm5ldCJdfSwic2lnbl9pbl9wcm92aWRlciI6ImN1c3RvbSJ9fQ.WIqbDpoC_6o4eVfcr2RzJCQPz-IOFh9mtlOdhNOaNEu4cKJGPe7ARl_Sp36LsW0cuVePIijbWZiLubLXoycQ6W07KnBvR6SQ_3KpfxE5GUIFeGPsrNMPJ1qkvPDGOO_YEYp17oFQ5LYswq9-JeMWR3YbM4oENI6WD1jM5_iWaOY3BrdH5BRRraIwCVfiWsKuknTH-qEWU1AP2DNqtQstll8WOo01QAA-yocgS9zjoSJSBlqikdUoE3pYmH2C-fj5ZALEN4Qg27qchXW3L2wIc-16BQpqdnh2hst6kAB0pOcMi-G3UaXa569heoSBpf7Tu2gxdTgmNcbzubKrGMFLTg',
                ],
            ],
        ], $mockData);

        $client->getEmitter()->attach($mock);

        return new BillingClient('rbm_example', $client);
    }
}
