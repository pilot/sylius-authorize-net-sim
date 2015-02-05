<?php

namespace S40\Bundle\PayumBundle\Payum\AuthorizeNet\Sim;

// this is a fix of crappy auto loading in authorize.net lib.
class_exists('AuthorizeNetException', true);

class Api extends \AuthorizeNetSIM
{
    protected $sandbox = true;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getLoginId()
    {
        return $this->options['login_id'];
    }

    public function getTransactionLKey()
    {
        return $this->options['transaction_key'];
    }

    public function setSandbox($sandbox)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * @return string
     */
    public function getOnsiteUrl()
    {
        return $this->sandbox ?
            'https://test.authorize.net/gateway/transact.dll' :
            'https://secure.authorize.net/gateway/transact.dll'
        ;
    }

    /**
     * @param array $params
     * @return array
     */
    public function prepareOnsitePayment(array $params)
    {
        $fpSequence = rand(1, 1000);
        $time = time();
        $fpHash = \AuthorizeNetSIM_Form::getFingerprint(
            $this->getLoginId(),
            $this->getTransactionLKey(),
            $params['x_amount'],
            $fpSequence,
            $time
        );

        $supportedParams = array(
            'x_login' => $this->getLoginId(),
            'x_amount' => null,
            'x_description' => null,
            'x_invoice_num' => null,
            'x_fp_sequence' => $fpSequence,
            'x_fp_timestamp' => $time,
            'x_fp_hash' => $fpHash,
            'x_test_request' => $this->sandbox,
            'x_show_form' => 'PAYMENT_FORM',
            'x_relay_response' => true,
            'x_relay_always' => true,
            'x_relay_url' => null,
            'x_po_num' => null,
            'x_currency_code' => null,
        );

        $params = array_filter(array_replace(
            $supportedParams,
            array_intersect_key($params, $supportedParams)
        ));

        return $params;
    }
}
