<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Identifiant'
                )))
            ->add('lastName', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom'
                )))
            ->add('firstName', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prénom'
                )))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'email'
                )))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => false, 'attr' => array(
                    'placeholder' => 'Mot de passe',
                )),
                'second_options' => array('label' => false, 'attr' => array(
                    'placeholder' => 'Confirmation mot de passe'
                )),
            ))
            ->add('city', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Ville'
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
