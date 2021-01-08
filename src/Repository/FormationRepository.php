<?php

namespace App\Repository;

use App\Entity\Formation;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends AbstractRepository
{
    protected $entityClass = Formation::class;
    protected $tableAlias = 'formation';
}
