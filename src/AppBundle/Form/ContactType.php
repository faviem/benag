<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

/**
 * Description of ContactType
 *
 * @author Jacques Adjahoungbo
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array('label' => 'Nom :'))
//                ->add('prenom', TextType::class, array('label' => 'Prénom :'))
                ->add('email', EmailType::class, array('label' => 'Email'))
                ->add('objet', TextType::class, array('label' => 'Objet'))
                ->add('message', TextareaType::class, array('label' => 'Message', 'attr' => array('rows' => 3, 'class' => 'col-md-6')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'nom' => new Length(array('min' => 3)),
            'email' => new Email(array('message' => 'Email invalide')),
            'objet' => new Length(array('min' => 5)),
            'message' => new Length(array('min' => 10)),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint,
        ));
    }

    public function getName()
    {
        return 'appcontacttype';
    }
}