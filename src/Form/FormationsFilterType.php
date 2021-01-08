<?php

namespace App\Form;

use App\Entity\FormationType;
use App\Manager\FormationTypesManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationsFilterType extends AbstractType
{
    /**
     * @var FormationTypesManager
     */
    private $formationTypesManager;

    public function __construct(FormationTypesManager $formationTypesManager)
    {
        $this->formationTypesManager = $formationTypesManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['required' => false])
            ->add('formationType', EntityType::class, [
              'class' => FormationType::class,
              'choice_label' => 'title',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }

    private function getFormationTypes(): array
    {
        $formationTypes = [];
        /** @var FormationType $formationType */
        foreach ($this->formationTypesManager->find() as $formationType) {
            $formationTypes[$formationType->getTitle()] = $formationType->getId();
        }

        return $formationTypes;
    }
}
