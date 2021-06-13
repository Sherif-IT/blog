<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu',
                TextareaType::class,
                [
                    'constraints' => [new NotBlank()],
                    'label' => 'Ajouter un commentaire',
                    'label_attr' => ['class'=> 'mt-4'],
                    'attr' => ['class' => 'form-control ','cols'=> 100, 'rows' => 5 ]
                        ]
                )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => ['class' => 'form-submit mt-3'],
                    'label' => 'Submit your comment!'
                ]
                ) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
