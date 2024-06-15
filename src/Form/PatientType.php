<?php
namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Infirmier;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use App\Form\Transformer\ImageFileTransformer;

class PatientType extends AbstractType
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
                            'min' => 3,
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
                        'placeholder' => 'Entrez le nom du patient',
                    ],
                ])
            ->add('prenom', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom.',
                    ]),
                    new Length([
                        'min' => 3,
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
                    'placeholder' => 'Entrez le prénom du patient',
                ],
            ])
            ->add('date_de_naissance', BirthdayType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une date de naissance.',
                    ]),
                ],
            ])
            ->add('adresse', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse.',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'L\'adresse doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'adresse ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez l\'adresse du patient',
                ],
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
                    'placeholder' => 'Entrez le numéro de téléphone du patient',
                ],
            ])
            ->add('infirmier', EntityType::class, [
                'class' => Infirmier::class,
                'choice_label' => function ($infirmier) {
                    return $infirmier->getId().' - '.$infirmier->getNom();
                },
                'placeholder' => 'Sélectionnez un Infirmier',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un infirmier.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Sélectionnez un infirmier',
                ],
            ])
            ->add('genre', ChoiceType::class, [
                'choices'  => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'expanded' => true,
                'multiple' => false,    
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'accept' => 'image/*',
                ],
                'empty_data' => '', // Ajoutez cette option pour éviter une erreur de type
            ])
            ;

            $builder->get('image')->addModelTransformer(new ImageFileTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}