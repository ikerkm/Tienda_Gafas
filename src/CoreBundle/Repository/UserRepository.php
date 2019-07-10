<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.mail = :mail')
            ->setParameter('mail', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
