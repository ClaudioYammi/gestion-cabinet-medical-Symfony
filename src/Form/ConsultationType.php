<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Medecin;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => function ($patient) {
                    return $patient->getId() . ' - ' . $patient->getNom();
                },
                'placeholder' => 'Sélectionnez un patient', // Optionnel : affiche un libellé vide pour le choix initial
            ])

            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function ($medecin) {
                    return $medecin->getId() . ' - ' .$medecin->getNom();
                },
                'placeholder' => 'Sélectionnez un medecin', 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
