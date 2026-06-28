<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'drivingexperience')]
class DrivingExperience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'hasPreviousInsurance', length: 5, nullable: true)]
    private ?string $hasPreviousInsurance = null;

    #[ORM\Column(name: 'countryOfInsurance', length: 50, nullable: true)]
    private ?string $countryOfInsurance = null;

    #[ORM\Column(name: 'insuranceCompany', length: 50, nullable: true)]
    private ?string $insuranceCompany = null;

    #[ORM\Column(name: 'yearsOfExperience', length: 5, nullable: true)]
    private ?string $yearsOfExperience = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'drivingExperiences')]
    #[ORM\JoinColumn(name: 'stateId', referencedColumnName: 'stateId', nullable: false, onDelete: 'CASCADE')]
    private ?Customer $customer = null;

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }
}
