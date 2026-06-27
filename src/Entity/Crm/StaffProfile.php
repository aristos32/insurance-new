<?php

namespace App\Entity\Crm;

use App\Repository\StaffProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffProfileRepository::class)]
#[ORM\Table(name: 'systemuser')]
class StaffProfile
{
    #[ORM\Id]
    #[ORM\Column(length: 40)]
    private string $username = '';

    #[ORM\Column(name: 'stateId', length: 20, nullable: true)]
    private ?string $stateId = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $producer = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(name: 'firstName', length: 70, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'lastName', length: 70, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $cellphone = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(length: 50)]
    private string $email = '';

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(name: 'licenseIssueDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $licenseIssueDate = null;

    #[ORM\Column(name: 'clientName', length: 40, nullable: true)]
    private ?string $clientName = null;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getStateId(): ?string
    {
        return $this->stateId;
    }

    public function setStateId(?string $stateId): static
    {
        $this->stateId = $stateId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

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

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getLicenseIssueDate(): ?\DateTimeInterface
    {
        return $this->licenseIssueDate;
    }

    public function setLicenseIssueDate(?\DateTimeInterface $licenseIssueDate): static
    {
        $this->licenseIssueDate = $licenseIssueDate;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }
}
