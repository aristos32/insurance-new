<?php

namespace App\Entity\Crm;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'lifeins')]
class LifeIns
{
    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Column(name: 'insuredFirstName', length: 70, nullable: true)]
    private ?string $insuredFirstName = null;

    #[ORM\Column(name: 'insuredLastName', length: 70, nullable: true)]
    private ?string $insuredLastName = null;

    #[ORM\Column(name: 'frequencyOfPayment', length: 20, nullable: true)]
    private ?string $frequencyOfPayment = null;

    #[ORM\Column(name: 'annualPremium', type: Types::FLOAT, nullable: true)]
    private ?float $annualPremium = null;

    #[ORM\Column(name: 'planName', length: 20, nullable: true)]
    private ?string $planName = null;

    #[ORM\OneToOne(targetEntity: Sale::class, inversedBy: 'lifeIns')]
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
