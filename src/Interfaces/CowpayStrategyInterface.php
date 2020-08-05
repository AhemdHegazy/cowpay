<?php

namespace Esameisa\Cowpay\Interfaces;

interface CowpayStrategyInterface
{
    public function generateApiUrl($endpoint);

    public function setInitParameters(int $order_id, int $user_id, float $amount);

    public function generateSignature();

    public function pay($customer);

    public function customerData($customer);
}
