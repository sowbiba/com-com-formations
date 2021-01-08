<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Encart;
use App\Entity\Home;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mainTitle')
            ->add('mainSubtitle')
            ->add('mainButtonText')
            ->add('mainButtonLink')
            ->add('boxOneTitle')
            ->add('boxOneContent')
            ->add('boxTwoTitle')
            ->add('boxTwoContent')
            ->add('boxThreeTitle')
            ->add('boxThreeContent')
            ->add('boxFourTitle')
            ->add('boxFourContent')
            ->add('middleBlockTitle')
            ->add('middleBlockSubtitle')
            ->add('middleBlockBoxOneIcon')
            ->add('middleBlockBoxOneTitle')
            ->add('middleBlockBoxOneContent')
            ->add('middleBlockBoxTwoIcon')
            ->add('middleBlockBoxTwoTitle')
            ->add('middleBlockBoxTwoContent')
            ->add('middleBlockBoxThreeIcon')
            ->add('middleBlockBoxThreeTitle')
            ->add('middleBlockBoxThreeContent')
            ->add('formationsBlockSubtitle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Home::class,
            'translation_domain' => 'messages',
        ]);
    }
}
