<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends AbstractRepository
{
    protected $entityClass = User::class;
    protected $tableAlias = 'user';
}
