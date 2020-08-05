<p align="center"><img src="https://github.com/esameisa/cowpay/blob/master/logo.png" width="100"></p>

<p align="center">
<a href="https://github.com/esameisa/cowpay/stargazers"><img src="https://img.shields.io/github/stars/esameisa/cowpay.svg?style=flat-square" alt="License"></a>
<a href="https://github.com/esameisa/cowpay/issues"><img src="https://img.shields.io/github/issues/esameisa/cowpay.svg?style=flat-square)" alt="License"></a>
<a href="https://travis-ci.org/esameisa/cowpay"><img src="https://travis-ci.org/esameisa/cowpay.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/esameisa/cowpay"><img src="https://poser.pugx.org/esameisa/cowpay/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/esameisa/cowpay"><img src="https://poser.pugx.org/esameisa/cowpay/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://github.com/prettier/prettier"><img src="https://img.shields.io/badge/code_style-prettier-ff69b4.svg?style=flat-square" alt="Prettier"></a>
<a href="https://packagist.org/packages/esameisa/cowpay"><img src="https://poser.pugx.org/esameisa/cowpay/license.svg" alt="License"></a>
</p>

## About COWPAY

COWPAY is a premium **payment technology** enabler dedicated to helping businesses transform their operation collecting, splitting, and disbursing money digitally!

## Install

Install the Cowpay library via Composer.

```shell
$ composer require esameisa/cowpay
```

Use the `php artisan vendor:publish` Artisan command to publish the configuration file into your config directory.

In **.env** file, you can put `MERCHANT_CODE` and `M_HASH_KEY`, get values from your profile at [cowpay.me](https://cowpay.me/merchant/profile/edit-api-settings).

```env
MERCHANT_CODE=********
M_HASH_KEY=********************
```

Register service provider in config/app

```php
Esameisa\Cowpay\Providers\CowpayServiceProvider::class,
```

## Usage

1- Creating instance from:

- `Fawry`: use when you want to pay via `fawry`

- `CreditCard`: use when you want to pay via `credit card`

2- Call `setInitParameters` method with 3 paramters `$order_id` `$user_id` `$amount`

3- Call `pay` method with array of [customerData](#customerdata-sample-array-for-pay-via-fawry)

<br>

**Sample of code:**

```php
$payWithCowpay = new Fawry();

$payWithCowpay->setInitParameters($order_id, $user_id, $amount);

$response = $payWithCowpay->pay($customerData);
```

<br>

Description of each parameter you can send to `pay` method

| Parameter       | Description                                                                                 |
| :-------------- | :------------------------------------------------------------------------------------------ |
| customer_name   | The customer name in merchant system.                                                       |
| customer_mobile | The customer mobile in merchant system.                                                     |
| customer_email  | The customer email in merchant system.                                                      |
| description     | Item description.                                                                           |
| charge_items    | List of charge items and the total of the items amount is the actual amount for the payment |
| card_number     | Card number.                                                                                |
| expiry_year     | Card expiry year in 2 digits format "21".                                                   |
| expiry_month    | Card expiry month in 2 digits format "07".                                                  |
| cvv             | Card CVV.                                                                                   |
| save_card       | If the customer want to save this card for future payments.options are [0,1]                |

- [Sample of customerData array for pay via Fawry](#customerdata-sample-array-for-pay-via-fawry)
- [Sample of customerData array for pay via Credit Card](#customerdata-sample-array-for-pay-via-credit-card)

### [customerData] Sample array for pay via Fawry

```php
$customerData = [
	'customer_name'     => 'Esam Eisa',
	'customer_mobile'   => '01098950608',
	'customer_email'    => 'esameisa12345@gmail.com',
	'description'       => 'test package',
	'charge_items'      => collect([
		'itemId'        => '897fa8e81be26df25db592e81c31c',
		'description'   => 'asdasd',
		'price'         => '25.00',
		'quantity'      => '1',
	]),
];
```

### [customerData] Sample array for pay via Credit Card

```php
$customerData = [
	'customer_name'     => 'Esam Eisa',
	'customer_mobile'   => '01098950608',
	'customer_email'    => 'esameisa12345@gmail.com',
	'description'       => 'test package',
	'charge_items'      => collect([
		'itemId'        => '897fa8e81be26df25db592e81c31c',
		'description'   => 'asdasd',
		'price'         => '25.00',
		'quantity'      => '1',
	]),

	'card_number'   => '4005550000000001',
	'expiry_year'   => '21',
	'expiry_month'  => '05',
	'cvv'           => '123',
	'save_card'     => '0',
];
```

## Testing

For development mode, to run test cases: `vendor/bin/phpunit packages/esameisa/cowpay/tests`

## Official cowpay website

Website: [cowpay.me](https://cowpay.me/).

## License

The package licensed under the [MIT license](https://opensource.org/licenses/MIT).
