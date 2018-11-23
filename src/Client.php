<?php

namespace DeePay;

class Client 
{
    const USER_AGENT = 'DeePay PHP Library';
    // const GATEWAY = 'https://deepay.net';
    const GATEWAY = 'http://cryptopay.io';

    public static function request($url, $method = 'POST', $params = array())
    {
        $url       = self::GATEWAY . $url;
        $headers   = array();
        $curl      = curl_init();

        $curl_options = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $url,
            CURLOPT_USERAGENT      => self::USER_AGENT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        );

        if ($method == 'POST') {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            array_merge($curl_options, array(CURLOPT_POST => 1));
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        curl_setopt_array($curl, $curl_options);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $raw_response       = curl_exec($curl);
        $decoded_response   = json_decode($raw_response, true);
        $response           = $decoded_response ? $decoded_response : $raw_response;
        $http_status        = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($http_status === 200) {
            return $response;
        } else {
            $reason = $response;

            if (is_array($response)) {
                $error = '';
                $message = '';

                if (isset($response['error']))
                    $error = $response['error'];

                if (isset($response['message']))
                    $message = $response['message'];

                $reason = "{$error} {$message}";
            }

            throw new DeePayException($reason, $http_status);
        }
    }
}