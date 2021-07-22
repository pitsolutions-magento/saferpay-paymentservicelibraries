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
 * Interface RefundAdapterInterface
 *
 * @package Saferpay\PaymentService
 */
interface RefundAdapterInterface
{
    /**
     * Function to build Initialize API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundBodyData($bodyData);

    /**
     * Function to build Refund Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundCaptureData($bodyData);

    /**
     * Function to build Refund Cancel API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildRefundCancelData($bodyData);

    /**
     * Function to build Refund Assert API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAssertRefundData($bodyData);
}
