# DeePay API PHP Library

This is a PHP library fo DeePay API. Merchant ID and API key are needed for authenication. [Sign up here](https://deepay.net). 

* [DeePay API Document](https://github.com/DeePayNet/deepay-api) 
* [中文版](./README-CN.md)

## Install

### With composer (Recommended)

Install the package via [Composer](https://getcomposer.org):

```bash
composer require deepay/deepay-php
```

### Manual download

Download the [package](https://github.com/DeePayNet/deepay-php/archive/master.zip) and include it in your code.

```php
require_once('deepay-php-master/deepay.php');
```

## Getting Started

### Initialize
Generate an instance of `DeePay\DeePay`, which will be used to call the API.

```php
use DeePay\DeePay;

$deepay = new DeePay('Merchant ID', 'Api Key');
```

### Create Order


```php

$params = array(
  'out_trade_id' => 'E201809123',
  'price_amount' => 10.0001,
  'price_currency' => 'CNY',
  'notify_url' => 'http://example.com/notify',
  'callback_url' => 'http://example.com/',
  'title' => 'iPhone X',
  'attach' => 'additional info'
);

$order = $deepay->createOrder($params);

// $order is an instance of \DeePay\Order
var_dump($order->toArray());
```

### Checkout Order


```php
$order = $deepay->checkoutOrder(array(
  'transaction_id' => '20181121113652525198',
  // or use out_trade_id
  // 'out_trade_id' => 'E52525198',
  'pay_currency' => 'BTC',
  'email' => 'info@example.com',
));

var_dump($order->toArray());
```

### Query Order

```php
$order = $deepay->checkoutOrder('20181121113652525198');
// or use out_trade_id
$order = $deepay->checkoutOrder('E113652525198');

var_dump($order->toArray());
```

### Get Exchange Rate

```
$rate = \DeePay\DeePay::getExchangeRate('ETH', 'CNY');
var_dump($rate);
```


### Payment Notification


```php
$order = $_POST;
if ($deepay->checkSign($order) {
	if ($order['status'] == 'confirmed') {
		// process the order according to status
	}
	
	// echo 'ok' when you finish the job
	exit('ok');
} else {
	echo 'Notifycation is invalid';
}
```
