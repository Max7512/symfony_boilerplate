<?php

namespace App\Twig\Components\Panier;

use App\Entity\PanierItem as EntityPanierItem;
use App\Repository\PanierItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('PanierItem', template: 'components/Panier/PanierItem.html.twig')]
class PanierItem
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: ["quantity"], onUpdated: ["quantity" => "quantityChanged"])]
    public EntityPanierItem $panierItem;

    public function __construct(private PanierItemRepository $panierItemRepository, private EntityManagerInterface $entityManager) {}

    #[LiveAction]
    public function quantityChanged(): void
    {
        $this->entityManager->persist($this->panierItem);
        $this->entityManager->flush();

        $this->emit("refreshTotal");
    }

    public function getHorsStock(): bool
    {
        return $this->panierItem->getVinyle()->getStock() < $this->panierItem->getQuantity();
    }
}
