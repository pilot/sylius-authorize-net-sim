<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\StatusRequestInterface;
use Symm\BitpayClient\Model\Invoice;

class StatusAction implements ActionInterface
{
    /**
     * @param mixed $request
     *
     * @throws RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        /** @var $request StatusRequestInterface */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $details = new ArrayObject($request->getModel());

        if (isset($details['id']) && isset($details['status'])) {
            switch ($details['status']) {
                case Invoice::STATUS_NEW:
                    $request->markNew();

                    return;
                case Invoice::STATUS_PAID:
                    $request->markPending();
                    break;
                case Invoice::STATUS_CONFIRMED:
                case Invoice::STATUS_COMPLETE:
                    $request->markSuccess();
                    break;
                case Invoice::STATUS_EXPIRED:
                case Invoice::STATUS_INVALID:
                    $request->markCanceled();
                    break;
            }

            return;
        }

        $request->markNew();
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        if (false == $request instanceof StatusRequestInterface) {
            return false;
        }

        $model = $request->getModel();

        if (false == $model instanceof \ArrayAccess) {
            return false;
        }

        return isset($model['price']) && isset($model['currency']);
    }
}
