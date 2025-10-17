<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Burger;
use App\Entity\Image;
use App\Entity\Pain;
use App\Entity\Oignon;
use App\Entity\Sauce;

class BurgerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setPath('https://i.redd.it/umtxt5o6708d1.jpeg');

            $pain = new Pain();
            $pain->setName('Pain de mie');

            $oignon = new Oignon();
            $oignon->setName('Oignon blanc');

            $sauce = new Sauce();
            $sauce->setName('Sauce BBQ');

            $burger = new Burger();

            $burger->setName('Cheeseburger'.$id);
            $burger->setPrice(rand(100, 1000) / 100);
            $burger->setImage($image);
            $burger->setPain($pain);
            $burger->setOignons(array($oignon));
            $burger->setSauces(array($sauce));

            $manager->persist($image);
            $manager->persist($pain);
            $manager->persist($oignon);
            $manager->persist($sauce);
            $manager->persist($burger);
        }

        $manager->flush();
    }
}
