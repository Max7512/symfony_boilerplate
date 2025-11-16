<?php

namespace App\Twig\Components\Panier;

use App\Entity\User;
use App\Repository\PanierItemRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Panier', template: 'components/Panier/Panier.html.twig')]
class Panier
{
    use DefaultActionTrait;

    #[LiveProp]
    public User $user;

    public function __construct(private PanierItemRepository $panierItemRepository) {}

    public function getPanierItems(): array
    {
        return $this->panierItemRepository->getUserPanier($this->user->getId());
    }

    public function getPanierItemsCount(): int
    {
        return count($this->panierItemRepository->getUserPanier($this->user->getId()));
    }

    public function getTotal(): float 
    {
        return $this->panierItemRepository->getUserPanierTotal($this->user->getId());
    }
}
