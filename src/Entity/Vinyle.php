<?php

namespace App\Entity;

use App\Repository\VinyleRepository;
use App\Util\VinyleStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VinyleRepository::class)]
class Vinyle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 64)]
    private ?string $author = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(enumType: VinyleStatus::class)]
    private ?VinyleStatus $status = null;

    #[ORM\OneToOne(inversedBy: 'vinyle', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStatus(): ?VinyleStatus
    {
        return $this->status;
    }

    public function setStatus(VinyleStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?image
    {
        return $this->image;
    }

    public function setImage(image $image): static
    {
        $this->image = $image;

        return $this;
    }
}
