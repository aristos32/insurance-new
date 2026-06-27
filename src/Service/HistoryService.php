<?php

namespace App\Service;

use App\Entity\Crm\History;
use App\Enum\HistoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class HistoryService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security,
    ) {
    }

    public function log(
        HistoryType $type,
        string $subType,
        string $parameterName,
        string $parameterValue,
        string $note,
    ): History {
        $history = (new History())
            ->setType($type)
            ->setSubType($subType)
            ->setParameterName($parameterName)
            ->setParameterValue($parameterValue)
            ->setNote($note)
            ->setTransDate(new \DateTime())
            ->setUsername($this->security->getUser()?->getUserIdentifier());

        $this->entityManager->persist($history);

        return $history;
    }
}
