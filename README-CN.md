# DeePay API PHP Library

这是DeePay API的PHP库。你需要Merchant ID和API key以通过认证，[马上注册](https://deepay.net)。

* [DeePay接口文档](https://github.com/DeePayNet/deepay-api) 
* [English Version](./README-CN.md)

## 安装

### 使用composer (推荐)

```bash
composer require deepay/deepay-php
```

### 手动下载

下载[安装包](https://github.com/DeePayNet/deepay-php/archive/master.zip)，并引入到你的项目。

```php
require_once('deepay-php-master/deepay.php');
```

## 快速开始

### 初始化
生成类`DeePay\DeePay`的实例，用于调用各接口对应的方法。

```php
use DeePay\DeePay;

$deepay = new DeePay('Merchant ID', 'API Key');
```

### 创建订单 

```php
$params = array(
  'out_trade_id' => 'E201809123',
  'price_amount' => 10.0001,
  'price_currency' => 'CNY',
  'notify_url' => 'http://example.com/notify',
  'callback_url' => 'http://example.com/',
  'title' => 'iPhone x',
  'attach' => '附加信息'
);

$order = $deepay->createOrder($params);

// $order是\DeePay\Order的实例
var_dump($order->toArray());
```

### 检出订单

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

### 查询订单

```php
$order = $deepay->queryOrder('20181121113652525198');
// or use out_trade_id
$order = $deepay->queryOrderByOutTradeId('E113652525198');

var_dump($order->toArray());
```

### 查询汇率

```
$rate = \DeePay\DeePay::getExchangeRate('ETH', 'CNY');
var_dump($rate);
```

### 支付通知

```php
$order = $_POST;
if ($deepay->checkSign($order)) {
    if ($order['status'] == 'confirmed') {
        // 根据状态处理订单
    }
    
    // 处理完后返回'ok'
    exit('ok');
} else {
    echo '非法请求';
}
```
