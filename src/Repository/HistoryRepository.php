<?php

namespace App\Repository;

use App\Entity\Crm\History;
use App\Enum\HistoryType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<History>
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    /** @return History[] */
    public function search(?HistoryType $type = null, ?string $parameterValue = null, int $limit = 100): array
    {
        $qb = $this->createQueryBuilder('h')
            ->orderBy('h.transDate', 'DESC')
            ->setMaxResults($limit);

        if ($type) {
            $qb->andWhere('h.type = :type')->setParameter('type', $type);
        }

        if ($parameterValue) {
            $qb->andWhere('h.parameterValue LIKE :value')
                ->setParameter('value', '%' . $parameterValue . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
