<?php

namespace Nekland\NekoWiki\Entity\User;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    /**
     * @param  string $role
     * @return Role
     */
    public function getRole($role)
    {
        $roleEntity = $this->findOneBy(['name' => $role]);

        if (!$roleEntity) {

            return new Role($role);
        } else {

            return $roleEntity;
        }
    }
}
