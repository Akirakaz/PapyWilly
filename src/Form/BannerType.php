<?php

namespace App\Form;

use App\Entity\Banner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image as ImageConstraints;
use Symfony\Component\Validator\Constraints\Length;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('altText', TextType::class, [
                'label' => 'Texte alternatif',
                'attr' => [
                    'placeholder' => "Description textuelle de l'image...",
                ],
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le texte alternatif ne doit pas dépasser {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'data_class' => null,
                'label' => 'Image',
                'constraints' => [
                    new ImageConstraints([
                        'maxSize' => '1M',
                        'extensions' => [
                            'jpg',
                            'jpeg',
                            'png',
                            'webp',
                            'avif',
                        ],
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/avif',
                        ],
                        'mimeTypesMessage' => false,
                        'maxSizeMessage' => "L'image ne doit pas dépasser {{ limit }} {{ suffix }}",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
