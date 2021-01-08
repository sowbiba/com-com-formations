<?php

namespace App\Repository;

use App\Entity\FormationDate;

/**
 * @method FormationDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationDate[]    findAll()
 * @method FormationDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationDateRepository extends AbstractRepository
{
    protected $entityClass = FormationDate::class;
    protected $tableAlias = 'formationDates';
}
