<?php

namespace S40\Bundle\PayumBundle\Payum\AuthorizeNet\Sim\Action;

use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Reply\HttpPostRedirect;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use S40\Bundle\PayumBundle\Payum\AuthorizeNet\Sim\Api;

class CaptureOnsiteAction extends PaymentAwareAction implements ApiAwareInterface
{
    /**
    * @var Request
    */
    protected $httpRequest;

    /**
     * @var AuthorizeNetAIM
     */
    protected $api;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Api) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }

    /**
    * @param Request $request
    */
    public function setRequest(Request $request = null)
    {
        $this->httpRequest = $request;
    }

    /**
     * {@inheritDoc}
     *
     * @param Capture $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $payment = $request->getFirstModel();
        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (null != $model['x_response_code']) {
            return;
        }

        $model['x_relay_url'] = $this->httpRequest->getSchemeAndHttpHost().'/payment/notify/unsafe/authorize_sim';
        $model['x_po_num'] = $payment->getId();
        $this->session->set('after_url', $request->getToken()->getAfterUrl());

        $httpRequest = new GetHttpRequest;
        $this->payment->execute($httpRequest);

        //we are back from Authorize.Net site so we have to just update model.
        if (isset($httpRequest->query['x_response_code'])) {
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
}
