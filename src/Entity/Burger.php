<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Pain;
use App\Entity\Ingredient;
use App\Entity\Sauce;
use App\Entity\Image;
use App\Entity\Commentaire;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\ManyToOne(targetEntity: Pain::class, inversedBy: 'burgers')]
    private $pain;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'burgers')]
    #[ORM\JoinTable(name: 'burgers_ingredients')]
    private $ingredients;

    #[ORM\ManyToMany(targetEntity: Sauce::class, inversedBy: 'burgers')]
    #[ORM\JoinTable(name: 'burgers_sauces')]
    private $sauces;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'burger')]
    private $commentaires;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPain(): ?Pain
    {
        return $this->pain;
    }

    public function setPain(Pain $pain): static
    {
        $this->pain = $pain;

        return $this;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getSauces(): array
    {
        return $this->sauces;
    }

    public function setSauces(array $sauces): static
    {
        $this->sauces = $sauces;

        return $this;
    }

    public function getCommentaires(): array
    {
        return $this->commentaires;
    }

    public function setCommentaires(array $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }
}
