<?php

namespace App\Entity\Crm;

use App\Repository\QuotationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotationRepository::class)]
#[ORM\Table(name: 'quotation')]
class Quotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'quoteId')]
    private ?int $quoteId = null;

    #[ORM\Column(name: 'canProvideOnlineQuote', length: 5, nullable: true)]
    private ?string $canProvideOnlineQuote = null;

    #[ORM\Column(name: 'entryDate', type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $entryDate;

    #[ORM\Column(name: 'quoteAmount')]
    private int $quoteAmount = 0;

    #[ORM\Column(name: 'insuranceCompanyOfferingQuote', length: 50, nullable: true)]
    private ?string $insuranceCompanyOfferingQuote = null;

    #[ORM\Column(name: 'coverageType', length: 50, nullable: true)]
    private ?string $coverageType = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $username = null;

    public function __construct()
    {
        $this->entryDate = new \DateTime();
    }

    public function getQuoteId(): ?int
    {
        return $this->quoteId;
    }

    public function getEntryDate(): \DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(\DateTimeInterface $entryDate): static
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getQuoteAmount(): int
    {
        return $this->quoteAmount;
    }

    public function setQuoteAmount(int $quoteAmount): static
    {
        $this->quoteAmount = $quoteAmount;

        return $this;
    }

    public function getCoverageType(): ?string
    {
        return $this->coverageType;
    }

    public function setCoverageType(?string $coverageType): static
    {
        $this->coverageType = $coverageType;

        return $this;
    }
}
