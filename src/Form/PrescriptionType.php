<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Prescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicament', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une medicament'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' =>  'Le medicament doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le medicament ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^\P{N}+$/u',
                        'message' => 'Le medicament ne peut pas contenir de chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez le nom de votre médicament'
                ]
            ])

            ->add('posologie', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une posologie'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' =>  'Le posologie doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le posologie ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^\P{N}+$/u',
                        'message' => 'Le psologie ne peut pas contenir de chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez le nom de la posologie'
                ]
            ])
            ->add('consultation', EntityType::class, [
                'class' => Consultation::class,
                'choice_label' => function($consultation) {
                    return 'N°'.$consultation->getId().'  du : '.$consultation->getDate()->format('Y-m-d');
                },
                'placeholder' => 'Choix du date de Consultation',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
