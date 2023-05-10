<?php

namespace App\Form;

use App\Entity\Hardware;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class HardwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, [
                'label' => 'Marque',
                'attr' => [
                    'placeholder' => 'Razer, Logitech, Corsair, ...',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une marque',
                    ]),
                ],
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'attr' => [
                    'placeholder' => 'Deathadder, G502, G910, ...',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un modèle',
                    ]),
                ],
            ])
            ->add('url', UrlType::class, [
                'required' => false,
                'label' => 'URL',
                'attr' => [
                    'placeholder' => 'https://amzn.fr/...',
                ],
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez renseigner une url valide',
                    ])
                ],
            ])
            ->add('icon', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'placeholder' => 'Choisissez votre matériel',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un type de matériel',
                    ]),
                ],
                'choices' => [
                    'Souris' => 'icon-souris',
                    'Clavier' => 'icon-clavier',
                    'Casque' => 'icon-casque',
                    'Microphone' => 'icon-microphone',
                    'Écran' => 'icon-ecran',
                    'Webcam' => 'icon-webcam',
                    'Chaise' => 'icon-chaise',
                    'Carte mère' => 'icon-carte-mere',
                    'Carte graphique' => 'icon-gpu',
                    'Processeur' => 'icon-cpu',
                    'RAM' => 'icon-ram',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hardware::class,
        ]);
    }
}
