<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Doctrine\Common\Persistence\ObjectManager;
use Payum\Core\Bridge\Symfony\Reply\HttpResponse;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\Token;
use Payum\Core\Request\NotifyRequest;
use Payum\Core\Storage\StorageInterface;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractPaymentStateAwareAction;
use Sylius\Bundle\PayumBundle\Payum\Request\StatusRequest;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NotifyAction extends AbstractPaymentStateAwareAction
{
    protected $tokenStorage;
    protected $paymentRepository;
    protected $paymentManager;

    public function __construct(
        StorageInterface $tokenStorage,
        RepositoryInterface $paymentRepository,
        ObjectManager $paymentManager,
        FactoryInterface $factory
    )
    {
        parent::__construct($factory);

        $this->tokenStorage      = $tokenStorage;
        $this->paymentRepository = $paymentRepository;
        $this->paymentManager    = $paymentManager;
    }

    public function execute($request)
    {
        /** @var $request NotifyRequest */
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $details = $request->getNotification();

        if (false === $hash = json_decode($details['posData'], true)['hash']) {
            throw new BadRequestHttpException('Hash cannot be guessed.');
        }

        /** @var $token Token */
        if (false == $token = $this->tokenStorage->findModelById($hash)) {
            throw new BadRequestHttpException(sprintf('A token with hash `%s` could not be found.', $hash));
        }

        /** @var $token Token */
        if (false == $token = $this->tokenStorage->findModelById($hash)) {
            throw new BadRequestHttpException(sprintf('A token with hash `%s` could not be found.', $hash));
        }

        if (null === $payment = $this->paymentRepository->findOneBy(['id' => $token->getDetails()->getId()])) {
            throw new BadRequestHttpException('Payment cannot be retrieved.');
        }

        if (intval(strval($details['price']*100)) !== $payment->getAmount()) {
            throw new BadRequestHttpException('Request amount cannot be verified against payment amount.');
        }

        // Actually update payment details
        $details = array_merge($payment->getDetails(), $details);
        $payment->setDetails($details);

        $status = new StatusRequest($payment);
        $this->payment->execute($status);

        $nextState = $status->getStatus();

        $this->updatePaymentState($payment, $nextState);

        $this->paymentManager->flush();

        // Delete the token
        $this->tokenStorage->deleteModel($token);

        throw new HttpResponse(new Response('OK', 200));
    }

    public function supports($request)
    {
        return $request instanceof NotifyRequest;
    }
}
