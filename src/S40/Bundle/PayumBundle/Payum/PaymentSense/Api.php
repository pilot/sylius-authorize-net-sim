<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense;

class Api
{
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

    public function isSandbox()
    {
        return (boolean) $this->options['sandbox'];
    }
}
