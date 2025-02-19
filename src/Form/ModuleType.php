<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom du module',
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le nom du module ne peut pas être vide.']),
                new Assert\Length([
                    'min' => 3,
                    'max' => 255,
                    'minMessage' => 'Le nom du module doit faire au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom du module ne peut pas dépasser {{ limit }} caractères.'
                ])
            ]
        ])
        ->add('content', TextareaType::class, [
            'label' => 'Contenu',
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le contenu ne peut pas être vide.']),
            ]
        ])
        ->add('difficulty', TextType::class, [
            'label' => 'Difficulté',
            'constraints' => [
                new Assert\NotBlank(['message' => 'La difficulté ne peut pas être vide.']),
            ]
        ])
        ->add('duration', IntegerType::class, [
            'label' => 'Durée',
            'constraints' => [
                new Assert\NotBlank(['message' => 'La durée ne peut pas être vide.']),
                new Assert\Type(['type' => 'integer', 'message' => 'La durée doit être un nombre entier.']),
                new Assert\GreaterThan(['value' => 0, 'message' => 'La durée doit être supérieure à 0.'])
            ]
        ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'title',
                'label' => 'Cours associé'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
