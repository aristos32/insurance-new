<?php

namespace App\Entity\Crm;

use App\Enum\UserRole;
use App\Enum\UserStatus;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(length: 40)]
    private string $username = '';

    #[ORM\Column(length: 60)]
    private string $password = '';

    #[ORM\Column(length: 20)]
    private string $role = '5';

    #[ORM\Column(length: 20)]
    private string $status = UserStatus::Active->value;

    #[ORM\Column(name: 'productType', length: 20, nullable: true)]
    private ?string $productType = null;

    #[ORM\Column(name: 'subProductType', length: 20, nullable: true)]
    private ?string $subProductType = null;

    #[ORM\Column(name: 'clientName', length: 40, nullable: true)]
    private ?string $clientName = null;

    #[ORM\Column(name: 'consecutiveFailLoginAttempts', nullable: true)]
    private ?int $consecutiveFailLoginAttempts = 0;

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

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(name: 'licenseIssueDate', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $licenseIssueDate = null;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(?string $productType): static
    {
        $this->productType = $productType;

        return $this;
    }

    public function getSubProductType(): ?string
    {
        return $this->subProductType;
    }

    public function setSubProductType(?string $subProductType): static
    {
        $this->subProductType = $subProductType;

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

    public function getConsecutiveFailLoginAttempts(): ?int
    {
        return $this->consecutiveFailLoginAttempts;
    }

    public function setConsecutiveFailLoginAttempts(?int $attempts): static
    {
        $this->consecutiveFailLoginAttempts = $attempts;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
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

    public function getRoles(): array
    {
        $role = UserRole::tryFrom((int) $this->role);

        return [$role?->symfonyRole() ?? 'ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active->value;
    }

    public function hasOfficeAccess(): bool
    {
        return (int) $this->role >= UserRole::Employee->value;
    }
}
