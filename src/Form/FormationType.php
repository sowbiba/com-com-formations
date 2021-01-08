<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\FormationType as FormationTypeEntity;
use App\Manager\FormationTypesManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormationType extends AbstractType
{
    /**
     * @var FormationTypesManager
     */
    private $formationTypesManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(FormationTypesManager $formationTypesManager, TranslatorInterface $translator)
    {
        $this->formationTypesManager = $formationTypesManager;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('formationType', EntityType::class, [
                'class' => FormationTypeEntity::class,
                'choice_label' => 'title',
            ])
            ->add('level', ChoiceType::class, [
                'multiple' => false,
                'choices' => [
                    $this->translator->trans('LEVEL_ALL') => Formation::LEVEL_ALL,
                    $this->translator->trans('LEVEL_INITIATION') => Formation::LEVEL_INITIATION,
                    $this->translator->trans('LEVEL_PERFECTIONING') => Formation::LEVEL_PERFECTIONING,
                    $this->translator->trans('LEVEL_EXPERTISE') => Formation::LEVEL_EXPERTISE,
                ],
            ])
            ->add('reference', TextType::class)
            ->add('duration', TextType::class)
            ->add('program', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'tinymce',
                ],
            ])
            ->add('extras', TextareaType::class, [
                'required' => false,
            ])
            ->add('pedagogicMeans', TextareaType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
            'translation_domain' => 'messages',
        ]);
    }

    private function getFormationTypes(): array
    {
        $formationTypes = [];
        /** @var \App\Entity\FormationType $formationType */
        foreach ($this->formationTypesManager->find() as $formationType) {
            $formationTypes[$formationType->getTitle()] = $formationType->getId();
        }

        return $formationTypes;
    }
}
