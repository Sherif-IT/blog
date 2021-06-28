<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            'tag',
            TextType::class,
            [
                'constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control form-control-lg p-4', 'cols'=> 50,'rows'=> 1000, 'placeholder'=>  'Title']
                    ]
            )  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
