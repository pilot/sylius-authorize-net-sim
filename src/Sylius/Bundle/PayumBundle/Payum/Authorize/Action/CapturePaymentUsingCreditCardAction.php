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
class CapturePaymentUsingCreditCardAction extends AbstractCapturePaymentAction
{
    /**
     * @var Request
     */
    protected $httpRequest;

    /**
     * @param GenericTokenFactoryInterface $tokenFactory
     */
    public function __construct(GenericTokenFactoryInterface $tokenFactory)
    {
        $this->tokenFactory = $tokenFactory;
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
    */
    protected function composeDetails(PaymentInterface $payment, TokenInterface $token)
    {
        if ($payment->getDetails()) {
            return;
        }

        $order = $payment->getOrder();

        $payment->setDetails(array(
            'amount' => number_format($order->getTotal() / 100, 2),
            'currency' => $order->getCurrency(),
            'returnUrl' => $this->tokenFactory->createNotifyToken(
                $token->getPaymentName(),
                $payment
            )->getTargetUrl()
        ));
    }
}
