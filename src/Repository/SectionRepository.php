<?php

namespace App\Repository;

use App\Entity\Section;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends AbstractRepository
{
    protected $entityClass = Section::class;
    protected $tableAlias = 'section';
}
