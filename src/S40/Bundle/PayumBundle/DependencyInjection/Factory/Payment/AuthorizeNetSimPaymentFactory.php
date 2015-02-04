<?php

namespace S40\Bundle\PayumBundle\DependencyInjection\Factory\Payment;

use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Payment\AbstractPaymentFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;

class AuthorizeNetSimPaymentFactory extends AbstractPaymentFactory
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $contextName, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config/payment'));
        $loader->load('authorize_net_sim.xml');

        return parent::create($container, $contextName, $config);
    }

    /**
     * {@inheritDoc}
     */
    protected function addApis(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
        $apiDefinition = new DefinitionDecorator('store.authorize_net_sim.api');
        $apiDefinition->replaceArgument(0, $config['options']);
        $apiDefinition->setPublic(true);
        $apiId = 'payum.context.'.$contextName.'.api';
        $container->setDefinition($apiId, $apiDefinition);
        $paymentDefinition->addMethodCall('addApi', [new Reference($apiId)]);
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);

        $builder->children()
            ->scalarNode('login_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('transaction_key')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('sandbox')->defaultTrue()->end()
        ->end();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'authorize_net_sim';
    }
}
