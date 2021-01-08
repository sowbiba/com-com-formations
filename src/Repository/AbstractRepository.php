<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class AbstractRepository extends ServiceEntityRepository
{
    protected $entityClass;
    protected $tableAlias;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }

    /**
     * @param array|string[] $sortOptions
     */
    public function getSearchQueryBuilder(array $criterias = [], array $sortOptions = ['id' => 'DESC']): QueryBuilder
    {
        $qb = $this->createQueryBuilder($this->tableAlias)
            ->where($this->tableAlias.'.id IS NOT NULL')
        ;
        foreach ($criterias as $criteria => $value) {
            $qb = $qb->andWhere($this->tableAlias.".$criteria LIKE '%$value%'");
        }

        $sortField = array_keys($sortOptions)[0];
        $sortDirection = array_values($sortOptions)[0];

        $qb = $qb->orderBy($this->tableAlias.".$sortField", $sortDirection);

        return $qb;
    }
}
