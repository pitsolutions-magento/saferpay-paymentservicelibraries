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

namespace Saferpay\PaymentService\Alias;

use Saferpay\PaymentService\AliasAdapterInterface;
use Saferpay\PaymentService\BuildContainer;
use Saferpay\PaymentService\Constants;

/**
 * Class AliasAdapter
 *
 * @package Saferpay\PaymentService\Alias
 */
class AliasAdapter extends BuildContainer implements AliasAdapterInterface
{
    /**
     * Function to build Alias Insert body Data for Secure Card Data API
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAliasInsertData($bodyData)
    {
        $insertData = [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'RegisterAlias' => $this->getRegisterAlias(),
            'Type' => 'CARD',
            'ReturnUrls' => $this->getReturnUrlContainer($bodyData),
        ];
        if (isset($bodyData['terminal_id'])) {
             $insertData['Check'] = [
                        'Type' => Constants::API_ALIAS_AUTHENTICATION_ONLINE,
                        'TerminalId' => $bodyData['terminal_id']
                        ];
        }
        $styleContent = $this->getStylingContainer($bodyData);
        if (!empty($styleContent)) {
            $insertData['Styling'] = $styleContent;
        }
        if (isset($bodyData['lang_code']) && ($bodyData['lang_code'] != "")) {
            $insertData['LanguageCode'] = $bodyData['lang_code'];
        } else {
            $insertData['LanguageCode'] = Constants::API_DEFAULT_LANG_CODE;
        }
        if (isset($bodyData['saferpay_field_token'])) {
            $insertData['PaymentMeans']['SaferpayFields']['Token'] = $bodyData['saferpay_field_token'];
        }

        return $insertData;
    }

    /**
     * Function to build Alias Assert body Data for Secure Card Data API
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAliasAssertData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'Token' => $bodyData['Token']
        ];
    }

    /**
     * Function to build Alias Delete body Data for Secure Card Data API
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAliasDeleteData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'AliasId' => $bodyData['AliasId']
        ];
    }

    /**
     * Function to build Alias Update body Data for Secure Card Data API
     *
     * @param array $bodyData
     * @return array
     */
    public function buildAliasUpdateData($bodyData)
    {
        return [
            'RequestHeader' => $this->getRequestHeaderContainer($bodyData),
            'UpdateAlias' =>
                [
                    'Id' => $bodyData['AliasId'],
                    'Lifetime' => $bodyData['LifeTime']
                ],
            'UpdatePaymentMeans' =>
                [
                    'Card' =>
                        [
                            'ExpYear' => $bodyData['exp_year'],
                            'ExpMonth' => $bodyData['exp_month'],
                        ]
                ]
        ];
    }
}
