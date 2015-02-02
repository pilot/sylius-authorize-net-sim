<?php
namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;

class StatusAction implements ActionInterface
{
    const
        APPROVED = 0,
        DECLINED = 5,
        ERROR = 30
    ;

    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (null === $model['StatusCode']) {
            $request->markNew();

            return;
        }

        if (self::APPROVED == $model['StatusCode']) {
            $request->markCaptured();

            return;
        }

        if (self::DECLINED == $model['StatusCode']) {
            $request->markCanceled();

            return;
        }

        if (self::ERROR == $model['StatusCode']) {
            $request->markFailed();

            return;
        }

        $request->markUnknown();
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
