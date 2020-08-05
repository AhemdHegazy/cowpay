<?php

namespace Esameisa\Cowpay\Strategy;

use Esameisa\Cowpay\Enums\PaymentMethod;
use Esameisa\Cowpay\Interfaces\CowpayStrategyInterface;
use Exception;

class Fawry extends Cowpay implements CowpayStrategyInterface
{
    /**
     * Create instance of Cowpay::class and set payment method as PaymentMethod::CARD.
     */
    public function __construct()
    {
        app(Cowpay::class); // make instance
        Cowpay::setPaymentMethod(PaymentMethod::PAYATFAWRY);
    }

    /**
     * Pay.
     *
     * @return fawry response
     */
    public function pay($customer)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $apiRequest = $client->request(
                'POST',
                Cowpay::generateApiUrl('fawry/charge-request'),
                [
                    'form_params' => $this->customerData($customer),
                ]
            );

            $response = json_decode($apiRequest->getBody()->getContents(), false);

            return $response;
        } catch (Exception $ex) {
            abort(403, $ex->getMessage());
        }
    }

    /**
     * User data.
     *
     * @return customer data
     */
    public function customerData($customer)
    {
        return Cowpay::basicCustomerData($customer);
    }
}
