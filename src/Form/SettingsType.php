<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
