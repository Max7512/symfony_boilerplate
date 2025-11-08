<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ORM\UniqueConstraint(name: "UNIQ_ORDER_REFERENCE", fields: ["name"])]
#[UniqueEntity(fields: ['name'], message: 'There is already a genre with this name')]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'children')]
    private Collection $parents;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'parents')]
    private Collection $children;

    /**
     * @var Collection<int, Vinyle>
     */
    #[ORM\ManyToMany(targetEntity: Vinyle::class, mappedBy: 'genres')]
    private Collection $vinyles;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->vinyles = new ArrayCollection();
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

    /**
     * @return Collection<int, self>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(self $parent): static
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->addParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            $child->removeParent($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Vinyle>
     */
    public function getVinyles(): Collection
    {
        return $this->vinyles;
    }

    public function addVinyle(Vinyle $vinyle): static
    {
        if (!$this->vinyles->contains($vinyle)) {
            $this->vinyles->add($vinyle);
            $vinyle->addGenre($this);
        }

        return $this;
    }

    public function removeVinyle(Vinyle $vinyle): static
    {
        if ($this->vinyles->removeElement($vinyle)) {
            $vinyle->removeGenre($this);
        }

        return $this;
    }
}
