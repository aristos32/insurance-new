<?php

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'statistics')]
class Statistic
{
    #[ORM\Id]
    #[ORM\Column]
    private int $code = 0;

    #[ORM\Column(length: 50)]
    private string $value = '';

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
