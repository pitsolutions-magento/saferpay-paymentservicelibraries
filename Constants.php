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
 * available in extension package, according to the subsequent regulations
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * @category Saferpay
 * @package Saferpay_PaymentService
 * @author PIT Solutions Pvt. Ltd.
 * @copyright Copyright (c) 2020 PIT Solutions AG. (www.pitsolutions.ch) and Six Payment services AG ( https://www.six-payment-services.com/)
 * @license https://www.webshopextension.com/en/licence-agreement-saferpay
 *
 */

namespace Saferpay\PaymentService;

interface Constants
{
    /**
     * API constants
     */
    const API_SPEC_VERSION = '1.16';

    const API_ACCEPT_HEADER_TYPE = 'application/json';

    const API_CHARSET = 'utf-8';

    const API_TIMEOUT = 30;

    const API_RETRY_INDICATOR = 0;

    const API_ALIAS_INSERT = 'api/Payment/v1/Alias/Insert';

    const API_ALIAS_GET_DETAILS = 'api/Payment/v1/Alias/AssertInsert';

    const API_DEFAULT_SHOP_NAME = 'Magento Shop';

    const API_DEFAULT_LANG_CODE = 'en';

    const API_PAYMENT_LIFE_TIME = 1000;

    const API_ALIAS_ID_GENERATOR = 'RANDOM_UNIQUE';

    const ACTIVE = 1;

    const INACTIVE = 0;

    const CARD_HOLDER_NAME_NONE = 'NONE';

    const SAFERPAY_MASTERPASS_WALLET = 'MASTERPASS';

    const SAFERPAY_APPLEPAY_WALLET = 'APPLEPAY';

    const API_ACTION_CAPTURE = 'capture';

    const API_ACTION_REFUND = 'refund';

    const PAYMENT_PAGE = 'PaymentPage';

    const TRANSACTION_PAGE = 'Iframe';

    const TRUE = true;

    const FORCE = 'FORCE';

    const API_ALIAS_AUTHENTICATION_ONLINE = 'ONLINE_STRONG';
}
