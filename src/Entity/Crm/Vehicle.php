<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'vehicle')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\Column(name: 'regNumber', length: 10)]
    private string $regNumber = '';

    #[ORM\Id]
    #[ORM\Column(name: 'saleId', length: 20)]
    private string $saleId = '';

    #[ORM\Column(name: 'vehicleType', length: 40)]
    private string $vehicleType = '';

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $make = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $submodel = null;

    #[ORM\Column(name: 'cubicCapacity')]
    private int $cubicCapacity = 0;

    #[ORM\Column(name: 'engineKw', nullable: true)]
    private ?int $engineKw = null;

    #[ORM\Column(name: 'manufacturedYear')]
    private int $manufacturedYear = 0;

    #[ORM\Column(name: 'seatsNo', nullable: true)]
    private ?int $seatsNo = null;

    #[ORM\Column(name: 'sumInsured', nullable: true)]
    private ?int $sumInsured = null;

    #[ORM\Column(name: 'vehicleDesign', length: 15)]
    private string $vehicleDesign = 'REGULAR';

    #[ORM\Column(name: 'steeringWheelSide', length: 10, nullable: true)]
    private ?string $steeringWheelSide = null;

    #[ORM\Column(name: 'isTaxFree', length: 10, nullable: true)]
    private ?string $isTaxFree = null;

    #[ORM\Column(name: 'isUsedForDeliveries', length: 10, nullable: true)]
    private ?string $isUsedForDeliveries = null;

    #[ORM\Column(name: 'hasVisitorPlates', length: 10, nullable: true)]
    private ?string $hasVisitorPlates = null;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', nullable: false, onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }

    public function setRegNumber(string $regNumber): static
    {
        $this->regNumber = $regNumber;

        return $this;
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

    public function getVehicleType(): string
    {
        return $this->vehicleType;
    }

    public function setVehicleType(string $vehicleType): static
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(?string $make): static
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCubicCapacity(): int
    {
        return $this->cubicCapacity;
    }

    public function setCubicCapacity(int $cubicCapacity): static
    {
        $this->cubicCapacity = $cubicCapacity;

        return $this;
    }

    public function getVehicleDesign(): string
    {
        return $this->vehicleDesign;
    }

    public function setVehicleDesign(string $vehicleDesign): static
    {
        $this->vehicleDesign = $vehicleDesign;

        return $this;
    }

    public function getManufacturedYear(): int
    {
        return $this->manufacturedYear;
    }

    public function setManufacturedYear(int $year): static
    {
        $this->manufacturedYear = $year;

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
