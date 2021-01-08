<?php

namespace App\Repository;

use App\Entity\FormationType;

/**
 * @method FormationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationType[]    findAll()
 * @method FormationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationTypeRepository extends AbstractRepository
{
    protected $entityClass = FormationType::class;
    protected $tableAlias = 'formationTypes';
}
