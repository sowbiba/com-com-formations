<?php

namespace App\Manager;

use App\Entity\Home;
use Doctrine\ORM\EntityManagerInterface;

class HomeManager extends AbstractObjectManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Home::class);
        parent::__construct($entityManager);
    }
}
