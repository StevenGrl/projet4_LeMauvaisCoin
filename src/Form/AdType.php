<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Type;
use App\Repository\ImageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Titre de l\'annonce'
                )))
            ->add('name', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom de l\'article'
                )))
            ->add('description', TextareaType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Description'
                )))
            ->add('imageFile', FileType::class, array(
                'label' => 'Image de l\'annonce',
                'required' => false,
            ))
            ->add('price', IntegerType::class, array(
                'label' => false,
                'required' => false,
                'scale' => 2,
                'attr' => array(
                    'placeholder' => 'Prix'
                ),
            ))
            ->add('exchange', TextType::class, array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Échange'
                ),
            ))
            ->add('type', EntityType::class, array(
                'label' => false,
                'class' => Type::class,
                'choice_label' => 'label',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
