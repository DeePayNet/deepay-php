<?php

namespace DeePay;

class DeePay
{
    public function __construct($merchant_id, $key)
    {
        $this->merchant_id = $merchant_id;
        $this->key = $key;
    }

    public function createOrder($params)
    {
        $order = Client::request('/order/create', 'POST', $this->sign($params));
        return new Order($order);
    }

    public function queryOrder($id)
    {
        $order = Client::request('/order/query', 'POST', $this->sign(['transaction_id' => $id]));
        return new Order($order);
    }

    public function queryOrderByOutTradeId($id)
    {
        $order = Client::request('/order/query', 'POST', $this->sign(['out_trade_id' => $id]));
        return new Order($order);
    }

    public function checkoutOrder($params)
    {
        $order = Client::request('/order/checkout', 'POST', $this->sign($params));
        return new Order($order);
    }

    public static function getExchangeRate($from, $to)
    {
        return Client::request("/rate/{$from}/{$to}", 'GET');
    }

    public function checkSign($params, $sign = '')
    {
        $sign = $sign ?: (isset($params['sign']) ? $params['sign'] : '');
        $params = $this->sign($params);
        return $params['sign'] == $sign;
    }

    protected function sign($params)
    {
        $params['merchant_id'] = isset($params['merchant_id']) ? $params['merchant_id'] : $this->merchant_id;

        unset($params['sign']);
        ksort($params);
        $string = '';
        foreach ($params as $k => $vo) {
            if ($vo !== '') {
                $string .= $k . '=' . $vo . '&';
            } 
        }
        $string = rtrim($string, '&');
        $string = $string . '&key=' . $this->key;
        $params['sign'] = strtoupper(md5($string));
        return $params;
    }
}