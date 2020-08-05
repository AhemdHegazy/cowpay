<?php

namespace Esameisa\Cowpay\Strategy;

use Esameisa\Cowpay\Enums\PaymentMethod;
use Esameisa\Cowpay\Interfaces\CowpayStrategyInterface;
use Exception;

class CreditCard extends Cowpay implements CowpayStrategyInterface
{
    /**
     * Create instance of Cowpay::class and set payment method as PaymentMethod::CARD.
     */
    public function __construct()
    {
        app(Cowpay::class); // make instance
        Cowpay::setPaymentMethod(PaymentMethod::CARD);
    }

    /**
     * Pay.
     *
     * @return credit card response
     */
    public function pay($customer)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $apiRequest = $client->request(
                'POST',
                Cowpay::generateApiUrl('fawry/charge-request-cc'),
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
        return array_merge(
            [
                'card_number'   => $customer['card_number'],
                'expiry_year'   => $customer['expiry_year'],
                'expiry_month'  => $customer['expiry_month'],
                'cvv'           => $customer['cvv'],
                'save_card'     => (bool) $customer['save_card'],
            ],
            (array) Cowpay::basicCustomerData($customer)
        );
    }

    /**
     * Generate Card Token.
     *
     * @return Card Token
     */
    public function generateCardToken($data)
    {
        $client = new \GuzzleHttp\Client();

        $apiRequest = $client->request(
            'POST',
            Cowpay::generateApiUrl('fawry/generate-card-token'),
            [
                'form_params' => $this->getCardTokenParams($data),
            ]
        );

        $response = json_decode($apiRequest->getBody()->getContents(), false);

        return $response;
    }

    /**
     * Card Token Params.
     *
     * @return Card Token Params
     */
    public function getCardTokenParams($data)
    {
        return [
            'merchant_code'                 => Cowpay::getMerchantCode(),
            'customer_merchant_profile_id'  => Cowpay::getUserId(),
            'card_number'                   => $data['card_number'],
            'expiry_year'                   => $data['expiry_year'],
            'expiry_month'                  => $data['expiry_month'],
            'cvv'                           => $data['cvv'],
            'customer_name'                 => $data['customer_name'],
            'customer_mobile'               => $data['customer_mobile'],
            'customer_email'                => $data['customer_email'],
        ];
    }
}
