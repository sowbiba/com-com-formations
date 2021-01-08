<?php

namespace App\Repository;

use App\Entity\FormationLinked;

/**
 * @method FormationLinked|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationLinked|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationLinked[]    findAll()
 * @method FormationLinked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationLinkedRepository extends AbstractRepository
{
    protected $entityClass = FormationLinked::class;
    protected $tableAlias = 'formationLinked';
}
