<?php

namespace App\Repository;

use App\Entity\Role;

class RoleRepository extends AbstractRepository
{
    protected $entityClass = Role::class;
    protected $tableAlias = 'role';
}
