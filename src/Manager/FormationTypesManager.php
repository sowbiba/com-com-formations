<?php

namespace App\Manager;

use App\Entity\FormationType;
use Doctrine\ORM\EntityManagerInterface;

class FormationTypesManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(FormationType::class);
        parent::__construct($entityManager);
    }
}
