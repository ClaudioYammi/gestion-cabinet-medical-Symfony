<?php
namespace App\Form;

use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^\P{N}+$/u',
                        'message' => 'Le nom ne peut pas contenir de chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ]
            ])
            ->add('prenom', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^\P{N}+$/u',
                        'message' => 'Le prénom ne peut pas contenir de chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
                ]
            ])
            ->add('specialiter', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une spécialité.',
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 255,
                        'minMessage' => 'La specialiter doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La specialiter ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^\P{N}+$/u',
                        'message' => 'La specialiter ne peut pas contenir de chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre spécialiter'
                ]
            ])
            ->add('telephone', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de téléphone.',
                    ]),
                    new Length([
                        'min' => 9,
                        'max' => 9,
                        'exactMessage' => 'Le numéro de téléphone doit contenir exactement {{ limit }} chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'ex: 38 65 789 52'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}