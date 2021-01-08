<?php

namespace App\Repository;

use App\Entity\Domain;

/**
 * @method Domain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domain[]    findAll()
 * @method Domain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomainRepository extends AbstractRepository
{
    protected $entityClass = Domain::class;
    protected $tableAlias = 'domain';
}
