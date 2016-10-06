<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class AddProvinceFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToCity;

    public function __construct($propertyPathToCity)
    {
        $this->propertyPathToCity = $propertyPathToCity;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }

    private function addProvinceForm($form, $province = null)
    {
        $formOptions = array(
            'class'         => 'AppBundle:Province',
            'placeholder' => 'Département',
            'label'         => '',
            'mapped'        => false,
            'attr'          => array(
                'class' => 'province_selector',
            ),
        );

        if ($province) {
            $formOptions['data'] = $province;
        }

        $form->add('province', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $city        = $accessor->getValue($data, $this->propertyPathToCity);
        $province    = ($city) ? $city->getProvince() : null;

        $this->addProvinceForm($form, $province);
    }

    
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        $this->addProvinceForm($form);
    }
}
