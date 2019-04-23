<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            $form = $event->getForm();
            $user = $event->getData();

            if (is_null($user->getId())) {
                $form ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'empty_data' => '',
                    'invalid_message' => 'Le mot de passe indiqué doit être identique dans les deux champs',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe','empty_data' => ''],
                    'second_options' => ['label' => 'Répéter le mot de passe','empty_data' => '',],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le champ ne doit pas être vide'
                        ]),
                    ]
                ]);
            } else {
                $form ->add('password', PasswordType::class, [
                    'empty_data' => '',
                    'label'    => "Mot de passe",
                    'attr' => ['placeholder' => 'Laisser vide si inchangé'],
                ]);
            }
        };

        $builder
            ->add('username', TextType::class, [
                'label'    => "Nom d'utilisateur",
                'attr' => ['placeholder' => "Ce nom sera votre identifiant sur la plateforme"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne doit pas être vide'
                    ]),
                    new Length([
                        'min'        => 3,
                        'max'        => 200,
                        'minMessage' => 'Pas assez de caractères , attendu : {{ limit }}',
                        'maxMessage' => 'Trop de caractères, attendu: {{ limit }}',
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label'    => "Présentation",
                'attr' => ['placeholder' => "Quelques mots pour vous présenter"],
            ])
            ->add('image', UrlType::class, [
                'label'    => "Url de l'avatar",
                'attr' => ['placeholder' => "Url de l'image qui vous servira d'avatar"],
            ])
            ->add('email', EmailType::class, [
                'label'    => "Adresse e-mail",
                'attr' => ['placeholder' => "Votre adresse email"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne doit pas être vide'
                    ])
                ],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)
/*             ->add('role', EntityType::class, [
                'class' => Role::class,
                'multiple'=>false,
                'expanded' => false,
                'query_builder' => function (RoleRepository $roleRepo) {
                    return $roleRepo->createQueryBuilder('role')
                        ->orderBy('role.name', 'ASC');
                },
                'choice_label' => 'name'
            ]) */
        ;
    }
}
