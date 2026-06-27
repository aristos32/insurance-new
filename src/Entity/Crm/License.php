<?php

namespace App\Entity\Crm;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'license')]
class License
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'licenseType', length: 30, nullable: true)]
    private ?string $licenseType = null;

    #[ORM\Column(name: 'licenseDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $licenseDate = null;

    #[ORM\Column(name: 'licenseCountry', length: 50, nullable: true)]
    private ?string $licenseCountry = null;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'licenses')]
    #[ORM\JoinColumn(name: 'stateId', referencedColumnName: 'stateId', nullable: false, onDelete: 'CASCADE')]
    private ?Owner $owner = null;

    public function getLicenseType(): ?string
    {
        return $this->licenseType;
    }

    public function setLicenseType(?string $licenseType): static
    {
        $this->licenseType = $licenseType;

        return $this;
    }

    public function getLicenseDate(): ?\DateTimeInterface
    {
        return $this->licenseDate;
    }

    public function setLicenseDate(?\DateTimeInterface $licenseDate): static
    {
        $this->licenseDate = $licenseDate;

        return $this;
    }

    public function getLicenseCountry(): ?string
    {
        return $this->licenseCountry;
    }

    public function setLicenseCountry(?string $licenseCountry): static
    {
        $this->licenseCountry = $licenseCountry;

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
