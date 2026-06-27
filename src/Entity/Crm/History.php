<?php

namespace App\Entity\Crm;

use App\Enum\HistoryType;
use App\Repository\HistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ORM\Table(name: 'history')]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'historyId')]
    private ?int $historyId = null;

    #[ORM\Column(name: 'transDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $transDate = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 30, nullable: true, enumType: HistoryType::class)]
    private ?HistoryType $type = null;

    #[ORM\Column(name: 'subType', length: 30, nullable: true)]
    private ?string $subType = null;

    #[ORM\Column(name: 'parameterName', length: 20, nullable: true)]
    private ?string $parameterName = null;

    #[ORM\Column(name: 'parameterValue', length: 20, nullable: true)]
    private ?string $parameterValue = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $note = null;

    public function getHistoryId(): ?int
    {
        return $this->historyId;
    }

    public function getTransDate(): ?\DateTimeInterface
    {
        return $this->transDate;
    }

    public function setTransDate(?\DateTimeInterface $transDate): static
    {
        $this->transDate = $transDate;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getType(): ?HistoryType
    {
        return $this->type;
    }

    public function setType(?HistoryType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSubType(): ?string
    {
        return $this->subType;
    }

    public function setSubType(?string $subType): static
    {
        $this->subType = $subType;

        return $this;
    }

    public function getParameterName(): ?string
    {
        return $this->parameterName;
    }

    public function setParameterName(?string $parameterName): static
    {
        $this->parameterName = $parameterName;

        return $this;
    }

    public function getParameterValue(): ?string
    {
        return $this->parameterValue;
    }

    public function setParameterValue(?string $parameterValue): static
    {
        $this->parameterValue = $parameterValue;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }
}
