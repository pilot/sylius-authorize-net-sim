<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PromotionBundle\Form\Type;

use JMS\TranslationBundle\Annotation\Ignore;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Promotion form type.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class PromotionType extends AbstractResourceType
{
    /**
     * @var ServiceRegistryInterface
     */
    protected $checkerRegistry;

    /**
     * @var ServiceRegistryInterface
     */
    protected $actionRegistry;

    public function __construct($dataClass, array $validationGroups, ServiceRegistryInterface $checkerRegistry, ServiceRegistryInterface $actionRegistry)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->checkerRegistry = $checkerRegistry;
        $this->actionRegistry = $actionRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'sylius.form.promotion.name'
            ))
            ->add('description', 'text', array(
                'label' => 'sylius.form.promotion.description'
            ))
            ->add('exclusive', 'checkbox', array(
                'label' => 'sylius.form.promotion.exclusive'
            ))
            ->add('usageLimit', 'integer', array(
                'label' => 'sylius.form.promotion.usage_limit'
            ))
            ->add('startsAt', 'date', array(
                'label' => 'sylius.form.promotion.starts_at',
                'empty_value' => /** @Ignore */ array('year' => '-', 'month' => '-', 'day' => '-')
            ))
            ->add('endsAt', 'date', array(
                'label' => 'sylius.form.promotion.ends_at',
                'empty_value' => /** @Ignore */ array('year' => '-', 'month' => '-', 'day' => '-')
            ))
            ->add('couponBased', 'checkbox', array(
                'label' => 'sylius.form.promotion.coupon_based',
                'required' => false
            ))
            ->add('rules', 'collection', array(
                'type'         => 'sylius_promotion_rule',
                'allow_add'    => true,
                'by_reference' => false,
                'label'        => 'sylius.form.promotion.rules'
            ))
            ->add('actions', 'collection', array(
                'type'         => 'sylius_promotion_action',
                'allow_add'    => true,
                'by_reference' => false,
                'label'        => 'sylius.form.promotion.actions'
            ))
        ;

        $prototypes = array();
        $prototypes['rules'] = array();

        foreach ($this->checkerRegistry->all() as $type => $checker) {
            $prototypes['rules'][$type] = $builder->create('__name__', $checker->getConfigurationFormType())->getForm();
        }

        $prototypes['actions'] = array();

        foreach ($this->actionRegistry->all() as $type => $action) {
            $prototypes['actions'][$type] = $builder->create('__name__', $action->getConfigurationFormType())->getForm();
        }

        $builder->setAttribute('prototypes', $prototypes);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['prototypes'] = array();

        foreach ($form->getConfig()->getAttribute('prototypes') as $group => $prototypes) {
            foreach ($prototypes as $type => $prototype) {
                $view->vars['prototypes'][$group.'_'.$type] = $prototype->createView($view);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_promotion';
    }
}