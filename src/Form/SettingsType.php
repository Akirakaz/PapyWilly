<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image as ImageConstraints;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('twitchChannel', TextType::class, [
                'label' => 'Channel Twitch',
                'attr' => [
                    'placeholder' => 'Nom de chaine',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom de chaine',
                    ]),
                ],
            ])
            ->add('youtubeChannel', TextType::class,[
                'label' => 'Channel Youtube',
                'attr' => [
                    'placeholder' => 'Nom de chaine',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Veuillez renseigner votre nom de chaine',
                    ])
                ]
            ])
            ->add('profilTitle', TextType::class,[
                'label' => 'Titre du Profil',
                'attr' => [
                    'placeholder' => 'Titre de présentation',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Veuillez renseigner votre titre de présentation',
                    ])
                ]
            ])
            ->add('profilDescription', TextType::class,[
                'label' => 'Profil Description',
                'attr' => [
                    'placeholder' => 'Description de présentation',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Veuillez renseigner votre description',
                    ])
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required'    => false,
                'label'       => 'Photo de profil',
                'data_class' => null,
                'constraints' => [
                    new ImageConstraints([
                        'maxSize'           => '1M',
                        'extensions'        => [
                            'jpg',
                            'jpeg',
                            'png',
                            'webp',
                            'avif',
                        ],
                        'mimeTypes'         => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/avif',
                        ],
                        'mimeTypesMessage'  => false,
                    ]),
                ],
            ])
            ->add('channelDescription', TextType::class, [
                'label' => 'Channel Description',
                'attr' => [
                    'placeholder' => 'Description de chaine',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la description de votre chaine',
                    ]),
                ],
            ])
            ->add('channelCity', TextType::class,[
                'label' => 'Channel City',
                'attr' => [
                    'placeholder' => 'Ville, Pays',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Veuillez renseigner la ville et votre Pays',
                    ])
                ]
            ])->add('channelPlatforms', TextType::class, [
                'label' => 'Channel Platforms',
                'attr' => [
                    'placeholder' => 'Platformes de jeux de la chaine',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la ou les platformes de jeux de la chaine',
                    ]),
                ],
            ])
            ->add('channelContent', TextType::class,[
                'label' => 'Channel Contenu',
                'attr' => [
                    'placeholder' => 'Limitation d\'ages de la chaine',
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Veuillez renseigner l\'age minimal recommandé pour la chaine',
                    ])
                ]
            ])->add('channelGame', TextType::class, [
                'label' => 'Channel Game',
                'attr' => [
                    'placeholder' => 'Jeux favoris de la chaine',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner les jeux favoris de votre chaine',
                    ]),
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
