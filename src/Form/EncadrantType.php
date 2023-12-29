<?php

namespace App\Form;

use App\Entity\Encadrant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncadrantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEncadrant')
            ->add('prenomEncadrant')
            ->add('emailEncadrant')
            ->add('mobileEncadrant')
            ->add('cinEncadrant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Encadrant::class,
        ]);
    }
}
