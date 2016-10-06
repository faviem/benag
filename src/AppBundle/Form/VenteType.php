<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use AppBundle\Form\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Form\EventListener\AddCityFieldSubscriber;
use AppBundle\Form\EventListener\AddProvinceFieldSubscriber;
class VenteType extends AbstractType
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
            ->add('product', ProductType::class)   
//            ->add('product', EntityType::class, array(
//                'class'     => 'AppBundle:Product',
//                'group_by'  => 'category.name',
//                'choice_name'  => 'name',
//                'placeholder' => 'Choisissez votre produit',
//                'required' => true
//            ))
            ->add('lieu')
            ->add('quantite')
            ->add('uniteMesure', ChoiceType::class, array(
                'choices'  => array(
                    'Kg' => 'Kg',
                    'Quarantaine' => 'Quarantaine',

                ),
                'placeholder' => 'Choisissez',
                'required' => true
            ))    
//            ->add('dateLimit', DateType::class, array(
//                'widget' => 'single_text',
//                'format' => 'dd/MM/yyyy',
//                'placeholder' => 'dd/MM/yyyy'
//            ))
            ->add('prixUnit')
            ->add('description')
            ->add('imageFile',  VichFileType::class, array(
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
   
//            ->add('product')
//            ->add('user')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vente'
        ));
    }
}
