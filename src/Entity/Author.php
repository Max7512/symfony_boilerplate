<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Vinyle>
     */
    #[ORM\OneToMany(targetEntity: Vinyle::class, mappedBy: 'author')]
    private Collection $vinyles;

    public function __construct()
    {
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
            $vinyle->setAuthor($this);
        }

        return $this;
    }

    public function removeVinyle(Vinyle $vinyle): static
    {
        if ($this->vinyles->removeElement($vinyle)) {
            // set the owning side to null (unless already changed)
            if ($vinyle->getAuthor() === $this) {
                $vinyle->setAuthor(null);
            }
        }

        return $this;
    }
}
