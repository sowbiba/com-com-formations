<?php

namespace App\Manager;

use App\Entity\Domain;
use Doctrine\ORM\EntityManagerInterface;

class DomainsManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Domain::class);
        parent::__construct($entityManager);
    }
}
