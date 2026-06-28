<?php

namespace App\Entity\Crm;

use App\Enum\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer')]
class Customer
{
    #[ORM\Id]
    #[ORM\Column(name: 'stateId', length: 20)]
    private string $stateId = '';

    #[ORM\Column(name: 'firstName', length: 70, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'lastName', length: 70, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50, nullable: true, enumType: CustomerType::class)]
    private ?CustomerType $type = CustomerType::Customer;

    #[ORM\Column(name: 'proposerType', length: 30, nullable: true)]
    private ?string $proposerType = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(name: 'countryOfBirth', length: 30, nullable: true)]
    private ?string $countryOfBirth = null;

    #[ORM\Column(name: 'countryOfResidence', length: 30, nullable: true)]
    private ?string $countryOfResidence = null;

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $cellphone = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'unwantedCustomer', length: 5, nullable: true)]
    private ?string $unwantedCustomer = null;

    #[ORM\Column(name: 'reasonForUnwanted', length: 50, nullable: true)]
    private ?string $reasonForUnwanted = null;

    /** @var Collection<int, CustomerAddress> */
    #[ORM\OneToMany(targetEntity: CustomerAddress::class, mappedBy: 'customer', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $addresses;

    /** @var Collection<int, Sale> */
    #[ORM\OneToMany(targetEntity: Sale::class, mappedBy: 'customer', cascade: ['persist'])]
    private Collection $sales;

    /** @var Collection<int, Claim> */
    #[ORM\OneToMany(targetEntity: Claim::class, mappedBy: 'customer', cascade: ['persist'])]
    private Collection $claims;

    /** @var Collection<int, License> */
    #[ORM\OneToMany(targetEntity: License::class, mappedBy: 'customer', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $licenses;

    /** @var Collection<int, DrivingExperience> */
    #[ORM\OneToMany(targetEntity: DrivingExperience::class, mappedBy: 'customer', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $drivingExperiences;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->sales = new ArrayCollection();
        $this->claims = new ArrayCollection();
        $this->licenses = new ArrayCollection();
        $this->drivingExperiences = new ArrayCollection();
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

    public function getType(): ?CustomerType
    {
        return $this->type;
    }

    public function setType(?CustomerType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getProposerType(): ?string
    {
        return $this->proposerType;
    }

    public function setProposerType(?string $proposerType): static
    {
        $this->proposerType = $proposerType;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountryOfBirth(): ?string
    {
        return $this->countryOfBirth;
    }

    public function setCountryOfBirth(?string $countryOfBirth): static
    {
        $this->countryOfBirth = $countryOfBirth;

        return $this;
    }

    public function getCountryOfResidence(): ?string
    {
        return $this->countryOfResidence;
    }

    public function setCountryOfResidence(?string $countryOfResidence): static
    {
        $this->countryOfResidence = $countryOfResidence;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCellphone(): ?string
    {
        return $this->cellphone;
    }

    public function setCellphone(?string $cellphone): static
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUnwantedCustomer(): ?string
    {
        return $this->unwantedCustomer;
    }

    public function setUnwantedCustomer(?string $unwantedCustomer): static
    {
        $this->unwantedCustomer = $unwantedCustomer;

        return $this;
    }

    public function getReasonForUnwanted(): ?string
    {
        return $this->reasonForUnwanted;
    }

    public function setReasonForUnwanted(?string $reasonForUnwanted): static
    {
        $this->reasonForUnwanted = $reasonForUnwanted;

        return $this;
    }

    /** @return Collection<int, CustomerAddress> */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(CustomerAddress $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setCustomer($this);
        }

        return $this;
    }

    /** @return Collection<int, Sale> */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    /** @return Collection<int, Claim> */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    /** @return Collection<int, License> */
    public function getLicenses(): Collection
    {
        return $this->licenses;
    }

    /** @return Collection<int, DrivingExperience> */
    public function getDrivingExperiences(): Collection
    {
        return $this->drivingExperiences;
    }
}
