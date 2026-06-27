<?php

namespace App\Entity\Crm;

use App\Repository\ClaimRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClaimRepository::class)]
#[ORM\Table(name: 'claims')]
class Claim
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'claimId')]
    private ?int $claimId = null;

    #[ORM\Column(name: 'quoteId', nullable: true)]
    private ?int $quoteId = null;

    #[ORM\Column]
    private int $amount = 0;

    #[ORM\Column(name: 'claimDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $claimDate = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'claims')]
    #[ORM\JoinColumn(name: 'stateId', referencedColumnName: 'stateId', nullable: true, onDelete: 'CASCADE')]
    private ?Owner $owner = null;

    public function getClaimId(): ?int
    {
        return $this->claimId;
    }

    public function getQuoteId(): ?int
    {
        return $this->quoteId;
    }

    public function setQuoteId(?int $quoteId): static
    {
        $this->quoteId = $quoteId;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getClaimDate(): ?\DateTimeInterface
    {
        return $this->claimDate;
    }

    public function setClaimDate(?\DateTimeInterface $claimDate): static
    {
        $this->claimDate = $claimDate;

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

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
