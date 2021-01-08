<?php

namespace App\Manager;

use App\Entity\Encart;
use Doctrine\ORM\EntityManagerInterface;

class EncartsManager extends AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Encart::class);
        parent::__construct($entityManager);
    }
}
