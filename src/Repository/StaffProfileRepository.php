<?php

namespace App\Repository;

use App\Entity\Crm\StaffProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StaffProfile>
 */
class StaffProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaffProfile::class);
    }

    /** @return StaffProfile[] */
    public function search(?string $query, int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.lastName', 'ASC')
            ->setMaxResults($limit);

        if ($query) {
            $qb->andWhere('s.username LIKE :q OR s.firstName LIKE :q OR s.lastName LIKE :q OR s.email LIKE :q')
                ->setParameter('q', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
