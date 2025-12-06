<?php

namespace App\Twig\Components\Commande;

use App\Entity\Order;
use App\Util\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('CommandeItem', template: 'components/Commande/CommandeItem.html.twig')]
class CommandeItem
{
    use DefaultActionTrait;

    #[LiveProp]
    public Order $commande;

    #[LiveProp(writable: true)]
    public string $statut;

    #[LiveProp]
    public bool $dashboard = false;

    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getTotal(): float {
        $total = 0;

        foreach ($this->commande->getOrderItems() as $orderItem) {
            $total += $orderItem->getQuantity() * $orderItem->getProductPrice();
        }

        return $total;
    }

    public function getStatuses(): array {
        return OrderStatus::cases();
    }

    #[LiveAction]
    public function save(): void {
        $this->commande->setStatus(OrderStatus::from($this->statut));
        $this->entityManager->persist($this->commande);
        $this->entityManager->flush();
    }
}
