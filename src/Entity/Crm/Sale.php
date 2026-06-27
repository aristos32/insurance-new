<?php

namespace App\Entity\Crm;

use App\Enum\InsuranceType;
use App\Enum\SaleStatus;
use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ORM\Table(name: 'sale')]
class Sale
{
    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(name: 'insuranceType', length: 50, nullable: true, enumType: InsuranceType::class)]
    private ?InsuranceType $insuranceType = null;

    #[ORM\Column(name: 'coverageType', length: 50, nullable: true)]
    private ?string $coverageType = null;

    #[ORM\Column(name: 'startDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(name: 'endDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $associate = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $producer = null;

    #[ORM\Column(length: 20, nullable: true, enumType: SaleStatus::class)]
    private ?SaleStatus $status = SaleStatus::Active;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'sales')]
    #[ORM\JoinColumn(name: 'stateId', referencedColumnName: 'stateId', nullable: false, onDelete: 'CASCADE')]
    private ?Owner $owner = null;

    /** @var Collection<int, Transaction> */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'sale', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['transDate' => 'ASC', 'transId' => 'ASC'])]
    private Collection $transactions;

    /** @var Collection<int, Driver> */
    #[ORM\OneToMany(targetEntity: Driver::class, mappedBy: 'sale', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $drivers;

    /** @var Collection<int, Vehicle> */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'sale', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $vehicles;

    /** @var Collection<int, CoverageInPolicy> */
    #[ORM\OneToMany(targetEntity: CoverageInPolicy::class, mappedBy: 'sale', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $coverages;

    #[ORM\OneToOne(targetEntity: Medical::class, mappedBy: 'sale', cascade: ['persist', 'remove'])]
    private ?Medical $medical = null;

    #[ORM\OneToOne(targetEntity: LifeIns::class, mappedBy: 'sale', cascade: ['persist', 'remove'])]
    private ?LifeIns $lifeIns = null;

    #[ORM\OneToOne(targetEntity: PropertyFire::class, mappedBy: 'sale', cascade: ['persist', 'remove'])]
    private ?PropertyFire $propertyFire = null;

    #[ORM\OneToOne(targetEntity: EmployersLiability::class, mappedBy: 'sale', cascade: ['persist', 'remove'])]
    private ?EmployersLiability $employersLiability = null;

    /** @var Collection<int, Endorsement> */
    #[ORM\OneToMany(targetEntity: Endorsement::class, mappedBy: 'sale', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $endorsements;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->drivers = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->coverages = new ArrayCollection();
        $this->endorsements = new ArrayCollection();
    }

    public function getSaleId(): string
    {
        return $this->saleId;
    }

    public function setSaleId(string $saleId): static
    {
        $this->saleId = $saleId;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getInsuranceType(): ?InsuranceType
    {
        return $this->insuranceType;
    }

    public function setInsuranceType(?InsuranceType $insuranceType): static
    {
        $this->insuranceType = $insuranceType;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAssociate(): ?string
    {
        return $this->associate;
    }

    public function setAssociate(?string $associate): static
    {
        $this->associate = $associate;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(?string $producer): static
    {
        $this->producer = $producer;

        return $this;
    }

    public function getStatus(): ?SaleStatus
    {
        return $this->status;
    }

    public function setStatus(?SaleStatus $status): static
    {
        $this->status = $status;

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

    /** @return Collection<int, Transaction> */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setSale($this);
        }

        return $this;
    }

    /** @return Collection<int, Driver> */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    /** @return Collection<int, Vehicle> */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    /** @return Collection<int, CoverageInPolicy> */
    public function getCoverages(): Collection
    {
        return $this->coverages;
    }

    public function getMedical(): ?Medical
    {
        return $this->medical;
    }

    public function getLifeIns(): ?LifeIns
    {
        return $this->lifeIns;
    }

    public function getPropertyFire(): ?PropertyFire
    {
        return $this->propertyFire;
    }

    public function getEmployersLiability(): ?EmployersLiability
    {
        return $this->employersLiability;
    }

    public function getCurrentBalance(): float
    {
        $last = $this->transactions->last();

        return $last ? (float) $last->getRemainder() : 0.0;
    }
}
