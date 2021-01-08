<?php

namespace App\Repository;

use App\Entity\FormationSection;

/**
 * @method FormationSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationSection[]    findAll()
 * @method FormationSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationSectionRepository extends AbstractRepository
{
    protected $entityClass = FormationSection::class;
    protected $tableAlias = 'formationSections';
}
