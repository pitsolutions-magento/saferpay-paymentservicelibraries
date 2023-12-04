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
 * @copyright Copyright (c) PIT Solutions AG. (www.pitsolutions.ch) and
 * Six Payment services AG ( https://www.six-payment-services.com/)
 * @license https://www.webshopextension.com/en/licence-agreement-saferpay
 *
 */

namespace Saferpay\PaymentService\Payment;

use Saferpay\PaymentService\PaymentAdapterInterface;
use Saferpay\PaymentService\Constants;
use Saferpay\PaymentService\BuildContainer;

/**
 * Class PaymentAdapter
 *
 * @package Saferpay\PaymentService\Payment
 */
class PaymentAdapter extends BuildContainer implements PaymentAdapterInterface
{
    /**
     * Function to build Initialize API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildInitializeBodyData($bodyData)
    {
        $initializeData = [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TerminalId' => $bodyData['terminal_id'],
            'Payment' => $this->gePaymentContainer($bodyData),
            'ReturnUrl' => $this->getReturnUrlContainer($bodyData),
        ];
        $payerData =$this->getPayerContainer($bodyData);
        if (!empty($payerData)) {
            $initializeData['Payer'] = $payerData;
        }
        if (isset($bodyData['payment_method'])) {
            if (($bodyData['payment_method'] == Constants::SAFERPAY_MASTERPASS_WALLET) ||
                ($bodyData['payment_method'] == Constants::SAFERPAY_APPLEPAY_WALLET) ||
                ($bodyData['payment_method'] == Constants::SAFERPAY_GOOGLEPAY_WALLET)) {
                $initializeData['Wallets'] = [$bodyData['payment_method']];
            } else {
                $initializeData['PaymentMethods'] = [$bodyData['payment_method']];
            }
        }
        if (isset($bodyData['payment_brands']) && !empty($bodyData['payment_brands'])) {
            $initializeData['PaymentMethods'] = $bodyData['payment_brands'];
        }
        if (isset($bodyData['aliasId']) && !empty($bodyData['aliasId'])) {
            $initializeData['PaymentMeans']['Alias']['Id'] = $bodyData['aliasId'];
            if (isset($bodyData['aliasCvcCheck']) &&
                $bodyData['aliasCvcCheck'] == Constants::ACTIVE) {
                $initializeData['CardForm']['VerificationCode'] = Constants::REQUEST_VERIFICATION_CODE_MANDATORY;
            }
        }
        if (isset($bodyData['hosted_fields_token']) && !empty($bodyData['hosted_fields_token'])) {
            $initializeData['PaymentMeans']['SaferpayFields']['Token'] = $bodyData['hosted_fields_token'];
        }
        if (isset($bodyData['config_set']) && !empty($bodyData['config_set'])) {
            $initializeData['ConfigSet'] = $bodyData['config_set'];
        }
        $styleContent = $this->getStylingContainer($bodyData);
        if (!empty($styleContent)) {
            $initializeData['Styling'] = $styleContent;
        }
        if (isset($bodyData['card_holdername_display']) &&
            $bodyData['card_holdername_display'] == Constants::INACTIVE) {
            $initializeData['CardForm'] = [
                'HolderName' => Constants::CARD_HOLDER_NAME_NONE
            ];
        }
        if ($bodyData['AuthorisationMethod'] == Constants::PAYMENT_PAGE) {
            if (isset($bodyData['RegisterAlias']) && $bodyData['RegisterAlias'] == Constants::ACTIVE) {
                $initializeData['RegisterAlias'] = $this->getRegisterAlias();
            }
            $initializeData['Notification'] = $this->getNotificationContainer($bodyData);
            if (isset($bodyData['issuerId']) && !empty($bodyData['issuerId'])) {
                $initializeData['PaymentMethodsOptions']['Ideal']['IssuerId']= $bodyData['issuerId'];
            }
//            if (isset($bodyData['Attachment']) && !empty($bodyData['Attachment'])) {
//                $initializeData['PaymentMethodsOptions']['Klarna']['Attachment']= $bodyData['Attachment'];
//            }
        } else {
            $initializeData['RedirectNotifyUrls'] = $this->getRedirectNotifyContainer($bodyData);
            if (isset($bodyData['customer_email'])) {
                $initializeData['Notification']['PayerDccReceiptEmail'] = $bodyData['customer_email'];
            }
        }
        if (isset($bodyData['order']) && !empty($bodyData['order'])) {
            $initializeData['Order']['Items'] = $bodyData['order'];
        }
        if (isset($bodyData['RiskFactors'])) {
            $initializeData['RiskFactors'] = $bodyData['RiskFactors'];
        }

        return $initializeData;
    }

    /**
     * Function to build Authorize/Assert API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAuthorizeBodyData($bodyData)
    {
        $authorizeData = [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'Token' => $bodyData['Token']
        ];

        if (isset($bodyData['RegisterAlias']) && $bodyData['RegisterAlias'] == Constants::ACTIVE) {
            $authorizeData['RegisterAlias'] = $this->getRegisterAlias();
        }

        return $authorizeData;
    }

    /**
     * Function to build Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildCaptureBodyData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' => $this->getTransactionReferenceContainer($bodyData),
            'PendingNotification' => $this->getPendingNotification($bodyData, Constants::API_ACTION_CAPTURE)
        ];
    }

    /**
     * Function to build Cancel API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildCancelBodyData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' => $this->getTransactionReferenceContainer($bodyData)
        ];
    }

    /**
     * Function to build Multipart Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildMultipartCaptureData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' => $this->getTransactionReferenceContainer($bodyData),
            'Amount' => $this->getAmountContainer($bodyData),
            'Type' => $bodyData['capture_type'],
            'OrderPartId' => $bodyData['order_part_id']
        ];
    }

    /**
     * Function to build Assert Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAssertCaptureData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'CaptureReference' =>
                [
                    'CaptureId' => $bodyData['capture_reference']
                ]
        ];
    }

    /**
     * Function to build Authorize Referenced API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAuthorizeReferencedBodyData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TerminalId' => $bodyData['terminal_id'],
            'Payment' => $this->gePaymentContainer($bodyData),
            'TransactionReference' =>
                [
                    'TransactionId' => $bodyData['transaction_id']
                ]
        ];
    }

    /**
     * Serialize data into string
     *
     * @param string|int|float|bool|array|null $data
     * @return string|bool
     */
    public function serializeData($data)
    {
        return serialize($data);
    }

    /**
     * Unserialize the given string
     *
     * @param string $data
     * @return string|int|float|bool|array|null
     */
    public function unserializeData($data)
    {
        return unserialize($data);
    }

    /**
     * Function to build AuthorizeDirect API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAuthorizeDirectBodyData($bodyData)
    {
        $authorizeDirectData = [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TerminalId' => $bodyData['terminal_id'],
            'Payment' => $this->gePaymentContainer($bodyData)
        ];
        $payerData =$this->getPayerContainer($bodyData);
        if (!empty($payerData)) {
            $authorizeDirectData['Payer'] = $payerData;
        }
        if (isset($bodyData['aliasId']) && !empty($bodyData['aliasId'])) {
            $authorizeDirectData['PaymentMeans']['Alias']['Id'] = $bodyData['aliasId'];
        }

        return $authorizeDirectData;
    }
}
