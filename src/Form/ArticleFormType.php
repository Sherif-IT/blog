<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Form\CategorieFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'titre',
                TextType::class,
                [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-control-lg p-4', 'cols'=> 100,'rows'=> 1000, 'placeholder'=>  'Title']
                        ]
                )  
            ->add('categories', EntityType::class, [
                    'class' => Categorie::class,
                    'attr'  => ['class' => 'custom-select custom-select-lg multiple ml-3'],
                    'choice_label' =>  'categorie',
                    'label' => 'Choisir une categorie',
                     'multiple' => true,
                     'expanded' => false,
                ])
            ->add(
                'contenu',
                TextareaType::class,
                [
                    'constraints' => [new NotBlank()],
                    'label' => false,
                    'attr' => ['class' => 'form-control','cols'=> 1000 , 'rows' => 10,   'hidden'=>'hidden']
                        ]
            
                )
                
                /*->add(
                    'image',
                     FileType::class,[
                     
                     'label' => 'Image',
                     
                     'attr' => ['id'=>'uploadImage'],

                     // unmapped means that this field is not associated to any entity property
                     'mapped' => false,
     
                     // make it optional so you don't have to re-upload the PDF file
                     // every time you edit the Product details
                     'required' => false,
                     ])*/
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => ['class' => 'form-submit',"hidden"=>"hidden"],
                    'label' => 'Submit your article!'
                ]
                );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}