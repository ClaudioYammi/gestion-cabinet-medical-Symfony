<?php

namespace App\Form;

use App\Entity\Infirmier;
use App\Entity\Medecin;
use App\Entity\Planning;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')

            ->add('heure_debut')

            ->add('heure_fin')

            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function($medecin) {
                    return $medecin->getId().' - '.$medecin->getNom();
                },
                'placeholder' => 'Sélectionnez un médecin',
            ])

            ->add('infirmier', EntityType::class, [
                'class' => Infirmier::class,
                'choice_label' => function($infirmier) {
                    return $infirmier->getId().' - '.$infirmier->getNom();
                },
                'placeholder' => 'Sélectionnez un infirmier',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
