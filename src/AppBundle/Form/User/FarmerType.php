<?php

namespace AppBundle\Form\User;

use Ben\UserBundle\Form\RegistrationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\User\Farmer;

class FarmerType extends RegistrationType
{
    
//    public function __construct() {
//        $this->class = new Farmer();  
//    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('nomEntreprise')
            ->add('typeProfile', ChoiceType::class, array(
                    'choices'  => array(
                        'Producteur' => 'Producteur',
                        'Grossiste' => 'Grossiste',
                        'Courtier' => 'Courtier',
                        'Détaillant' => 'Détaillant',
                        'Autres' => 'Autres',
                    ),
                    'placeholder' => 'Vous êtes',
                    'required' => true
            ))
            ->add('domaine', ChoiceType::class, array(
                    'choices'  => array(
                        'Fruits et légumes' => 'Fruits et légumes',
                        'Céréales' => 'Céréales',
                        'Autres' => 'Autres',
                    ),
                    'placeholder' => 'Spécialisé en',
                    'required' => true
            ))
            ->add('adresse')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Farmer'
        ));
    }
}