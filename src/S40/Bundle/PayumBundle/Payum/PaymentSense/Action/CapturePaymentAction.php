<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Payum\Core\Bridge\Symfony\Security\TokenFactory;
use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\SecuredCaptureRequest;
use Sylius\Component\Core\Model\PaymentInterface;

/**
 * @author Alex Demchenko <pilo.uanic@gmail.com>
 */
class CapturePaymentAction extends PaymentAwareAction
{
    /**
     * @var TokenFactory
     */
    protected $tokenFactory;

    /**
     * @param TokenFactory $tokenFactory
     */
    public function __construct(TokenFactory $tokenFactory)
    {
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * @param mixed $request
     *
     * @throws RequestNotSupportedException
     * @throws \Exception
     */
    public function execute($request)
    {
        /** @var $request SecuredCaptureRequest */
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        /** @var $payment PaymentInterface */
        $payment = $request->getModel();
        $order = $payment->getOrder();
        $details = $payment->getDetails();

        if (empty($details)) {
            $notifyToken = $this->tokenFactory->createNotifyToken($request->getToken()->getPaymentName(), $payment);

            $details = [
                'price' => number_format($order->getTotal() / 100, 2, '.', ''),
                'currency' => $order->getCurrency(),
                'notificationURL' => $notifyToken->getTargetUrl(),
                'redirectURL' => $request->getToken()->getTargetUrl().'?state=paid',
                'posData' => json_encode(['hash' => $notifyToken->getHash()]),
                'orderID' => $order->getNumber()
            ];

            $payment->setDetails((array) $details);
            $payment->setAmount($order->getTotal());
            $payment->setCurrency($order->getCurrency());
        }

        $details = ArrayObject::ensureArrayObject($details);

        try {
            $request->setModel($details);
            $this->payment->execute($request);

            $payment->setDetails((array) $details);
            $request->setModel($payment);
        } catch (\Exception $e) {
            $payment->setDetails((array) $details);
            $request->setModel($payment);

            throw $e;
        }
    }

    public function supports($request)
    {
        return
            $request instanceof SecuredCaptureRequest &&
            $request->getModel() instanceof PaymentInterface
        ;
    }
}
