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
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @var Session
     */
    protected $session;

    /**
     * @param GenericTokenFactoryInterface $tokenFactory
     */
    public function __construct(GenericTokenFactoryInterface $tokenFactory, Session $session)
    {
        $this->tokenFactory = $tokenFactory;
        $this->session = $session;
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
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $model['CallbackURL'] = $this->tokenFactory->createNotifyToken(
            $request->getToken()->getPaymentName(),
            $request->getFirstModel()
        )->getTargetUrl();
        $model['AfterUrl'] = $request->getToken()->getAfterUrl();
        $this->session->set('afterUrl', $request->getToken()->getAfterUrl());

        if (null != $model['StatusCode']) {
            return;
        }

        $httpRequest = new GetHttpRequest;
        $this->payment->execute($httpRequest);

        //we are back from be2bill site so we have to just update model.
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
        //dump($request); die;
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
