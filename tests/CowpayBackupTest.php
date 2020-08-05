<?php

namespace Esameisa\Cowpay\Tests;

use DemeterChain\C;
use Esameisa\Cowpay\Strategy\Cowpay;
use Esameisa\Cowpay\Strategy\Fawry;
use Tests\TestCase;
// use Orchestra\Testbench\TestCase;
// use PHPUnit\Framework\TestCase;

class CowpayBackupTest extends TestCase
{
    public function testBasicBackupTest()
    {
        $payment = new Fawry();

        $order_id = rand(1, 2147483647);
        $user_id = rand(1, 2147483647);
        $amount = rand(1, 1000);

        $payment->setInitParameters($order_id, $user_id, $amount);

//        $response = $payment->pay([
//            'customer_name'     => 'Esam Eisa',
//            'customer_mobile'   => '01098950608',
//            'customer_email'    => 'esameisa12345@gmail.com',
//            'description'       => 'test package',
//            'charge_items'      => collect(
//                [
//                    'itemId'        => '897fa8e81be26df25db592e81c31c',
//                    'description'   => 'asdasd',
//                    'price'         => '25.00',
//                    'quantity'      => '1',
//                ]
//            ),
//            'card_number'   => '4005550000000001',
//            'expiry_year'   => '21',
//            'expiry_month'  => '05',
//            'cvv'           => '123',
//            'save_card'     => '0',
//        ]);

        $response = $this->mock(Fawry::class)->shouldReceive('pay')->andReturn(json_encode([
            "success" => true,
            "status_code" => 200,
            "status_description" => "Operation done successfully",
            "type" => "Charge Request",
            "cowpay_reference_id" => rand(1, 1000),
            "merchant_reference_id" => $order_id,
            "payment_gateway_reference_id" => rand(1, 1000),
        ]));
//        dd($response);

        $this->assertIsObject($response);

//        $this->assertEquals($order_id, $response->merchant_reference_id);
    }
}
