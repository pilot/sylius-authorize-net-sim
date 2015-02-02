<?php

namespace S40\Bundle\PayumBundle\DependencyInjection\Factory\Payment;

use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Payment\AbstractPaymentFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class PaymentSensePaymentFactory extends AbstractPaymentFactory
{
    public function create(ContainerBuilder $container, $contextName, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config/payment'));
        $loader->load('payment_sense.xml');

        return parent::create($container, $contextName, $config);
    }

    /**
     * @param Definition       $paymentDefinition
     * @param ContainerBuilder $container
     * @param                  $contextName
     * @param array            $config
     */
    protected function addApis(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
        $apiDefinition = new DefinitionDecorator('store.payment_sense.api');
        $apiDefinition->replaceArgument(0, $config['options']);
        $apiDefinition->setPublic(true);
        $apiId = 'payum.context.'.$contextName.'.api';
        $container->setDefinition($apiId, $apiDefinition);
        $paymentDefinition->addMethodCall('addApi', [new Reference($apiId)]);
    }

    /**
     * @param ArrayNodeDefinition $builder
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);

        $builder->children()
            ->arrayNode('options')->isRequired()->children()
                ->scalarNode('merchant_id')->cannotBeEmpty()->end()
                ->scalarNode('password')->cannotBeEmpty()->end()
                ->scalarNode('pre_shared_key')->cannotBeEmpty()->end()
                ->booleanNode('sandbox')->defaultTrue()->end()
            ->end()
        ->end();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "payment_sense";
    }
}
