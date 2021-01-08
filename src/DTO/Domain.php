<?php

namespace App\DTO;

use App\Entity\Domain as DomainEntity;

class Domain
{
    /**
     * @var DomainEntity
     */
    private $domain;

    public function __construct(DomainEntity $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return array
     */
    public function getFormations(): array
    {
        $formations = [];

        foreach ($this->domain->getFormations()->toArray() as $formationEntity) {
            $formations[] = new Formation($formationEntity);
        }

        return $formations;
    }
}
