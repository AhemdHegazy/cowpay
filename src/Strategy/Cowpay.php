<?php

namespace Esameisa\Cowpay\Strategy;

class Cowpay
{
    private static $base_url;
    private static $merchant_code;
    private static $m_hash_key;
    private static $currency;

    protected $order_id;
    protected $user_id;
    protected $amount;
    protected $payment_method;

    /**
     * Set base url, merchant code, m hash key, currency.
     */
    public function __construct($base_url, $merchant_code, $m_hash_key, $currency)
    {
        self::$base_url = $base_url;
        self::$merchant_code = $merchant_code;
        self::$m_hash_key = $m_hash_key;
        self::$currency = $currency;
    }

    /**
     * Generate api full url.
     */
    public function generateApiUrl($endpoint)
    {
        return $this->getBaseUrl() . $endpoint;
    }

    /**
     * Set order id, user id, amount.
     */
    public function setInitParameters(int $order_id, int $user_id, float $amount)
    {
        $this->setOrderId($order_id);
        $this->setUserId($user_id);
        $this->setAmount($amount);
    }

    /**
     * Generate signature.
     */
    public function generateSignature()
    {
        return hash(
            'sha256',
            self::$merchant_code .
                $this->order_id .
                $this->user_id .
                $this->payment_method .
                $this->amount .
                self::$m_hash_key
        );
    }

    /**
     * User data.
     *
     * @return customer data
     */
    public function basicCustomerData($customer)
    {
        return [
            'customer_name'     => $customer['customer_name'],
            'customer_mobile'   => $customer['customer_mobile'],
            'customer_email'    => $customer['customer_email'],
            'charge_items'      => $customer['charge_items'],
            'description'       => $customer['description'],

            'merchant_code' => $this->getMerchantCode(),
            'currency_code' => $this->getCurrency(),
            'signature'     => $this->generateSignature(),

            'customer_merchant_profile_id'  => $this->user_id,
            'merchant_reference_id'         => $this->order_id,
            'payment_method'                => $this->payment_method,
            'amount'                        => $this->amount,
        ];
    }

    /**
     * Set order id.
     */
    protected function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Set user id.
     */
    protected function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get user id.
     */
    protected function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set payment method.
     */
    protected function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    /**
     * Set amount.
     */
    protected function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get base url.
     */
    public static function getBaseUrl()
    {
        return self::$base_url;
    }

    /**
     * Get merchant code.
     */
    public static function getMerchantCode()
    {
        return self::$merchant_code;
    }

    /**
     * Get m hash key.
     */
    public static function getMHashKey()
    {
        return self::$m_hash_key;
    }

    /**
     * Get currency.
     */
    public static function getCurrency()
    {
        return self::$currency;
    }
}
