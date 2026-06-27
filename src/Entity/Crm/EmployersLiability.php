<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'employersliability')]
class EmployersLiability
{
    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Column(name: 'employersSocialInsuranceNumber', length: 20, nullable: true)]
    private ?string $employersSocialInsuranceNumber = null;

    #[ORM\Column(name: 'employeesNumber', nullable: true)]
    private ?int $employeesNumber = null;

    #[ORM\OneToOne(targetEntity: Sale::class, inversedBy: 'employersLiability')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): static
    {
        $this->sale = $sale;
        if ($sale) {
            $this->saleId = $sale->getSaleId();
        }

        return $this;
    }
}
