<?php

namespace Jack\AdvertBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Jack\AdvertBundle\Form\EventListener\AddCityFieldSubscriber;
use Jack\AdvertBundle\Form\EventListener\AddProvinceFieldSubscriber;
class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $propertyPathToCity = 'city';

        $builder
            ->addEventSubscriber(new AddProvinceFieldSubscriber($propertyPathToCity))
            ->addEventSubscriber(new AddCityFieldSubscriber($propertyPathToCity))

        ;
        $builder
            ->add('title')
            ->add('content')
            ->add('price')
            ->add('category', 'entity', array(
                'class' => 'JackAdvertBundle:Category',
                'property' => 'name',
            )) 
            ->add('images', 'collection', array('type'=> new ImageType(),
                'allow_add'=>true,
                'allow_delete' =>true
            ))
   
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jack\AdvertBundle\Entity\Advert',
        ));

        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'advert';
    }
}
