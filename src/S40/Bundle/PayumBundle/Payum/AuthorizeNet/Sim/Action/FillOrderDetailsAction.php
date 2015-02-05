<?php

namespace S40\Bundle\PayumBundle\Payum\AuthorizeNet\Sim\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\FillOrderDetails;

class FillOrderDetailsAction implements ActionInterface
{
    /**
     * {@inheritDoc}
     *
     * @param FillOrderDetails $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $order = $request->getOrder();

        $details = array();
        $details['x_amount'] = number_format($order->getTotalAmount() / 100, 2);
        $details['x_invoice_num'] = $order->getNumber();
        $details['x_description'] = $order->getDescription();
        $details['email_address'] = $order->getClientEmail();

        $order->setDetails($details);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof FillOrderDetails;
    }
}
