<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'       => 'Adresse email actuelle',
                'required'    => false,
                'constraints' => [
                    new Email(),
                ],
            ])
            ->add('oldPassword', PasswordType::class, [
                'label'       => 'Mot de passe actuel',
                'mapped'      => false,
                'required'    => false,
                'attr'        => ['autocomplete' => false],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe actuel.',
                        'groups'  => ['change_password'],
                    ]),
                    new UserPassword([
                        'groups'  => ['change_password'],
                    ])
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped'          => false,
                'required'        => false,
                'type'            => PasswordType::class,
                'attr'            => [
                    'autocomplete' => false,
                    'class' => 'w-full'
                ],
                'first_options'   => [
                    'label' => 'Nouveau mot de passe',
                    'attr'  => ['class' => 'w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'],
                ],
                'second_options'  => [
                    'label' => 'Répétez le mot de passe',
                    'attr'  => ['class' => 'w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'],
                ],
                'constraints'     => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                    ]),
                    new PasswordStrength([
                        'minScore' => PasswordStrength::STRENGTH_WEAK,
                    ]),
                    new NotCompromisedPassword()
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => function ($form) {
                $oldPassword = $form->get('oldPassword')->getData();

                if (!empty($oldPassword)) {
                    return ['Default', 'change_password'];
                }

                return ['Default'];
            }
        ]);
    }
}
