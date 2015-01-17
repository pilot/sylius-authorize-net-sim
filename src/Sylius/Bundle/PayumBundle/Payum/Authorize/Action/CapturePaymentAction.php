<?php

namespace S40\PayumBundle\Payum\Authorize\Action;

use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractCapturePaymentAction;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Sylius\Component\Payment\Model\CreditCard;

class CapturePaymentAction extends AbstractCapturePaymentAction
{
    /**
    * @var GenericTokenFactoryInterface
    */
    protected $tokenFactory;

    protected $requestStack;

    /**
    * @param GenericTokenFactoryInterface $tokenFactory
    */
    public function __construct(GenericTokenFactoryInterface $tokenFactory, RequestStack $requestStack)
    {
        $this->tokenFactory = $tokenFactory;
        $this->requestStack = $requestStack;
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


        var_dump($payment->getDetails()); die('ku');
    }

    /**
    * {@inheritdoc}
    */
    public function execute($request)
    {
        /** @var $request SecuredCaptureRequest */
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $payment = $request->getModel();
        /** @var OrderInterface $order */
        $order = $payment->getOrder();
        $details = $payment->getDetails();

        if ($card = $this->getRequest()->request->get('payum_credit_card')) {
            // set card data
            $cardData = new CreditCard();
            $cardData
                ->setToken($card['_token'])
                ->setCardholderName($card['holder'])
                ->setNumber($card['number'])
                ->setSecurityCode($card['securityCode'])
                ->setExpiryMonth($card['expireAt']['month'])
                ->setExpiryYear($card['expireAt']['year'])
            ;

            $details['card'] = $cardData;
        }

        $details['amount'] = number_format($order->getTotal() / 100, 2);
        $details['returnUrl'] = $this->tokenFactory->createNotifyToken(
        $request->getToken()->getPaymentName(),
        $payment
        )->getTargetUrl();

        $payment->setDetails($details);

        $details = ArrayObject::ensureArrayObject($details);

        try {
            $request->setModel($details);
            $this->payment->execute($request);

            $payment->setDetails((array) $details);
            $request->setModel($payment);

            // echo '<pre>'; var_dump($this->getRequest()->request->get('payum_credit_card')); die('bu-bi');
            // echo '<pre>'; var_dump($payment->getDetails()['card']); die('bu');
        } catch (\Exception $e) {
            $payment->setDetails((array) $details);
            $request->setModel($payment);

            throw $e;
        }
    }

    protected function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }
}
