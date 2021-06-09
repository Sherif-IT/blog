<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Persistence\ObjectManager;

class CategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorie', EntityType::class, [
            'class' => Categorie::class,
            'attr'  => ['class' => 'custom-select custom-select-lg multiple ml-3'],
            'choice_label' => function ($categories) {
                return $categories->getCategorie();
            },
            'label' => 'Choisir une categorie',
            
             'multiple' => false,
             'expanded' => false,
        ])
        ->add(
            'submit',
            SubmitType::class,
            [
                'attr' => ['class' => 'form-submit'],
                'label' => 'Valider categorie!'
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
