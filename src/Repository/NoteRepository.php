<?php

namespace App\Repository;

use App\Entity\Crm\Note;
use App\Enum\NoteType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /** @return Note[] */
    public function findByReference(NoteType $type, string $parameterName, string $parameterValue): array
    {
        return $this->createQueryBuilder('n')
            ->where('n.type = :type')
            ->andWhere('n.parameterName = :name')
            ->andWhere('n.parameterValue = :value')
            ->setParameter('type', $type)
            ->setParameter('name', $parameterName)
            ->setParameter('value', $parameterValue)
            ->orderBy('n.entryDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
