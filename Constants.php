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
 * Class Constants
 *
 * @package Saferpay\PaymentService
 */
class Constants
{
    /**
     * Version number of the interface specification.
     */
    const API_SPEC_VERSION = '1.17';

    /**
     * Header type
     */
    const API_ACCEPT_HEADER_TYPE = 'application/json';

    /**
     * Charset
     */
    const API_CHARSET = 'utf-8';

    /**
     * Timeout limit
     */
    const API_TIMEOUT = 30;

    /**
     * Default shop name
     */
    const API_DEFAULT_SHOP_NAME = 'Magento Shop';

    /**
     * Default language code
     */
    const API_DEFAULT_LANG_CODE = 'en';

    /**
     * Number of days for which card is stored within Saferpay
     */
    const API_PAYMENT_LIFE_TIME = 1000;

    /**
     * Id generator to be used by Saferpay
     */
    const API_ALIAS_ID_GENERATOR = 'RANDOM_UNIQUE';

    /**
     * Active status
     */
    const ACTIVE = 1;

    /**
     * Inactive status
     */
    const INACTIVE = 0;

    /**
     * Name of the account holder.
     */
    const CARD_HOLDER_NAME_NONE = 'NONE';

    /**
     * Masterpass wallet
     */
    const SAFERPAY_MASTERPASS_WALLET = 'MASTERPASS';

    /**
     * Applepay wallet
     */
    const SAFERPAY_APPLEPAY_WALLET = 'APPLEPAY';

    /**
     * Capture action
     */
    const API_ACTION_CAPTURE = 'capture';

    /**
     * Refund action
     */
    const API_ACTION_REFUND = 'refund';

    /**
     * PaymentPage interface
     */
    const PAYMENT_PAGE = 'PaymentPage';

    /**
     * True
     */
    const TRUE = true;

    /**
     * Type of check to perform.
     */
    const API_ALIAS_AUTHENTICATION_ONLINE = 'ONLINE_STRONG';

    /**
     * Request Verification Code
     */
    const REQUEST_VERIFICATION_CODE_MANDATORY = 'MANDATORY';
}
