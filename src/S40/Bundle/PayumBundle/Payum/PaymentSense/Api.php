<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense;

use S40\Bundle\PayumBundle\Payum\PaymentSense\PaymentFormHelper;

class Api
{
    public $transactionResult = null;

    public $validateErrorMessage = '';

    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getMerchantId()
    {
        return $this->options['merchant_id'];
    }

    public function getPassword()
    {
        return $this->options['password'];
    }

    public function getPreSharedKey()
    {
        return $this->options['pre_shared_key'];
    }

    public function isSandbox()
    {
        return (boolean) $this->options['sandbox'];
    }

    /**
     * @return string
     */
    public function getOnsiteUrl()
    {
        return $this->isSandbox() ?
            'https://mms.paymentsensegateway.com/Pages/PublicPages/PaymentForm.aspx' :
            'https://mms.paymentsensegateway.com/Pages/PublicPages/PaymentForm.aspx'
        ;
    }

    /**
     * @param array $params
     * @return array
     */
    public function prepareOnsitePayment(array $params)
    {
        $transactionType = 'SALE';
        $transactionDateTime = date('Y-m-d H:i:s P');

        // This method MUST match the hash method set for the merchant in the MMS
        $hashMethod = 'SHA1';

        /* determines how the transaction result will be delivered back to this site:
         * "POST" - only use if this site has an SSL certificate. Best method to use if you do have an SSL
         * "SERVER" - best method with no SSL - don't use if this site requires to maintain
         *            cookie-based session to access its order object)
         * "SERVER_PULL" - only use if no SSL and site also requires cookie-based session to access
         *                 its order object
         */
        $resultDeliveryMethod = 'SERVER_PULL';

        // the URL on this system that the payment form will push the results to (only applicable for
        // ResultDeliveryMethod = "SERVER")
        $serverResultURL = '';

        // set this to true if you want the hosted payment form to display the transaction result
        // to the customer (only applicable for resultDeliveryMethod = "SERVER")
        if ($resultDeliveryMethod == 'SERVER') {
            $paymentFormDisplaysResult = PaymentFormHelper::boolToString(false);
        } else {
            $paymentFormDisplaysResult = '';
        }

        //Hosted Payment Form Settings
        $emailAddressEditable = PaymentFormHelper::boolToString(true);
        $phoneNumberEditable = PaymentFormHelper::boolToString(true);
        $cv2Mandatory = PaymentFormHelper::boolToString(true);
        $address1Mandatory = PaymentFormHelper::boolToString(true);
        $cityMandatory = PaymentFormHelper::boolToString(true);
        $postCodeMandatory = PaymentFormHelper::boolToString(true);
        $stateMandatory = PaymentFormHelper::boolToString(true);
        $countryMandatory = PaymentFormHelper::boolToString(true);

        //misc return values
        $echoCardType = PaymentFormHelper::boolToString(true); //set to true by default

        //Security Override Policys
        $avsOverridePolicy = '';
        $cv2OverridePolicy = '';
        $threeDSecureOverridePolicy = PaymentFormHelper::boolToString(false);

        // get the string to be hashed
        $stringToHash = PaymentFormHelper::generateStringToHash(
            $this->getMerchantId(),
            $this->getPassword(),
            $params['Amount'],
            $params['CurrencyCode'],
            $echoCardType,
            $params['OrderID'],
            $transactionType,
            $transactionDateTime,
            $params['CallbackURL'],
            $params['OrderDescription'],
            $params['CustomerName'],
            $params['Address1'],
            $params['Address2'],
            $params['Address3'],
            $params['Address4'],
            $params['City'],
            $params['State'],
            $params['PostCode'],
            $params['CountryCode'],
            $params['EmailAddress'],
            $params['PhoneNumber'],
            $emailAddressEditable,
            $phoneNumberEditable,
            $cv2Mandatory,
            $address1Mandatory,
            $cityMandatory,
            $postCodeMandatory,
            $stateMandatory,
            $countryMandatory,
            $resultDeliveryMethod,
            $serverResultURL,
            $paymentFormDisplaysResult,
            $this->getPreSharedKey(),
            $hashMethod
        );

        // payment security hash
        $hashDigest = PaymentFormHelper::calculateHashDigest($stringToHash, $this->getPreSharedKey(), $hashMethod);

        $supportedParams = array(
            'HashDigest' => $hashDigest,
            'MerchantID' => $this->getMerchantId(),
            'Amount' => '',
            'CurrencyCode' => '',
            'EchoCardType' => $echoCardType,
            'OrderID' => '',
            'TransactionType' => $transactionType,
            'TransactionDateTime' => $transactionDateTime,
            'CallbackURL' => '',
            'OrderDescription' => '',
            'CustomerName' => '',
            'Address1' => '',
            'Address2' => '',
            'Address3' => '',
            'Address4' => '',
            'City' => '',
            'State' => '',
            'PostCode' => '',
            'CountryCode' => '',
            'EmailAddress' => '',
            'PhoneNumber' => '',
            'EmailAddressEditable' => $emailAddressEditable,
            'PhoneNumberEditable' => $phoneNumberEditable,
            'CV2Mandatory' => $cv2Mandatory,
            'Address1Mandatory' => $address1Mandatory,
            'CityMandatory' => $cityMandatory,
            'PostCodeMandatory' => $postCodeMandatory,
            'StateMandatory' => $stateMandatory,
            'CountryMandatory' => $countryMandatory,
            'ResultDeliveryMethod' => $resultDeliveryMethod,
            'ServerResultURL' => '',
            'PaymentFormDisplaysResult' => '',
            'ServerResultURLCookieVariables' => '',
            'ServerResultURLFormVariables' => '',
            'ServerResultURLQueryStringVariables' => '',
        );

        $params = array_replace(
            $supportedParams,
            array_intersect_key($params, $supportedParams)
        );

        return $params;
    }

    public function getPaymentFormResultHandler()
    {
        return 'https://mms.paymentsensegateway.com/Pages/PublicPages/PaymentFormResultHandler.ashx';
    }

    public function getResultValidationSuccessful($query)
    {
        return PaymentFormHelper::validateTransactionResult_SERVER_PULL(
            $this->getMerchantId(),
            $this->getPassword(),
            $this->getPreSharedKey(),
            'SHA1',
            $query,
            $this->getPaymentFormResultHandler(),
            $this->transactionResult,
            $this->validateErrorMessage
        );
    }
}
