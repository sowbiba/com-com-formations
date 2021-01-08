<?php

namespace App\Manager;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AbstractObjectManager
{
    const PAGE_LIMIT = 10;

    /** @var ServiceEntityRepository */
    protected $repository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save($object): void
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    public function delete($object)
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function search(array $criterias = [], $sortOptions = ['id' => 'DESC'], $page = 1): Pagerfanta
    {
        $qb = $this->repository->getSearchQueryBuilder($criterias, $sortOptions);

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::PAGE_LIMIT);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

    public function find(array $criterias = [], $sortOptions = ['id' => 'DESC'], $page = 1): array
    {
        /**
         * @var QueryBuilder $qb
         */
        $qb = $this->repository->getSearchQueryBuilder($criterias, $sortOptions);

        return $qb->getQuery()->getResult();
    }

    public function findById(int $id)
    {
        return $this->repository->find($id);
    }
}
