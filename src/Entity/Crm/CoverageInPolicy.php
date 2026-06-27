<?php

namespace App\Entity\Crm;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'coveragesinpolicy')]
class CoverageInPolicy
{
    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Id]
    #[ORM\Column(length: 50)]
    private string $code = '';

    #[ORM\Column(name: 'param1', length: 50, nullable: true)]
    private ?string $param1 = null;

    #[ORM\Column(name: 'param2', length: 50, nullable: true)]
    private ?string $param2 = null;

    #[ORM\Column(name: 'param3', length: 50, nullable: true)]
    private ?string $param3 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $charge = null;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'coverages')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', nullable: false, onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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

    public function getCharge(): ?float
    {
        return $this->charge;
    }

    public function setCharge(?float $charge): static
    {
        $this->charge = $charge;

        return $this;
    }

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
