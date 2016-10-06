<?php

/**
 * Description of ProfileFormType
 *
 * @author Jacques
 */

namespace Ben\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Ben\UserBundle\Form\Type\ResettingFormType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFormType extends BaseType
{
    protected $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        parent::__construct($class);
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // Ajoute le champ personnalisé aux formulaires de mise à jour du profile
        $builder

            ->add('password', new ResettingFormType($this->class), array(
                'required' => false,
                'virtual' => true
            ))
            ->add('desabonner', 'submit', array(
                'label' => 'profile.edit.unsubscribe',
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'btn primary',
                    'formnovalidate' => 'formnovalidate',
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'profile',
        ));
    }

    public function getName()
    {
        return 'aikido_user_profile';
    }
}
