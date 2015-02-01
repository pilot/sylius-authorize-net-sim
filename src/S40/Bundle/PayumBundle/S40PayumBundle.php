<?php

namespace S40\Bundle\PayumBundle;

use S40\Bundle\PayumBundle\DependencyInjection\Factory\Payment\PaymentSensePaymentFactory;
use Payum\Bundle\PayumBundle\DependencyInjection\PayumExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class S40PayumBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        /** @var $extension PayumExtension */
        $extension = $container->getExtension('payum');

        $extension->addPaymentFactory(new PaymentSensePaymentFactory());
    }

    public function getParent()
    {
        return 'PayumBundle';
    }
}
