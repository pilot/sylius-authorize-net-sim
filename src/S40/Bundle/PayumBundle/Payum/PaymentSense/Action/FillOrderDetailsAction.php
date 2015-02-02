<?php
namespace S40\Bundle\PayumBundle\Payum\PaymentSense\Action;

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
        $divisor = pow(10, $order->getCurrencyDigitsAfterDecimalPoint());

        $details = array();
        $details['Amount'] = $order->getTotalAmount();
        $details['OrderID'] = $order->getNumber();
        $details['OrderDescription'] = $order->getDescription();
        $details['EmailAddress'] = $order->getClientEmail();
        $details['CustomerName'] = '';
        $details['Address1'] = '';
        $details['Address2'] = '';
        $details['Address3'] = '';
        $details['Address4'] = '';
        $details['City'] = '';
        $details['State'] = '';
        $details['PostCode'] = '';
        $details['CountryCode'] = '';
        $details['CurrencyCode'] = 826;
        $details['PhoneNumber'] = '';

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
