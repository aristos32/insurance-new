<?php

namespace App\Repository;

use App\Entity\Crm\Sale;
use App\Enum\InsuranceType;
use App\Enum\SaleStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    /** @return Sale[] */
    public function search(?string $query, ?InsuranceType $type = null, ?SaleStatus $status = null, int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.customer', 'c')
            ->addSelect('c')
            ->orderBy('s.startDate', 'DESC')
            ->setMaxResults($limit);

        if ($type) {
            $qb->andWhere('s.insuranceType = :type')->setParameter('type', $type);
        }

        if ($status) {
            $qb->andWhere('s.status = :status')->setParameter('status', $status);
        }

        if ($query) {
            $qb->andWhere('s.saleId LIKE :q OR s.company LIKE :q OR c.firstName LIKE :q OR c.lastName LIKE :q')
                ->setParameter('q', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }

    /** @return Sale[] */
    public function findExpiringBetween(\DateTimeInterface $from, \DateTimeInterface $to): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.customer', 'c')
            ->addSelect('c')
            ->where('s.endDate BETWEEN :from AND :to')
            ->andWhere('s.status = :status')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('status', SaleStatus::Active)
            ->orderBy('s.endDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** @return Sale[] */
    public function findWithBalance(): array
    {
        $sales = $this->createQueryBuilder('s')
            ->leftJoin('s.customer', 'c')
            ->addSelect('c')
            ->leftJoin('s.transactions', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult();

        return array_values(array_filter($sales, static fn (Sale $sale): bool => $sale->getCurrentBalance() > 0));
    }
}
