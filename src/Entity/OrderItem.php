<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $productPrice = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vinyle $Vinyle = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $Order_ = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): static
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getVinyle(): ?Vinyle
    {
        return $this->Vinyle;
    }

    public function setVinyle(?Vinyle $Vinyle): static
    {
        $this->Vinyle = $Vinyle;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->Order_;
    }

    public function setOrder(?Order $Order_): static
    {
        $this->Order_ = $Order_;

        return $this;
    }
}
