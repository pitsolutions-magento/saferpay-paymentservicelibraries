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

namespace Saferpay\PaymentService;

/**
 * Class BuildContainer
 *
 * @package Saferpay\PaymentService
 */
class BuildContainer
{
    /**
     * Function to get Request Header Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getRequestHeaderContainer($bodyData)
    {
        if (isset($bodyData['shop_info'])) {
            $shopInfo = $bodyData['shop_info'];
        } else {
            $shopInfo = Constants::API_DEFAULT_SHOP_NAME;
        }

        return [
            'SpecVersion' => Constants::API_SPEC_VERSION,
            'CustomerId' => $bodyData['saferpay_customer_id'],
            'RequestId' => $bodyData['request_id'],
            'RetryIndicator' => 0,
            'ClientInfo' =>
                [
                    'ShopInfo' => $shopInfo
                ]
        ];
    }

    /**
     * Function to get Payment Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function gePaymentContainer($bodyData)
    {
        $bodyFormData = [
            'Amount' => $this->getAmountContainer($bodyData),
            'OrderId' => $bodyData['order_id'],
            'Description' => $bodyData['description']
        ];
        if (isset($bodyData['pre_authorisation'])) {
            $preAuth = ($bodyData['pre_authorisation'] == 1) ? true : false;
            $bodyFormData['Options'] = [
                'PreAuth' => $preAuth
            ];
        }

        return $bodyFormData;
    }

    /**
     * Function to get Amount Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getAmountContainer($bodyData)
    {
        return [
            'Value' => $bodyData['amount'],
            "CurrencyCode" => $bodyData['currency_code']
        ];
    }

    /**
     * Function to get Alias Container for API
     *
     * @return array
     */
    public function getRegisterAlias()
    {
        return [
            'IdGenerator' => Constants::API_ALIAS_ID_GENERATOR,
            'Lifetime' => Constants::API_PAYMENT_LIFE_TIME
        ];
    }

    /**
     * Function to get Payer Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getPayerContainer($bodyData)
    {
        $bodyFormData = [];
        if (isset($bodyData['lang_code'])) {
            $bodyFormData['LanguageCode'] = $bodyData['lang_code'];
        } else {
            $bodyFormData['LanguageCode'] = Constants::API_DEFAULT_LANG_CODE;
        }
        if (isset($bodyData['address']) && !empty($bodyData['address'])) {
            $bodyFormData = $bodyData['address'];
        }

        return $bodyFormData;
    }

    /**
     * Function to get Notification Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getNotificationContainer($bodyData)
    {
        $bodyFormData = [];
        $bodyFormData['NotifyUrl'] = $bodyData['notify_url'];
        if (isset($bodyData['merchant_email']) && !empty($bodyData['merchant_email'])) {
            $bodyFormData['MerchantEmails'] = [$bodyData['merchant_email']];
        }
        if (isset($bodyData['send_email']) && $bodyData['send_email'] == Constants::ACTIVE &&
            isset($bodyData['customer_email'])) {
            $bodyFormData['PayerEmail'] = $bodyData['customer_email'];
        }

        return $bodyFormData;
    }

    /**
     * Function to get ReturnUrl Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getReturnUrlContainer($bodyData)
    {
        return [
            'Success' => $bodyData['success_url'],
            'Fail' => $bodyData['fail_url'],
            'Abort' => $bodyData['abort_url']
        ];
    }

    /**
     * Function to get Styling Container for API
     *
     * @param array $bodyData
     * @return array
     */
    public function getStylingContainer($bodyData)
    {
        $bodyFormData = [];
        if (isset($bodyData['css_url']) && !empty($bodyData['css_url'])) {
            $bodyFormData = [
                'CssUrl' => $bodyData['css_url'],
                'ContentSecurityEnabled' => Constants::TRUE
            ];
        }
        if (isset($bodyData['theme']) && !empty($bodyData['theme'])) {
            $bodyFormData['Theme'] = $bodyData['theme'];
        }

        return $bodyFormData;
    }

    /**
     * Function to get Transaction Reference Container for API
     *
     * @param array $bodyData
     * @return array|void
     */
    public function getTransactionReferenceContainer($bodyData)
    {
        if (isset($bodyData['transaction_id'])) {
            return [
                'TransactionId' => $bodyData['transaction_id']
            ];
        }
    }

    /**
     * Function to get Pending Notification Container for API
     *
     * @param array $bodyData
     * @param string $process
     * @return array|void
     */
    public function getPendingNotification($bodyData, $process)
    {
        if (isset($bodyData['pending_url']) && !empty($bodyData['pending_url']) && isset($bodyData['identifier']) &&
            !empty($bodyData['identifier'])) {
            return [
                'NotifyUrl' => $bodyData['pending_url'] . '?process=' .
                               $process . '&referenceId=' .
                               $bodyData['identifier']
            ];
        }
    }
}
