<?php

namespace App\Form;

use App\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('color', ChoiceType::class, [
                'multiple' => false,
                'required' => true,
                'choices' => $this->getColorChoices(),
            ])
            ->add('icon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Domain::class,
            'translation_domain' => 'messages',
        ]);
    }

    private function getColorChoices(): array
    {
        return [
            'default' => 'default',
            'blue' => 'blue',
            'blue-corporate' => 'blue-corporate',
            'blue-light' => 'blue-light',
            'blue-sky' => 'blue-sky',
            'blue-xlight' => 'blue-xlight',
            'green' => 'green',
            'green-xlight' => 'green-xlight',
            'green-xxlight' => 'green-xxlight',
            'green-dark' => 'green-dark',
            'green-xdark' => 'green-xdark',
            'orangered' => 'orangered',
            'orange' => 'orange',
            'orange-light' => 'orange-light',
            'orange-xlight' => 'orange-xlight',
            'pink' => 'pink',
            'pink-light' => 'pink-light',
            'pink-salmon' => 'pink-salmon',
            'purple' => 'purple',
            'purple-light' => 'purple-light',
            'red' => 'red',
            'red-corporate' => 'red-corporate',
            'turquoise' => 'turquoise',
            'turquoise-light' => 'turquoise-light',
            'yellow' => 'yellow',
            'yellow-light' => 'yellow-light',
            'brown' => 'brown',
        ];
    }
}
