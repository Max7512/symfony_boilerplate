<?php

namespace App\Twig\Components\Commande;

use App\Entity\User;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Commande', template: 'components/Commande/Commande.html.twig')]
class Commande
{
    public User $user;

    public function __construct() {}

    public function getCommandes(): array
    {
        return $this->user->getOrders()->toArray();
    }
}
