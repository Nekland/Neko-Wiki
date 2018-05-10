<?php

namespace Nekland\NekoWiki\Infrastructure\Persistence;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Nekland\NekoWiki\Model\User\Role;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RoleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Role::class);
    }
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
