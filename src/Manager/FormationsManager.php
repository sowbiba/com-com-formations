<?php

namespace App\Manager;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;

class FormationsManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Formation::class);
        parent::__construct($entityManager);
    }
}
