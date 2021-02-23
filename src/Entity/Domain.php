<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass=DomainRepository::class)
 * @ORM\Table(name="domains")
 */
class Domain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="domains", fetch="EAGER")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Encart::class, mappedBy="domain")
     */
    private $encarts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $landingText;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->encarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->addDomain($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            if ($formation->getDomains()->contains($this)) {
                $formation->removeDomain($this);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Encart[]
     */
    public function getEncarts(): Collection
    {
        return $this->encarts;
    }

    public function addEncart(Encart $encart): self
    {
        if (!$this->encarts->contains($encart)) {
            $this->encarts[] = $encart;
            $encart->setDomain($this);
        }

        return $this;
    }

    public function removeEncart(Encart $encart): self
    {
        if ($this->encarts->removeElement($encart)) {
            // set the owning side to null (unless already changed)
            if ($encart->getDomain() === $this) {
                $encart->setDomain(null);
            }
        }

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getLandingText(): ?string
    {
        return $this->landingText;
    }

    public function setLandingText(?string $landingText): self
    {
        $this->landingText = $landingText;

        return $this;
    }
}
