<?php
namespace Sylius\Bundle\PayumBundle\Payum\Authorize\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;

class StatusAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (null === $model['x_response_code']) {
            $request->markNew();

            return;
        }

        if (\AuthorizeNetAIM_Response::APPROVED == $model['x_response_code']) {
            $request->markCaptured();

            return;
        }

        if (\AuthorizeNetAIM_Response::DECLINED == $model['x_response_code']) {
            $request->markCanceled();

            return;
        }

        if (\AuthorizeNetAIM_Response::ERROR == $model['x_response_code']) {
            $request->markFailed();

            return;
        }

        if (\AuthorizeNetAIM_Response::HELD == $model['x_response_code']) {
            $request->markPending();

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
