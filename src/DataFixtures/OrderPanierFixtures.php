<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\PanierItem;
use App\Entity\User;
use App\Entity\Vinyle;
use App\Util\OrderStatus;
use App\Util\VinyleStatus;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\ByteString;

class OrderPanierFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository(User::class);
        $vinyleRepository = $manager->getRepository(Vinyle::class);

        $users = $userRepository->findAll();
        $vinyles = $vinyleRepository->findAll();

        foreach ($users as $user) {
            $panier = [];
            $orderItems = [];

            for ($i = 0; $i < rand(0, 10); $i++) {
                $vinyle = $vinyles[mt_rand(0, count($vinyles) - 1)];
                if ($vinyle->getStatus() != VinyleStatus::OUT_OF_STOCK) {
                    $panier[$vinyle->getId()] = mt_rand(1, $vinyle->getStock());
                }
            }

            foreach ($panier as $vinyleId => $quantity) {
                if (mt_rand(0, 1)) {
                    $orderItems[$vinyleId] = $quantity;
                    $panier[$vinyleId] = 0;
                }
            }

            if (count($orderItems) > 0) {
                $order = new Order();
                $order->setUser($user);
                $order->setStatus(match (mt_rand(0, 3)) {
                    0 => OrderStatus::IN_PREPARATION,
                    1 => OrderStatus::SENT,
                    2 => OrderStatus::DELIVERED,
                    3 => OrderStatus::CANCELLED
                });
                $order->setCreatedAt(new DateTimeImmutable());
                $order->setReference(ByteString::fromRandom(32)->toString()); // Génère une chaîne aléatoire de 32 caractères normalement
                $order->setAddress($user->getAddress()[mt_rand(0, count($user->getAddress()) - 1)]);

                foreach ($orderItems as $vinyleId => $quantity) {
                    $vinyle = $vinyleRepository->find($vinyleId);
                    $orderItem = new OrderItem();
                    $orderItem->setOrder($order);
                    $orderItem->setVinyle($vinyle);
                    $orderItem->setQuantity($quantity);
                    $orderItem->setProductPrice($vinyle->getPrice());
                    $order->addOrderItem($orderItem);

                    $manager->persist($orderItem);
                }
                $manager->persist($order);
                $user->addOrder($order);
            }

            foreach ($panier as $vinyleId => $quantity) {
                if ($quantity > 0) {
                    $panierItem = new PanierItem();
                    $panierItem->setUser($user);
                    $panierItem->setVinyle($vinyleRepository->find($vinyleId));
                    $panierItem->setQuantity($quantity);
                    $user->addPanierItem($panierItem);

                    $manager->persist($panierItem);
                }
            }

            $manager->persist($user);

            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            VinyleFixtures::class
        ];
    }
}
