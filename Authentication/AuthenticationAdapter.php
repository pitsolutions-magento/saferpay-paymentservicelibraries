<?php
/**
 * Saferpay PaymentService
 *
 * NOTICE OF LICENSE
 *
 * Once you have purchased the software with PIT Solutions AG / Six Payment services AG
 * or one of its  authorised resellers and provided that you comply with the conditions of this contract,
 * PIT Solutions AG and Six Payment services AG grants you a non-exclusive license,
 * unlimited in time for the usage of the software in the manner of and for the purposes specified in License.txt
 * available in extension package, according to the subsequent regulations.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * @category Saferpay
 * @package Saferpay_PaymentService
 * @author PIT Solutions Pvt. Ltd.
 * @copyright Copyright (c) 2020 PIT Solutions AG. (www.pitsolutions.ch) and
 * Six Payment services AG ( https://www.six-payment-services.com/)
 * @license https://www.webshopextension.com/en/licence-agreement-saferpay
 *
 */

namespace Saferpay\PaymentService\Authentication;

use Saferpay\PaymentService\AuthenticationAdapterInterface;
use Saferpay\PaymentService\Constants;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Headers;

/**
 * Class AuthenticationAdapter
 *
 * @package Saferpay\PaymentService\Authentication
 */
class AuthenticationAdapter implements AuthenticationAdapterInterface
{
    /**
     * Function to generate Authorization header Data for Saferpay API
     *
     * @return array
     */
    public function generateAuthorizationheader()
    {
        return [
            'Accept' => Constants::API_ACCEPT_HEADER_TYPE,
            'Content-Type' => Constants::API_ACCEPT_HEADER_TYPE,
            'charset' => Constants::API_CHARSET
        ];
    }

    /**
     * Function to send Request to SaferPAy API
     *
     * @param array $headerData
     * @param array $bodyFormData
     * @param string $url
     * @param string $username
     * @param string $password
     * @return array
     */
    public function sendRequest($headerData, $bodyFormData, $url, $username, $password)
    {
        $result = [];
        $httpHeaders = new Headers();
        $httpHeaders->addHeaders($headerData);
        $httpRequest = new Request();
        $httpRequest->setHeaders($httpHeaders);
        $httpRequest->setUri($url);
        $httpRequest->setMethod(Request::METHOD_POST);
        $client = new Client();
        $options = [
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects' => 0,
            'timeout' => Constants::API_TIMEOUT
        ];
        $client->setOptions($options);
        $client->setAuth($username, $password, Client::AUTH_BASIC);
        $httpRequest->setContent(json_encode($bodyFormData));
        $response = $client->send($httpRequest);
        $result['status'] = $response->getStatusCode();
        $result['data'] = json_decode($response->getBody(), true);

        return $result;
    }
}
