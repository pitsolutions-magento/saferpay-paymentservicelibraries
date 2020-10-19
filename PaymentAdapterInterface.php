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
 * Interface PaymentAdapterInterface
 *
 * @package Saferpay\PaymentService
 */
interface PaymentAdapterInterface
{
    /**
     * Function to build Initialize API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildInitializeBodyData($bodyData);

    /**
     * Function to build Authorize/Assert API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAuthorizeBodyData($bodyData);

    /**
     * Function to build Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildCaptureBodyData($bodyData);

    /**
     * Function to build Cancel API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildCancelBodyData($bodyData);

    /**
     * Function to build Multipart Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildMultipartCaptureData($bodyData);

    /**
     * Function to build Assert Capture API body Data
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAssertCaptureData($bodyData);
}
