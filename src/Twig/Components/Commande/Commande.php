<?php

namespace App\Twig\Components\Commande;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Commande', template: 'components/Commande/Commande.html.twig')]
class Commande
{
    public ?User $user = null;

    public bool $dashboard = false;

    public function __construct(private OrderRepository $orderRepository) {}

    public function getCommandes(): array
    {
        if ($this->dashboard) {
            return $this->orderRepository->findAll();
        } else {
            return $this->user->getOrders()->toArray();
        }
    }
}
