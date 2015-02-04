<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Doctrine\Common\Persistence\ObjectManager;

use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\Notify;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\ApiAwareInterface;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractPaymentStateAwareAction;
use Sylius\Bundle\PayumBundle\Payum\Request\GetStatus;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use S40\Bundle\PayumBundle\Payum\PaymentSense\Api;
use S40\Bundle\PayumBundle\Payum\PaymentSense\PaymentFormHelper;

/**
 * @author Alex Demchenko <pilo.uanic@gmail.com>
 */
class NotifyAction extends AbstractPaymentStateAwareAction implements ApiAwareInterface
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
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var Api
     */
    protected $api;

    protected $tokenStorage;


    public function __construct(
        RepositoryInterface $paymentRepository,
        ObjectManager $objectManager,
        FactoryInterface $factory,
        $identifier
    ) {
        parent::__construct($factory);

        $this->paymentRepository = $paymentRepository;
        $this->objectManager     = $objectManager;
        $this->identifier        = $identifier;
    }

    public function setApi($api)
    {
        if (false === $api instanceof Api) {
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
     * @param $request Notify
     */
    public function execute($request)
    {
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $this->payment->execute($httpRequest = new GetHttpRequest());

        // check that payment status and fetch details from the PaymentSense
        $this->api->getResultValidationSuccessful($httpRequest->query);
        $details = $this->api->transactionResult;

        if (empty((int)$details->getOrderID())) {
            throw new BadRequestHttpException('Order id cannot be guessed');
        }

        $payment = $this->paymentRepository->findOneBy(array($this->identifier => (int)$details->getOrderID()));

        if (null === $payment) {
            throw new BadRequestHttpException('Paymenet cannot be retrieved.');
        }

        // @todo: check that sylius payment amount contain tax
        // if (intval(strval($details->getAmount())) !== $payment->getAmount()) {
        //     throw new BadRequestHttpException('Request amount cannot be verified against payment amount.');
        // }

        // Actually update payment details
        $details = array_merge($payment->getDetails(), $details->__toArray());
        $payment->setDetails($details);

        $status = new GetStatus($payment);
        $this->payment->execute($status);

        $nextState = $status->getValue();

        $this->updatePaymentState($payment, $nextState);

        $this->objectManager->flush();

        // mark status as redirect after
        $this->httpRequest->getSession()->set('StatusCode', $details['StatusCode']);

        throw new HttpRedirect($this->httpRequest->getSession()->get('AfterUrl'));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof Notify;
    }
}
