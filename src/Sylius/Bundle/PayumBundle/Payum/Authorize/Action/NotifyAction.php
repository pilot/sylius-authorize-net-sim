<?php

namespace Sylius\Bundle\PayumBundle\Payum\Authorize\Action;

use Doctrine\Common\Persistence\ObjectManager;
use Payum\Core\Bridge\Symfony\Reply\HttpResponse;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\Notify;
use Payum\Core\Reply\HttpRedirect;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractPaymentStateAwareAction;
use Sylius\Bundle\PayumBundle\Payum\Request\GetStatus;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Alex Demchenko <pilo.uanic@gmail.com>
 */
class NotifyAction extends AbstractPaymentStateAwareAction
{
    /**
    * @var Request
    */
    protected $httpRequest;

    /**
     * @var RepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $identifier;

    /**
    * @var SessionInterface
    */
    protected $session;

    /**
    * @var TranslatorInterface
    */
    protected $translator;


    public function __construct(
        RepositoryInterface $paymentRepository,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager,
        FactoryInterface $factory,
        $identifier,
        SessionInterface $session,
        TranslatorInterface $translator
    ) {
        parent::__construct($factory);

        $this->paymentRepository = $paymentRepository;
        $this->eventDispatcher   = $eventDispatcher;
        $this->objectManager     = $objectManager;
        $this->identifier        = $identifier;
        $this->session           = $session;
        $this->translator        = $translator;
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
     * @param $request Notify
     */
    public function execute($request)
    {
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $this->payment->execute($httpRequest = new GetHttpRequest());
        $details = $httpRequest->request;

        if (empty($details['x_po_num'])) {
            throw new BadRequestHttpException('Order id cannot be guessed');
        }

        $payment = $this->paymentRepository->findOneBy(array($this->identifier => $details['x_po_num']));

        if (null === $payment) {
            throw new BadRequestHttpException('Paymenet cannot be retrieved.');
        }

        if (intval(strval($details['x_amount']*100)) !== $payment->getAmount()) {
            throw new BadRequestHttpException('Request amount cannot be verified against payment amount.');
        }

        // Actually update payment details
        $details = array_merge($payment->getDetails(), $details);
        $payment->setDetails($details);

        $status = new GetStatus($payment);
        $this->payment->execute($status);

        $nextState = $status->getValue();

        $this->updatePaymentState($payment, $nextState);

        $this->objectManager->flush();

        $this->addFlash($nextState);

        throw new HttpRedirect($this->httpRequest->getSchemeAndHttpHost());
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof Notify;
    }

    public function addFlash($state)
    {
        switch ($state) {
            case 'completed':
            $type = 'success';
            $message = 'sylius.checkout.success';
            break;

            case 'processing':
            case 'pending':
            $type = 'notice';
            $message = 'sylius.checkout.processing';
            break;

            case 'new':
            $type = 'notice';
            $message = 'sylius.checkout.new';
            break;

            case 'void':
            $type = 'notice';
            $message = 'sylius.checkout.canceled';
            break;

            case 'failed':
            $type = 'error';
            $message = 'sylius.checkout.failed';
            break;

            default:
            $type = 'error';
            $message = 'sylius.checkout.unknown';
            break;
        }

        return $this->session->getBag('flashes')->add(
            $type,
            $this->translator->trans($message, array(), 'flashes')
        );
    }
}
