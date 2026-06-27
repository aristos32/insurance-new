<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'propertyfire')]
class PropertyFire
{
    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'typeOfPremises', length: 50, nullable: true)]
    private ?string $typeOfPremises = null;

    #[ORM\Column(name: 'buildingValue', nullable: true)]
    private ?int $buildingValue = null;

    #[ORM\OneToOne(targetEntity: Sale::class, inversedBy: 'propertyFire')]
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
