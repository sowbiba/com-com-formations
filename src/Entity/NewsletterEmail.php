<?php

namespace App\Entity;

use App\Repository\NewsletterEmailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterEmailRepository::class)
 * @ORM\Table(name="newsletter_emails")
 */
class NewsletterEmail
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
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscribedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $unsubscribedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubscribedAt(): ?\DateTimeInterface
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(\DateTimeInterface $subscribedAt): self
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    public function getUnsubscribedAt(): ?\DateTimeInterface
    {
        return $this->unsubscribedAt;
    }

    public function setUnsubscribedAt(?\DateTimeInterface $unsubscribedAt): self
    {
        $this->unsubscribedAt = $unsubscribedAt;

        return $this;
    }
}
