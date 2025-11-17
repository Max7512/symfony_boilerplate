<?php

namespace App\Twig\Components\Panier;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Repository\PanierItemRepository;
use App\Util\VinyleStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\PanierItem as EntityPanierItem;
use App\Util\OrderStatus;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\ByteString;
use Symfony\UX\LiveComponent\Attribute\LiveListener;

#[AsLiveComponent('Panier', template: 'components/Panier/Panier.html.twig')]
class Panier extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public User $user;

    #[LiveProp]
    /** @var EntityPanierItem[] */
    public array $panier = [];

    public function __construct(private PanierItemRepository $panierItemRepository, private EntityManagerInterface $entityManager) {}

    public function getPanier(): array
    {
        return $this->panier = $this->panierItemRepository->getUserPanier($this->user->getId());
    }

    public function getPanierItemsCount(): int
    {
        return count($this->panierItemRepository->getUserPanier($this->user->getId()));
    }

    #[LiveListener("refreshTotal")]
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->panier as $panierItem) {
            $total += $panierItem->getQuantity() * $panierItem->getVinyle()->getPrice();
        }

        return $total;
    }

    #[LiveAction]
    public function payer(): void
    {
        if (!$this->getPanierHorsStock()) {
            $panier = $this->getPanier();

            $commande = new Order();

            $commande->setUser($this->user);
            $commande->setStatus(OrderStatus::IN_PREPARATION);
            $commande->setCreatedAt(new DateTimeImmutable());
            $commande->setReference(ByteString::fromRandom(32)->toString());
            $commande->setAddress($this->user->getAddress()[mt_rand(0, count($this->user->getAddress()) - 1)]);

            foreach ($panier as $panierItem) {
                $vinyle = $panierItem->getVinyle();
                $quantity = $panierItem->getQuantity();

                $newStock = $vinyle->getStock() - $quantity;
                $vinyle->setStock($newStock);
                if ($newStock <= 0) {
                    $vinyle->setStatus(VinyleStatus::OUT_OF_STOCK);
                }

                $commandeItem = new OrderItem();
                $commandeItem->setVinyle($vinyle);
                $commandeItem->setQuantity($quantity);
                $commandeItem->setProductPrice($vinyle->getPrice());
                $commande->addOrderItem($commandeItem);

                $this->entityManager->persist($commandeItem);

                $this->entityManager->remove($panierItem);
            }

            $this->entityManager->persist($commande);
            $this->entityManager->flush();

            $this->redirect("accueil");
        }
    }

    public function getPanierHorsStock(): bool
    {
        foreach ($this->panier as $panierItem) {
            if ($panierItem->getVinyle()->getStock() < $panierItem->getQuantity())
                return true;
        }

        return false;
    }
}
