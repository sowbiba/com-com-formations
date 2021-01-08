<?php

namespace App\DTO;

use App\Entity\Domain;
use App\Entity\Formation as FormationEntity;
use App\Entity\FormationDate;
use App\Entity\FormationFile;
use App\Entity\FormationSection;
use App\Entity\FormationType;
use App\Entity\Intervenant;
use Doctrine\Common\Collections\Collection;

class Formation
{
    /**
     * @var FormationEntity
     */
    private $formation;

    public function __construct(FormationEntity $formation)
    {
        $this->formation = $formation;
    }

    public function getId(): ?int
    {
        return $this->formation->getId();
    }

    public function getFormationType(): ?FormationType
    {
        return $this->formation->getFormationType();
    }

    public function getTitle(): ?string
    {
        return $this->formation->getTitle();
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->formation->getSlug();
    }

    public function getProgram(): ?string
    {
        return $this->formation->getProgram();
    }

    public function getExtras(): ?string
    {
        return $this->formation->getExtras();
    }

    public function getPedagogicMeans(): ?string
    {
        return $this->formation->getPedagogicMeans();
    }

    /**
     * @return Collection|FormationSection[]
     */
    public function getFormationSections(): Collection
    {
        return $this->formation->getFormationSections();
    }

    /**
     * @return Collection|FormationFile[]
     */
    public function getFormationFiles(): Collection
    {
        return $this->formation->getFormationFiles();
    }

    /**
     * @return Collection|Intervenant[]
     */
    public function getIntervenants(): Collection
    {
        return $this->formation->getIntervenants();
    }

    public function getFormationDates(): array
    {
        $eLearningDates = [];
        $regularDates = [];

        /**
         * @var FormationDate $formationDate
         */
        foreach ($this->formation->getFormationDates()->toArray() as $formationDate) {
            if ($formationDate->getELearning()) {
                $eLearningDates[] = $formationDate;
            } else {
                $regularDates[] = $formationDate;
            }
        }

        uasort($eLearningDates, function (FormationDate $formationDate1, FormationDate $formationDate2) {
            $datetime1 = \DateTime::createFromFormat('d/m/Y', $formationDate1->getDate());
            $datetime2 = \DateTime::createFromFormat('d/m/Y', $formationDate2->getDate());

            return $datetime1 > $datetime2;
        });
        uasort($regularDates, function (FormationDate $formationDate1, FormationDate $formationDate2) {
            $datetime1 = \DateTime::createFromFormat('d/m/Y', $formationDate1->getDate());
            $datetime2 = \DateTime::createFromFormat('d/m/Y', $formationDate2->getDate());

            return $datetime1 > $datetime2;
        });

        return [
            'eLearning' => $eLearningDates,
            'regular' => $regularDates,
        ];
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormationLinkeds(): Collection
    {
        return $this->formation->getFormationLinkeds();
    }

    /**
     * @return Collection|Domain[]
     */
    public function getDomains(): Collection
    {
        return $this->formation->getDomains();
    }

    public function getExcerpt(): string
    {
        $formationSections = $this->getFormationSections()->toArray();
        uasort($formationSections, function (FormationSection $section1, FormationSection $section2) {
            return $section1->getSectionOrder() > $section2->getSectionOrder();
        });

        /** @var FormationSection $firstFormationSection */
        $firstFormationSection = reset($formationSections);

        if ($firstFormationSection) {
            return $firstFormationSection->getContent();
        }

        return '';
    }

    public function getReference()
    {
        return $this->formation->getReference();
    }

    public function getLevelLabel()
    {
        switch ($this->formation->getLevel()) {
            case FormationEntity::LEVEL_INITIATION:
                return 'LEVEL_INITIATION';
            case FormationEntity::LEVEL_PERFECTIONING:
                return 'LEVEL_PERFECTIONING';
            case FormationEntity::LEVEL_EXPERTISE:
                return 'LEVEL_EXPERTISE';
            default:
                return 'LEVEL_ALL';
        }
    }

    public function getDuration()
    {
        return $this->formation->getDuration();
    }
}
