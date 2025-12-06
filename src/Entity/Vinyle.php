<?php

namespace App\Entity;

use App\Repository\VinyleRepository;
use App\Util\VinyleStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(enumType: VinyleStatus::class)]
    private ?VinyleStatus $status = null;

    #[ORM\OneToOne(inversedBy: 'vinyle', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'Vinyle')]
    private Collection $orderItems;

    /**
     * @var Collection<int, PanierItem>
     */
    #[ORM\OneToMany(targetEntity: PanierItem::class, mappedBy: 'Vinyle')]
    private Collection $panierItems;

    #[ORM\ManyToOne(inversedBy: 'vinyles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'vinyles')]
    private Collection $genres;

    #[ORM\Column]
    private ?bool $deleted = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->panierItems = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock, bool $preorder = false): static
    {
        $this->stock = $stock;

        if ($preorder) {
            $this->setStatus(VinyleStatus::PREORDER);
        } else if ($stock > 0) {
            $this->setStatus(VinyleStatus::IN_STOCK);
        } else {
            $this->setStatus(VinyleStatus::OUT_OF_STOCK);
        }

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setVinyle($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getVinyle() === $this) {
                $orderItem->setVinyle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PanierItem>
     */
    public function getPanierItems(): Collection
    {
        return $this->panierItems;
    }

    public function addPanierItem(PanierItem $panierItem): static
    {
        if (!$this->panierItems->contains($panierItem)) {
            $this->panierItems->add($panierItem);
            $panierItem->setVinyle($this);
        }

        return $this;
    }

    public function removePanierItem(PanierItem $panierItem): static
    {
        if ($this->panierItems->removeElement($panierItem)) {
            // set the owning side to null (unless already changed)
            if ($panierItem->getVinyle() === $this) {
                $panierItem->setVinyle(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }
}
