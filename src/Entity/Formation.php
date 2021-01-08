<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @ORM\Table(name="formations")
 */
class Formation
{
    public const LEVEL_ALL = 1;
    public const LEVEL_INITIATION = 2;
    public const LEVEL_PERFECTIONING = 3;
    public const LEVEL_EXPERTISE = 4;
    public const LEVELS = [
        self::LEVEL_ALL,
        self::LEVEL_INITIATION,
        self::LEVEL_PERFECTIONING,
        self::LEVEL_EXPERTISE,
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=FormationType::class, inversedBy="formations")
     * @ORM\JoinColumn(nullable=false, name="formation_type_id", referencedColumnName="id")
     */
    private $formationType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $program;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $extras;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pedagogicMeans;

    /**
     * @ORM\OneToMany(targetEntity=FormationSection::class, mappedBy="formation", orphanRemoval=true, cascade="persist", fetch="EAGER")
     */
    private $formationSections;

    /**
     * @ORM\ManyToMany(targetEntity=Intervenant::class, inversedBy="formations")
     * @ORM\JoinTable(name="formation_intervenants")
     */
    private $intervenants;

    /**
     * @ORM\OneToMany(targetEntity=FormationDate::class, mappedBy="formation", orphanRemoval=true, cascade="persist")
     */
    private $formationDates;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, inversedBy="formationLinked")
     * @ORM\JoinTable(
     *     name="formation_linked",
     *     joinColumns={@ORM\JoinColumn(name="formation_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="linked_formation_id", referencedColumnName="id")}
     * )
     */
    private $formationLinkeds;

    /**
     * @ORM\ManyToMany(targetEntity=Domain::class, inversedBy="formations")
     * @ORM\JoinTable(name="formation_domains")
     */
    private $domains;

    /**
     * @ORM\OneToMany(targetEntity=FormationFile::class, mappedBy="formation", orphanRemoval=true, cascade="persist")
     */
    private $formationFiles;

    public function __construct()
    {
        $this->formationSections = new ArrayCollection();
        $this->intervenants = new ArrayCollection();
        $this->domains = new ArrayCollection();
        $this->formationDates = new ArrayCollection();
        $this->formationLinkeds = new ArrayCollection();
        $this->formationFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormationType(): ?FormationType
    {
        return $this->formationType;
    }

    public function setFormationType(FormationType $formationType): self
    {
        $this->formationType = $formationType;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->slug = mb_strtolower((new AsciiSlugger('fr'))->slug($title)->toString());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     *
     * @return Formation
     */
    public function setReference($reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     *
     * @return Formation
     */
    public function setLevel($level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     * @return Formation
     */
    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(?string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getExtras(): ?string
    {
        return $this->extras;
    }

    public function setExtras(?string $extras): self
    {
        $this->extras = $extras;

        return $this;
    }

    public function getPedagogicMeans(): ?string
    {
        return $this->pedagogicMeans;
    }

    public function setPedagogicMeans(?string $pedagogic_means): self
    {
        $this->pedagogicMeans = $pedagogic_means;

        return $this;
    }

    /**
     * @return Collection|FormationSection[]
     */
    public function getFormationSections(): Collection
    {
        return $this->formationSections;
    }

    public function addFormationSection(FormationSection $formationSection): self
    {
        $found = false;
        $newFormationSections = [];
        /**
         * @var FormationSection $existingFormationSection
         */
        foreach ($this->formationSections as $existingFormationSection) {
            if ($existingFormationSection->equals($formationSection)) {
                $found = true;
                $existingFormationSection->setSectionOrder($formationSection->getSectionOrder());
                $existingFormationSection->setContent($formationSection->getContent());
            }

            $newFormationSections[] = $existingFormationSection;
        }

        if (!$found) {
            $formationSection->setFormation($this);
            $newFormationSections[] = $formationSection;
        }

        $this->formationSections = $newFormationSections;

        return $this;
    }

    public function removeFormationSection(FormationSection $formationSection): self
    {
        if ($this->formationSections->removeElement($formationSection)) {
            // set the owning side to null (unless already changed)
            if ($formationSection->getFormation() === $this) {
                $formationSection->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intervenant[]
     */
    public function getIntervenants(): Collection
    {
        return $this->intervenants;
    }

    public function addIntervenant(Intervenant $intervenant): self
    {
        if (!$this->intervenants->contains($intervenant)) {
            $this->intervenants[] = $intervenant;
            $intervenant->addFormation($this);
        }

        return $this;
    }

    public function removeIntervenant(Intervenant $intervenant): self
    {
        if ($this->intervenants->removeElement($intervenant)) {
            if ($intervenant->getFormations()->contains($this)) {
                $intervenant->removeFormation($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FormationDate[]
     */
    public function getFormationDates(): Collection
    {
        return $this->formationDates;
    }

    public function addFormationDate(FormationDate $formationDate): self
    {
        if (!$this->formationDates->contains($formationDate)) {
            $this->formationDates[] = $formationDate;
            $formationDate->setFormation($this);
        }

        return $this;
    }

    public function removeFormationDate(FormationDate $formationDate): self
    {
        if ($this->formationDates->removeElement($formationDate)) {
            // set the owning side to null (unless already changed)
            if ($formationDate->getFormation() === $this) {
                $formationDate->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormationLinkeds(): Collection
    {
        return $this->formationLinkeds;
    }

    public function addFormationLinked(Formation $formationLinked): self
    {
        if (!$this->formationLinkeds->contains($formationLinked)) {
            $this->formationLinkeds[] = $formationLinked;
            $formationLinked->addFormationLinked($this);
        }

        return $this;
    }

    public function removeFormationLinked(Formation $formationLinked): self
    {
        if ($this->formationLinkeds->contains($formationLinked)) {
            if ($this->formationLinkeds->removeElement($formationLinked)) {
                $formationLinked->removeFormationLinked($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Domain[]
     */
    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain)) {
            $this->domains[] = $domain;
            $domain->addFormation($this);
        }

        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->removeElement($domain)) {
            if ($domain->getFormations()->contains($this)) {
                $domain->removeFormation($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FormationFile[]
     */
    public function getFormationFiles(): Collection
    {
        return $this->formationFiles;
    }

    public function addFormationFile(FormationFile $formationFile): self
    {
        if (!$this->formationFiles->contains($formationFile)) {
            $this->formationFiles[] = $formationFile;
            $formationFile->setFormation($this);
        }

        return $this;
    }

    public function removeFormationFile(FormationFile $formationFile): self
    {
        if ($this->formationFiles->removeElement($formationFile)) {
            // set the owning side to null (unless already changed)
            if ($formationFile->getFormation() === $this) {
                $formationFile->setFormation(null);
            }
        }

        return $this;
    }
}
