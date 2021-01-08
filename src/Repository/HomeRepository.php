<?php

namespace App\Repository;

use App\Entity\Home;

/**
 * @method Home|null find($id, $lockMode = null, $lockVersion = null)
 * @method Home|null findOneBy(array $criteria, array $orderBy = null)
 * @method Home[]    findAll()
 * @method Home[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeRepository extends AbstractRepository
{
    protected $entityClass = Home::class;
    protected $tableAlias = 'home';
}