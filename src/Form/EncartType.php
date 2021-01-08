<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Encart;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('image', FileType::class, [
                'data_class' => null,
                'required' => false,
            ])
            ->add('imageSubtitle', TextType::class, [
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce',
                ],
            ])
            ->add('buttonText', TextType::class, [
                'required' => false,
            ])
            ->add('buttonLink', TextType::class, [
                'required' => false,
            ])
            ->add('domain', EntityType::class, [
                'class' => Domain::class,
                'choice_label' => 'title',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Encart::class,
            'translation_domain' => 'messages',
        ]);
    }
}
