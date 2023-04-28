<?php

namespace App\Form;

use App\Entity\Hardware;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HardwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand')
            ->add('model')
            ->add('url')
            ->add('icon', ChoiceType::class, [
                'label'       => 'Type',
                'placeholder' => 'Choisissez votre matériel',
                'choices'     => [
                    'Souris'          => 'icon-mice',
                    'Écran'           => 'icon-screen',
                    'Chaise'          => 'icon-chair',
                    'Clavier'         => 'icon-keyboard',
                    'Casque'          => 'icon-headset',
                    'Carte graphique' => 'icon-gpu',
                    'Processeur'      => 'icon-cpu',
                    'RAM'             => 'icon-ram',
                    'Micro'           => 'icon-microphone',
                    'Webcam'          => 'icon-webcam',
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
