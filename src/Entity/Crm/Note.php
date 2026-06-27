<?php

namespace App\Entity\Crm;

use App\Enum\NoteType;
use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\Table(name: 'notes')]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'notesId')]
    private ?int $notesId = null;

    #[ORM\Column(length: 20, nullable: true, enumType: NoteType::class)]
    private ?NoteType $type = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'entryDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $entryDate = null;

    #[ORM\Column(name: 'parameterName', length: 20, nullable: true)]
    private ?string $parameterName = null;

    #[ORM\Column(name: 'parameterValue', length: 20, nullable: true)]
    private ?string $parameterValue = null;

    public function getNotesId(): ?int
    {
        return $this->notesId;
    }

    public function getType(): ?NoteType
    {
        return $this->type;
    }

    public function setType(?NoteType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(?\DateTimeInterface $entryDate): static
    {
        $this->entryDate = $entryDate;

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
}
