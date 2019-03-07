<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label'    => "Titre de la réponse ?",
            'attr' => ['placeholder' => "Le titre apparaîtra dans la liste de réponses"],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le champ ne doit pas être vide'
                ]),
                new Length([
                    'min'        => 10,
                    'max'        => 300,
                    'minMessage' => 'Pas assez de caractères , attendu : {{ limit }}',
                    'maxMessage' => 'Trop de caractères, attendu: {{ limit }}',
                ])
            ]
        ])
        ->add('body', TextareaType::class, [
            'label'    => "Corps de la réponse",
            'attr' => ['placeholder' => "Les informations complémentaires relatives à votre réponse"],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le champ ne doit pas être vide'
                ]),
                new Length([
                    'min'        => 10,
                    'max'        => 5000,
                    'minMessage' => 'Pas assez de caractères , attendu : {{ limit }}',
                    'maxMessage' => 'Trop de caractères, attendu: {{ limit }}',
                ])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
