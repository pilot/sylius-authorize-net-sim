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
use Sylius\Component\Payment\Model\CreditCard;
use Omnipay\Common\CreditCard as OmniCreditCard;

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
     * {@inheritdoc}
     */
    public function execute($request)
    {
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $payment = $request->getModel();
        /** @var OrderInterface $order */
        $order = $payment->getOrder();
        $details = $payment->getDetails();

        if ($card = $this->httpRequest->request->get('payum_credit_card')) {
            // set credit card data
            // $cardData = new CreditCard();
            // $cardData
            //     ->setToken($card['_token'])
            //     ->setCardholderName($card['holder'])
            //     ->setNumber($card['number'])
            //     ->setSecurityCode($card['securityCode'])
            //     ->setExpiryMonth($card['expireAt']['month'])
            //     ->setExpiryYear($card['expireAt']['year'])
            // ;

            $cardData = new OmniCreditCard();
            $cardData
                ->setBillingName($card['holder'])
                ->setNumber($card['number'])
                ->setCvv($card['securityCode'])
                ->setExpiryMonth($card['expireAt']['month'])
                ->setExpiryYear($card['expireAt']['year'])
            ;

            $details['card'] = $cardData;
            // $details['cardReference'] = $cardData->getToken();
            $details['currency'] = 'GBR';
        }

        $details['amount'] = number_format($order->getTotal() / 100, 2);
        $details['returnUrl'] = $this->tokenFactory->createNotifyToken(
            $request->getToken()->getPaymentName(),
            $payment
        )->getTargetUrl();

        $payment->setDetails($details);

        $this->composeDetails($payment, $request->getToken());

        $details = ArrayObject::ensureArrayObject($payment->getDetails());

        try {
            $request->setModel($details);
            $this->payment->execute($request);

            $payment->setDetails($details);
            $request->setModel($payment);
        } catch (\Exception $e) {
            $payment->setDetails($details);
            $request->setModel($payment);

            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function composeDetails(PaymentInterface $payment, TokenInterface $token)
    {
        if ($payment->getDetails()) {
            return;
        }

        $order = $payment->getOrder();
        $details = $payment->getDetails();

        if (empty($details)) {
            $details['amount'] = number_format($order->getTotal() / 100, 2);
        }

        $details['returnUrl'] = $this->tokenFactory->createNotifyToken(
            $token->getPaymentName(),
            $payment
        )->getTargetUrl();

        $payment->setDetails($details);
    }
}
