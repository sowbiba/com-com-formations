<?php

namespace App\Manager;

use App\Entity\Intervenant;
use Doctrine\ORM\EntityManagerInterface;

class IntervenantsManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Intervenant::class);
        parent::__construct($entityManager);
    }
}
