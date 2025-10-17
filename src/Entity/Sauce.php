<?php

namespace App\Entity;

use App\Repository\SauceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SauceRepository::class)]
class Sauce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'sauces')]
    private $burgers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBurgers(): array
    {
        return $this->burgers;
    }

    public function setBurgers(array $burgers): static
    {
        $this->burgers = $burgers;

        return $this;
    }
}
