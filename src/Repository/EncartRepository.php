<?php

namespace App\Repository;

use App\Entity\Encart;

/**
 * @method Encart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Encart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Encart[]    findAll()
 * @method Encart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncartRepository extends AbstractRepository
{
    protected $entityClass = Encart::class;
    protected $tableAlias = 'encart';
}
