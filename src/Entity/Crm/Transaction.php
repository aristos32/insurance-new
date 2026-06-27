<?php

namespace App\Entity\Crm;

use App\Enum\TransactionDetail;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'transaction')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'transId')]
    private ?int $transId = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $producer = null;

    #[ORM\Column(name: 'receiptNo', length: 30, nullable: true)]
    private ?string $receiptNo = null;

    #[ORM\Column(name: 'transDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $transDate = null;

    #[ORM\Column(length: 30, nullable: true, enumType: TransactionDetail::class)]
    private ?TransactionDetail $details = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $debit = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $credit = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $remainder = null;

    #[ORM\ManyToOne(targetEntity: Sale::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'saleId', referencedColumnName: 'saleId', nullable: false, onDelete: 'CASCADE')]
    private ?Sale $sale = null;

    public function getTransId(): ?int
    {
        return $this->transId;
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

    public function getReceiptNo(): ?string
    {
        return $this->receiptNo;
    }

    public function setReceiptNo(?string $receiptNo): static
    {
        $this->receiptNo = $receiptNo;

        return $this;
    }

    public function getTransDate(): ?\DateTimeInterface
    {
        return $this->transDate;
    }

    public function setTransDate(?\DateTimeInterface $transDate): static
    {
        $this->transDate = $transDate;

        return $this;
    }

    public function getDetails(): ?TransactionDetail
    {
        return $this->details;
    }

    public function setDetails(?TransactionDetail $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getDebit(): ?float
    {
        return $this->debit;
    }

    public function setDebit(?float $debit): static
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(?float $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getRemainder(): ?float
    {
        return $this->remainder;
    }

    public function setRemainder(?float $remainder): static
    {
        $this->remainder = $remainder;

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
