<?php

namespace App\Entity;

use App\Repository\HomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainSubtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainButtonText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainButtonLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boxOneTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $boxOneContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boxTwoTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $boxTwoContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boxThreeTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $boxThreeContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boxFourTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $boxFourContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockSubtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxOneIcon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxOneTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $middleBlockBoxOneContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxTwoIcon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxTwoTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $middleBlockBoxTwoContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxThreeIcon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleBlockBoxThreeTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $middleBlockBoxThreeContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $formationsBlockSubtitle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainTitle(): ?string
    {
        return $this->mainTitle;
    }

    public function setMainTitle(?string $mainTitle): self
    {
        $this->mainTitle = $mainTitle;

        return $this;
    }

    public function getMainSubtitle(): ?string
    {
        return $this->mainSubtitle;
    }

    public function setMainSubtitle(?string $mainSubtitle): self
    {
        $this->mainSubtitle = $mainSubtitle;

        return $this;
    }

    public function getMainButtonText(): ?string
    {
        return $this->mainButtonText;
    }

    public function setMainButtonText(?string $mainButtonText): self
    {
        $this->mainButtonText = $mainButtonText;

        return $this;
    }

    public function getMainButtonLink(): ?string
    {
        return $this->mainButtonLink;
    }

    public function setMainButtonLink(?string $mainButtonLink): self
    {
        $this->mainButtonLink = $mainButtonLink;

        return $this;
    }

    public function getBoxOneTitle(): ?string
    {
        return $this->boxOneTitle;
    }

    public function setBoxOneTitle(?string $boxOneTitle): self
    {
        $this->boxOneTitle = $boxOneTitle;

        return $this;
    }

    public function getBoxOneContent(): ?string
    {
        return $this->boxOneContent;
    }

    public function setBoxOneContent(?string $boxOneContent): self
    {
        $this->boxOneContent = $boxOneContent;

        return $this;
    }

    public function getBoxTwoTitle(): ?string
    {
        return $this->boxTwoTitle;
    }

    public function setBoxTwoTitle(?string $boxTwoTitle): self
    {
        $this->boxTwoTitle = $boxTwoTitle;

        return $this;
    }

    public function getBoxTwoContent(): ?string
    {
        return $this->boxTwoContent;
    }

    public function setBoxTwoContent(?string $boxTwoContent): self
    {
        $this->boxTwoContent = $boxTwoContent;

        return $this;
    }

    public function getBoxThreeTitle(): ?string
    {
        return $this->boxThreeTitle;
    }

    public function setBoxThreeTitle(?string $boxThreeTitle): self
    {
        $this->boxThreeTitle = $boxThreeTitle;

        return $this;
    }

    public function getBoxThreeContent(): ?string
    {
        return $this->boxThreeContent;
    }

    public function setBoxThreeContent(?string $boxThreeContent): self
    {
        $this->boxThreeContent = $boxThreeContent;

        return $this;
    }

    public function getBoxFourTitle(): ?string
    {
        return $this->boxFourTitle;
    }

    public function setBoxFourTitle(?string $boxFourTitle): self
    {
        $this->boxFourTitle = $boxFourTitle;

        return $this;
    }

    public function getBoxFourContent(): ?string
    {
        return $this->boxFourContent;
    }

    public function setBoxFourContent(?string $boxFourContent): self
    {
        $this->boxFourContent = $boxFourContent;

        return $this;
    }

    public function getMiddleBlockTitle(): ?string
    {
        return $this->middleBlockTitle;
    }

    public function setMiddleBlockTitle(?string $middleBlockTitle): self
    {
        $this->middleBlockTitle = $middleBlockTitle;

        return $this;
    }

    public function getMiddleBlockSubtitle(): ?string
    {
        return $this->middleBlockSubtitle;
    }

    public function setMiddleBlockSubtitle(?string $middleBlockSubtitle): self
    {
        $this->middleBlockSubtitle = $middleBlockSubtitle;

        return $this;
    }

    public function getMiddleBlockBoxOneIcon(): ?string
    {
        return $this->middleBlockBoxOneIcon;
    }

    public function setMiddleBlockBoxOneIcon(?string $middleBlockBoxOneIcon): self
    {
        $this->middleBlockBoxOneIcon = $middleBlockBoxOneIcon;

        return $this;
    }

    public function getMiddleBlockBoxOneTitle(): ?string
    {
        return $this->middleBlockBoxOneTitle;
    }

    public function setMiddleBlockBoxOneTitle(?string $middleBlockBoxOneTitle): self
    {
        $this->middleBlockBoxOneTitle = $middleBlockBoxOneTitle;

        return $this;
    }

    public function getMiddleBlockBoxOneContent(): ?string
    {
        return $this->middleBlockBoxOneContent;
    }

    public function setMiddleBlockBoxOneContent(?string $middleBlockBoxOneContent): self
    {
        $this->middleBlockBoxOneContent = $middleBlockBoxOneContent;

        return $this;
    }

    public function getMiddleBlockBoxTwoIcon(): ?string
    {
        return $this->middleBlockBoxTwoIcon;
    }

    public function setMiddleBlockBoxTwoIcon(?string $middleBlockBoxTwoIcon): self
    {
        $this->middleBlockBoxTwoIcon = $middleBlockBoxTwoIcon;

        return $this;
    }

    public function getMiddleBlockBoxTwoTitle(): ?string
    {
        return $this->middleBlockBoxTwoTitle;
    }

    public function setMiddleBlockBoxTwoTitle(?string $middleBlockBoxTwoTitle): self
    {
        $this->middleBlockBoxTwoTitle = $middleBlockBoxTwoTitle;

        return $this;
    }

    public function getMiddleBlockBoxTwoContent(): ?string
    {
        return $this->middleBlockBoxTwoContent;
    }

    public function setMiddleBlockBoxTwoContent(?string $middleBlockBoxTwoContent): self
    {
        $this->middleBlockBoxTwoContent = $middleBlockBoxTwoContent;

        return $this;
    }

    public function getMiddleBlockBoxThreeIcon(): ?string
    {
        return $this->middleBlockBoxThreeIcon;
    }

    public function setMiddleBlockBoxThreeIcon(?string $middleBlockBoxThreeIcon): self
    {
        $this->middleBlockBoxThreeIcon = $middleBlockBoxThreeIcon;

        return $this;
    }

    public function getMiddleBlockBoxThreeTitle(): ?string
    {
        return $this->middleBlockBoxThreeTitle;
    }

    public function setMiddleBlockBoxThreeTitle(?string $middleBlockBoxThreeTitle): self
    {
        $this->middleBlockBoxThreeTitle = $middleBlockBoxThreeTitle;

        return $this;
    }

    public function getMiddleBlockBoxThreeContent(): ?string
    {
        return $this->middleBlockBoxThreeContent;
    }

    public function setMiddleBlockBoxThreeContent(?string $middleBlockBoxThreeContent): self
    {
        $this->middleBlockBoxThreeContent = $middleBlockBoxThreeContent;

        return $this;
    }

    public function getFormationsBlockSubtitle(): ?string
    {
        return $this->formationsBlockSubtitle;
    }

    public function setFormationsBlockSubtitle(?string $formationsBlockSubtitle): self
    {
        $this->formationsBlockSubtitle = $formationsBlockSubtitle;

        return $this;
    }
}
