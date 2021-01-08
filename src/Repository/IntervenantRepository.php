<?php

namespace App\Repository;

use App\Entity\Intervenant;

/**
 * @method Intervenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervenant[]    findAll()
 * @method Intervenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervenantRepository extends AbstractRepository
{
    protected $entityClass = Intervenant::class;
    protected $tableAlias = 'intervenant';
}
