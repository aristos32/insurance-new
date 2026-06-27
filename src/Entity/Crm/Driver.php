<?php

namespace App\Entity\Crm;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'drivers')]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'driverId')]
    private ?int $driverId = null;

    #[ORM\Column(name: 'stateId', length: 20)]
    private string $stateId = '';

    #[ORM\Column(name: 'firstName', length: 70, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'lastName', length: 70, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(name: 'countryOfBirth', length: 30, nullable: true)]
    private ?string $countryOfBirth = null;

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(name: 'licenseCountry', length: 50, nullable: true)]
    private ?string $licenseCountry = null;

    #[ORM\Column(name: 'licenseDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $licenseDate = null;

    #[ORM\Column(name: 'licenseType', length: 30, nullable: true)]
    private ?string $licenseType = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'drivers')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', nullable: false, onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getDriverId(): ?int
    {
        return $this->driverId;
    }

    public function getStateId(): string
    {
        return $this->stateId;
    }

    public function setStateId(string $stateId): static
    {
        $this->stateId = $stateId;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return trim(($this->firstName ?? '') . ' ' . ($this->lastName ?? ''));
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): static
    {
        $this->sale = $sale;

        return $this;
    }
}
