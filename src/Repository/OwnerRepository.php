<?php

namespace App\Repository;

use App\Entity\Crm\Owner;
use App\Enum\OwnerType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Owner>
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    /** @return Owner[] */
    public function search(?string $query, ?OwnerType $type = null, int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('o')
            ->orderBy('o.lastName', 'ASC')
            ->setMaxResults($limit);

        if ($type) {
            $qb->andWhere('o.type = :type')->setParameter('type', $type);
        }

        if ($query) {
            $qb->andWhere('o.stateId LIKE :q OR o.firstName LIKE :q OR o.lastName LIKE :q OR o.email LIKE :q OR o.telephone LIKE :q')
                ->setParameter('q', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
