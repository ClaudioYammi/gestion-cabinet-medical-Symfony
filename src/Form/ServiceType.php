<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Patient; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom'
                    ]),
                    new Length([
                        'min'=> 3,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',

                        'max' => 50,
                        'maxMessage' => 'Le nom doit pas contenir plus de {{ limit }} caractères.',
                        ])
                    ],
                    ])
                    ->add('description', null, [
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Veuillez saisir un nom'
                            ]),
                            new Length([
                                'min'=> 5,
                                'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                                
                                'max' => 50,
                                'maxMessage' => 'La description doit pas contenir plus de {{ limit }} caractères.',
                    ])
                ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
