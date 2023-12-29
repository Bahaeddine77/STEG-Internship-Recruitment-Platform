<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomStagiaire')
            ->add('prenomStagiaire')
            ->add('brochure', FileType::class, [
                'label' => 'CV (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
                'data' => $options['current_cv_filename'],
            ])
        
            
            ->add('piece_identite')
            ->add('piece_identite', ChoiceType::class, [
                'choices' => [
                    'CIN' => 'cin',
                    'Passport' => 'passport',
                ]])
            ->add('num_piece_identite', TextType::class, [
                'constraints' => [
                    new Length(['min' => 8, 'max' => 8]),
                    new Regex([
                        'pattern' => '/^\d{8}$/',
                        'message' => 'Numéro de pièce d\'identité invalide. Veuillez saisir 8 chiffres.',
                    ]),
                ],
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ]])
            ->add('nationalite' , ChoiceType::class, [
                'choices' => [
                    'Tinisie' => 'Tunisie',
                    'Femme' => 'femme',
                ]])
            ->add('gouvernorat', ChoiceType::class, [
                    'choices' => [
                        'Tunis' => 'Tunis',
                        'Ariana' => 'Ariana',
                        'Ben Arous' => 'Ben Arous',
                        'La Manouba' => 'La Manouba',
                        'Nabeul' => 'Nabeul',
                        'Zaghouan' => 'Zaghouan',
                        'Bizerte' => 'Bizerte',
                        'Béja' => 'Béja',
                        'Jendouba' => 'Jendouba',
                        'Le Kef' => 'Le Kef',
                        'Siliana' => 'Siliana',
                        'Sousse' => 'Sousse',
                        'Monastir' => 'Monastir',
                        'Mahdia' => 'Mahdia',
                        'Sfax' => 'Sfax',
                        'Kairouan' => 'Kairouan',
                        'Kasserine' => 'Kasserine',
                        'Sidi Bouzid' => 'Sidi Bouzid',
                        'Gabès' => 'Gabès',
                        'Médenine' => 'Médenine',
                        'Tataouine' => 'Tataouine',
                        'Gafsa' => 'Gafsa',
                        'Tozeur' => 'Tozeur',
                        'Kébili' => 'Kébili',
                        // Ajoutez d'autres gouvernorats au besoin
                    ]
                ])
                

            ->add('mobile')
            ->add('diplome')
            ->add('specialite', ChoiceType::class, [
                'choices' => [
                    'Génie logiciel' => 'Génie logiciel ',
                    'Big data' => 'Big data',
                    'Réseau' => 'Réseau ',
                    'Génie Indus' => 'Génie Indus',
                ]])
            ->add('institut')
            ->add('indemnite')
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('encadrant')
            ->add('stage')
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
            'current_cv_filename' => null,
        ]);
    }
}
