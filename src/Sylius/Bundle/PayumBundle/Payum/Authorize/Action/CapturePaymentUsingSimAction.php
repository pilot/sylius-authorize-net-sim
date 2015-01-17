<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\PayumBundle\Payum\Authorize\Action;

use Payum\Core\Exception\LogicException;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractCapturePaymentAction;
use Sylius\Component\Payment\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Alex Demchenko <pilo.uanic@gmail.com>
 */
class CapturePaymentUsingSimAction extends AbstractCapturePaymentAction
{
    /**
     * @var Request
     */
    protected $httpRequest;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->httpRequest = $request;
    }

    /**
    * {@inheritDoc}
    */
    public function execute($request)
    {
        $this->httpRequest->getSession()->set('payum_token', $request->getToken()->getHash());

        parent::execute($request);
    }

    /**
    * {@inheritDoc}
    */
    protected function composeDetails(PaymentInterface $payment, TokenInterface $token)
    {
        if ($payment->getDetails()) {
            return;
        }

        $order = $payment->getOrder();

        $payment->setDetails(array(
            'x_amount' => number_format($order->getTotal() / 100, 2),
            'x_currency_code' => $order->getCurrency(),
        ));
    }
}
