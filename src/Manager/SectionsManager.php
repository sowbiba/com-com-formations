<?php

namespace App\Manager;

use App\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;

class SectionsManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Section::class);
        parent::__construct($entityManager);
    }
}
