<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use S40\Bundle\PayumBundle\Payum\PaymentSense\Api;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Reply\HttpPostRedirect;

/**
 * @author Alex Demchenko <pilo.uanic@gmail.com>
 */
class CaptureOnsiteAction extends PaymentAwareAction implements ApiAwareInterface
{
    /**
     * @var GenericTokenFactoryInterface
     */
    protected $tokenFactory;

    /**
     * @param GenericTokenFactoryInterface $tokenFactory
     */
    public function __construct(GenericTokenFactoryInterface $tokenFactory)
    {
        $this->tokenFactory = $tokenFactory;
    }

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

    /**
     * {@inheritDoc}
     *
     * @param Capture $request
     */
    public function execute($request)
    {die('ku');
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());
        $token = $request->getToken();
        $payment = $request->getFirstModel();
        // $order = $payment->getOrder();
        // $details = $payment->getDetails();
        //
        // if (!isset($details['Amount'])) {
        //     $details = array();
        //     $details['Amount'] = $order->getTotal();
        //     $details['OrderID'] = $order->getNumber();
        //     $details['OrderDescription'] = '';
        //     $details['EmailAddress'] = $order->getEmail();
        //     $details['CustomerName'] = '';
        //     $details['Address1'] = '';
        //     $details['Address2'] = '';
        //     $details['Address3'] = '';
        //     $details['Address4'] = '';
        //     $details['City'] = '';
        //     $details['State'] = '';
        //     $details['PostCode'] = '';
        //     $details['CountryCode'] = '';
        //     $details['CurrencyCode'] = $this->getNumberCurrencyCode($payment->getOrder()->getCurrency());
        //     $details['PhoneNumber'] = '';
        //
        //     $payment->setDetails($details);
        // }

        $model['CallbackURL'] = $this->tokenFactory->createNotifyToken(
            $token->getPaymentName(),
            $payment
        )->getTargetUrl();
        $model['AfterUrl'] = $token->getAfterUrl();

        if (null != $model['StatusCode']) {
            return;
        }

        $httpRequest = new GetHttpRequest;
        $this->payment->execute($httpRequest);

        //we are back from PaymentSense site so we have to just update model.
        if (isset($httpRequest->query['StatusCode'])) {
            $model->replace($httpRequest->query);
        } else {
            throw new HttpPostRedirect(
                $this->api->getOnsiteUrl(),
                $this->api->prepareOnsitePayment($model->toUnsafeArray())
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }

    protected function getNumberCurrencyCode($currency)
    {
        $currencies = array(
            'EUR' => 978,
            'USD' => 840,
            'GBP' => 826,
        );

        return $currencies[$currency];
    }
}
