<?php

namespace App\Twig\Components\Commande;

use App\Entity\Order;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CommandeItem', template: 'components/Commande/CommandeItem.html.twig')]
class CommandeItem
{
    public Order $commande;

    public function __construct() {}

    public function getTotal(): float {
        $total = 0;

        foreach ($this->commande->getOrderItems() as $orderItem) {
            $total += $orderItem->getQuantity() * $orderItem->getProductPrice();
        }

        return $total;
    }
}
