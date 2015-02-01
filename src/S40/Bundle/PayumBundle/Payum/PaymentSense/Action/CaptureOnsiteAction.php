<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use S40\Bundle\PayumBundle\Payum\PaymentSense\Api;
use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\CaptureRequest;
use Payum\Core\Request\RedirectUrlInteractiveRequest;
use Symm\BitpayClient\Model\Invoice;

class CaptureOnsiteAction extends PaymentAwareAction implements ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    public function setApi($api)
    {
        if (false === $api instanceof Api) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }

    public function execute($request)
    {
        /** @var $request CaptureRequest */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $details = ArrayObject::ensureArrayObject($request->getModel());

        if (!isset($details['id'])) {
            $invoice = $this->api->createInvoice($details->toUnsafeArray());
            $details->replace($this->invoiceToArray($invoice));

            throw new RedirectUrlInteractiveRequest($invoice->getUrl());
        } else {
            $invoice = $this->api->getInvoice($details->toUnsafeArray());

            $details->replace($this->invoiceToArray($invoice));
            $request->setModel($details);
        }
    }

    protected function invoiceToArray(Invoice $invoice)
    {
        return [
            'id'       => $invoice->getId(),
            'status'   => $invoice->getStatus(),
            'url'      => $invoice->getUrl(),
            'btcPrice' => $invoice->getBtcPrice(),
            'price'    => $invoice->getPrice(),
            'currency' => $invoice->getCurrency(),
            'posData'  => $invoice->getPosData(),
        ];
    }

    public function supports($request)
    {
        if (false == $request instanceof CaptureRequest) {
            return false;
        }

        if (false == $request->getModel() instanceof \ArrayAccess) {
            return false;
        }

        return $this->isPaymentValid($request->getModel());
    }

    private function isPaymentValid($details)
    {
        if (!isset($details['price']) || empty($details['price'])) {
            return false;
        }

        if (!isset($details['currency']) || empty($details['currency'])) {
            return false;
        }

        return true;
    }
}
