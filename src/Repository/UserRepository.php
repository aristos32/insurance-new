<?php

namespace App\Repository;

use App\Entity\Crm\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /** @return User[] */
    public function search(?string $query, int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC')
            ->setMaxResults($limit);

        if ($query !== null && $query !== '') {
            $qb->andWhere('u.username LIKE :q OR u.firstName LIKE :q OR u.lastName LIKE :q OR u.email LIKE :q')
                ->setParameter('q', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
