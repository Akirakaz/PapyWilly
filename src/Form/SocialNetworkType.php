<?php

namespace App\Form;

use App\Entity\SocialNetwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('icon', ChoiceType::class, [
                'label'       => 'Service',
                'placeholder' => 'Choisissez un service',
                'required'    => true,
                'choices'     => [
                    'Twitch'    => 'icon-twitch',
                    'Youtube'   => 'icon-youtube',
                    'Instagram' => 'icon-instagram',
                    'Tiktok'    => 'icon-tiktok',
                    'Discord'   => 'icon-discord',
                    'Facebook'  => 'icon-facebook',
                    'Twitter'   => 'icon-twitter',
                ]
            ])
            ->add('alt', TextType::class, [
                'required' => false,
                'label' => "Texte d'affichage",
                'attr' => [
                    'placeholder' => 'Alt',
                ]
            ])
            ->add('url', TextType::class, [
                'required' => true,
                'label' => "Url du service",
                'attr' => [
                    'placeholder' => 'https://',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocialNetwork::class,
        ]);
    }
}