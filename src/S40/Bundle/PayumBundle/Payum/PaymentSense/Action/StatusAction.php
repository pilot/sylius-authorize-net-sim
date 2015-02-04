<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Symfony\Component\HttpFoundation\Session\Session;

class StatusAction implements ActionInterface
{
    /**
     * @var Session
     */
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        // to control payment status over steps
        if ($this->session->has('StatusCode')) {
            $model['StatusCode'] = $this->session->get('StatusCode');

            $this->session->remove('StatusCode');
        }

        if (is_null($model['StatusCode'])) {
            $request->markNew();

            return;
        }

        if (0 === $model['StatusCode']) {
            $request->markCaptured();

            return;
        }

        if (in_array($model['StatusCode'], [4, 5, 30])) {
            $request->markFailed();

            return;
        }

        if (20 == $model['StatusCode']) {
            if ($model['PreviousStatusCode'] == 0) {
                    $request->markCaptured();
            } else {
                    $request->markFailed();
            }

            return;
        }

        $request->markFailed();
        echo 'failed:'; die(dump($model['StatusCode']));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
