<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 511)]
    private ?string $url = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?Vinyle $vinyle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getVinyle(): ?Vinyle
    {
        return $this->vinyle;
    }

    public function setVinyle(Vinyle $vinyle): static
    {
        // set the owning side of the relation if necessary
        if ($vinyle->getImage() !== $this) {
            $vinyle->setImage($this);
        }

        $this->vinyle = $vinyle;

        return $this;
    }
}
