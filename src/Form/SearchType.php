<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [
            'Nom' => 'name',
            'Type' => 'type',
            'Numéro de pokédex' => 'numPokedex',
        ];

        $builder->add('toSearch', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Rechercher un pokémon',
                    ),
                )
            )
            ->add('searchBy', ChoiceType::class, array(
                'label' => false,
                'choices' => $choices,
                'choice_attr' => function($choices, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'ml-3'];
                },
                'expanded' => true,
                'multiple' => false,
                'data' => 'name',
            ))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array());
    }
}
