<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image as ImageConstraints;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('youtubeChannel', TextType::class, [
                'required' => false,
                'label' => 'Chaine Youtube',
                'attr' => [
                    'placeholder' => 'url de chaine',
                ],
            ])
            ->add('aboutTitle', TextType::class, [
                'required' => false,
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre',
                ],
            ])
            ->add('aboutDescription', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                ],
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
            ->add('channelDescription', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Chaine de gaming chill...',
                ]
            ])
            ->add('channelCountry', TextType::class, [
                'required' => false,
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'France',
                ],
            ])
            ->add('channelPlatforms', TextType::class, [
                'required' => false,
                'label' => 'Plateformes',
                'attr' => [
                    'placeholder' => 'PC, PS5, XBox, Switch...',
                ]
            ])
            ->add('channelGames', TextType::class, [
                'required' => false,
                'label' => 'Jeux favoris',
                'attr' => [
                    'placeholder' => 'Diablo, WoW, LoL...',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
