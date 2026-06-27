<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'endorsement')]
class Endorsement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $parameter = null;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'endorsements')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', nullable: false, onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
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
