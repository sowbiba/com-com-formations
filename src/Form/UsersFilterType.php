<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('enabled', CheckboxType::class, ['required' => false])
            ->add('is_verified', CheckboxType::class, ['required' => false])
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        Role::ROLE_ADMIN => Role::ROLE_ADMIN,
                        Role::ROLE_SUPER_ADMIN => Role::ROLE_SUPER_ADMIN,
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
