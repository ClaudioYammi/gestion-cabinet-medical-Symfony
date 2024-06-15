<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de téléphone.',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 9,
                        'exactMessage' => 'Le numéro de téléphone doit contenir exactement {{ limit }} chiffres.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez le numéro ',
                ],
            ])
            ->add('etage')
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => function($service) {
                    return $service->getId().' - '.$service->getNom();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
