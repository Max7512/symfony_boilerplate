<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\PanierItem;
use App\Util\OrderStatus;
use App\Util\VinyleStatus;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderPanierFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository("User");
        $vinyleRepository = $manager->getRepository("Vinyle");

        $users = $userRepository->findAll();
        $vinyles = $vinyleRepository->findAll();

        foreach ($users as $user) {
            $panier = [];
            $orderItems = [];

            for ($i = 0; $i < rand(0, 10); $i++) {
                $vinyle = $vinyles[array_rand($vinyles)];
                if ($vinyle->getStatus() != VinyleStatus::OUT_OF_STOCK) $panier[$vinyle] = rand(1, $vinyle->getStock());
            }

            for ($i = 0; $i < count($panier); $i++) {
                if (rand(0, 1)) {
                    $orderItems[$vinyle] = $panier[$vinyle];
                    $panier[$vinyle] = 0;
                }
            }

            if (count($orderItems) > 0) {
                $order = new Order();
                $order->setUser($user);
                $order->setStatus(match (rand(0, 3)) {
                    0 => OrderStatus::IN_PREPARATION,
                    1 => OrderStatus::SENT,
                    2 => OrderStatus::DELIVERED,
                    3 => OrderStatus::CANCELLED
                });
                $order->setCreatedAt(new DateTimeImmutable());
                $order->setReference(random_bytes(32));
                foreach ($orderItems as $vinyle => $quantity) {
                    $orderItem = new OrderItem();
                    $orderItem->setOrder($order);
                    $orderItem->setVinyle($vinyle);
                    $orderItem->setQuantity($quantity);
                    $order->addOrderItem($orderItem);
                }
                $user->addOrder($order);
            }

            foreach ($panier as $vinyle => $quantity) {
                if ($quantity > 0) {
                    $panierItem = new PanierItem();
                    $panierItem->setUser($user);
                    $panierItem->setVinyle($vinyle);
                    $panierItem->setQuantity($quantity);
                    $user->addPanierItem($panierItem);
                }
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            VinyleFixtures::class
        ];
    }
}
