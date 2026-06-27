<?php

namespace App\Entity\Global;

use App\Enum\UserRole;
use App\Enum\UserStatus;
use App\Repository\GlobalUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: GlobalUserRepository::class)]
#[ORM\Table(name: 'systemuser')]
class GlobalUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'username', length: 40)]
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
