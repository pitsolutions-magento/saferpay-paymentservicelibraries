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

namespace Saferpay\PaymentService\Refund;

use Saferpay\PaymentService\BuildContainer;
use Saferpay\PaymentService\RefundAdapterInterface;
use Saferpay\PaymentService\Constants;

/**
 * Class RefundAdapter
 *
 * @package Saferpay\PaymentService\Refund
 */
class RefundAdapter extends BuildContainer implements RefundAdapterInterface
{
    /**
     * Function to build Initialize API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundBodyData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'Refund' => $this->gePaymentContainer($bodyData),
            'CaptureReference' =>
                [
                    'CaptureId' => $bodyData['capture_id']
                ],
            'PendingNotification' => $this->getPendingNotification($bodyData, Constants::API_ACTION_REFUND)
        ];
    }

    /**
     * Function to build Refund Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundCaptureData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' => $this->getTransactionReferenceContainer($bodyData),
            'PendingNotification' => $this->getPendingNotification($bodyData, Constants::API_ACTION_REFUND)
        ];
    }

    /**
     * Function to build Refund Cancel API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundCancelData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' => $this->getTransactionReferenceContainer($bodyData)
        ];
    }

    /**
     * Function to build Refund Assert API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAssertRefundData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'TransactionReference' =>
                [
                    'TransactionId' => $bodyData['refund_reference']
                ]
        ];
    }
}
