<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Burger;
use App\Entity\Image;
use App\Entity\Pain;
use App\Entity\Ingredient;
use App\Entity\Sauce;

class BurgerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pain = new Pain();
        $pain->setName('Pain burger');

        $tomate = new Ingredient();
        $tomate->setName('Tomate');

        $oignon = new Ingredient();
        $oignon->setName('Oignon blanc');

        $salade = new Ingredient();
        $salade->setName('Salade');

        $sauceBBQ = new Sauce();
        $sauceBBQ->setName('Sauce BBQ');

        $moutarde = new Sauce();
        $moutarde->setName('Moutarde');

        $ingredients = array($tomate, $oignon, $salade);
        $sauces = array($sauceBBQ, $moutarde);

        $manager->persist($pain);

        foreach ($ingredients as $ingredient) {
            $manager->persist($ingredient);
        }

        foreach ($sauces as $sauce) {
            $manager->persist($sauce);
        }

        for ($i = 0; $i < 20; $i++) {
            $image = new Image();
            $image->setPath('https://i.redd.it/umtxt5o6708d1.jpeg');

            $burger = new Burger();

            $burger->setName('Cheeseburger');
            $burger->setPrice(rand(100, 1000) / 100);
            $burger->setImage($image);
            $burger->setPain($pain);
            $burger->setIngredients(array());
            $burger->setSauces(array());
            $burger->setCommentaires(array());

            $burgerIngredients = $burger->getIngredients();
            $burgerSauces = $burger->getSauces();

            foreach ($ingredients as $ingredient) {
                if (rand(0, 1) == 1) array_push($burgerIngredients, $ingredient);
            }

            foreach ($sauces as $sauce) {
                if (rand(0, 1) == 1) array_push($burgerSauces, $sauce);
            }

            $manager->persist($image);
            $manager->persist($burger);
        }

        $manager->flush();
    }
}
