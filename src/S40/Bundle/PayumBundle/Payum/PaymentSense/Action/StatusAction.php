<?php
namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

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

        switch ($model['StatusCode']) {
            case 0:
                $request->markCaptured();
                break;
            case 4:
                $request->markFailed();
                break;
            case 5:
                $request->markFailed();
                break;
            case 20:
                if ($model['PreviousStatusCode'] == 0) {
                    $request->markCaptured();
                } else {
                    $request->markFailed();
                }
                break;
            case 30:
                $request->markFailed();
                break;
            default:
                $request->markUnknown();
                break;
        }
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
