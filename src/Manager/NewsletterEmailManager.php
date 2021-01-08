<?php

namespace App\Manager;

use App\Entity\NewsletterEmail;
use Doctrine\ORM\EntityManagerInterface;

class NewsletterEmailManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(NewsletterEmail::class);
        parent::__construct($entityManager);
    }
}
