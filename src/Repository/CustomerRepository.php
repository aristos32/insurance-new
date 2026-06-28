<?php

namespace App\Repository;

use App\Entity\Crm\Customer;
use App\Enum\CustomerType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /** @return Customer[] */
    public function search(?string $query, ?CustomerType $type = null, int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.lastName', 'ASC')
            ->addOrderBy('c.firstName', 'ASC')
            ->setMaxResults($limit);

        if ($query !== null && $query !== '') {
            $qb->andWhere('c.stateId LIKE :q OR c.firstName LIKE :q OR c.lastName LIKE :q OR c.email LIKE :q')
                ->setParameter('q', '%' . $query . '%');
        }

        if ($type !== null) {
            $qb->andWhere('c.type = :type')->setParameter('type', $type);
        }

        return $qb->getQuery()->getResult();
    }
}
