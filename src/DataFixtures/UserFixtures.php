<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Address;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();

            $firstName = array_rand($this::firstNames);
            $lastName = array_rand($this::lastNames);

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($firstName . $lastName . "@truc.com");

            unset($firstName);
            unset($lastName);

            $roles = ["ROLE_USER"];

            if (rand(0, 10) == 10) array_push($roles, "ROLE_ADMIN");

            $user->setRoles($roles);

            unset($roles);

            for ($i = 0; $i < rand(0, 3); $i++) {
                $address = new Address();

                $address->setStreet(array_rand($this::streets));
                $address->setCity(array_rand($this::cities));
                $address->setPostalCode(array_rand($this::postalCodes));
                $address->setCountry(array_rand($this::countries));

                $user->addAddress($address);

                unset($address);
            }

            $manager->persist($user);

            unset($user);
        }

        $manager->flush();
    }

    const firstNames = [
        "Lucas",
        "Emma",
        "Noah",
        "Léa",
        "Gabriel",
        "Chloé",
        "Louis",
        "Manon",
        "Hugo",
        "Camille",
        "Arthur",
        "Inès",
        "Jules",
        "Sarah",
        "Nathan",
        "Zoé",
        "Paul",
        "Alice",
        "Thomas",
        "Lina",
        "Alexandre",
        "Eva",
        "Léo",
        "Anna",
        "Mathis",
        "Clara",
        "Maxime",
        "Juliette",
        "Enzo",
        "Nina"
    ];

    const lastNames = [
        "Martin",
        "Bernard",
        "Thomas",
        "Petit",
        "Robert",
        "Richard",
        "Durand",
        "Dubois",
        "Moreau",
        "Laurent",
        "Simon",
        "Michel",
        "Lefebvre",
        "Leroy",
        "Roux",
        "David",
        "Bertrand",
        "Morel",
        "Fournier",
        "Girard",
        "Bonnet",
        "Dupont",
        "Lambert",
        "Fontaine",
        "Rousseau",
        "Vincent",
        "Muller",
        "Lefèvre",
        "Faure",
        "André"
    ];

    const streets = [
        "12 rue de la Paix",
        "45 avenue des Champs-Élysées",
        "23 boulevard Saint-Michel",
        "7 rue du Port",
        "98 rue Nationale",
        "14 place de la République",
        "32 rue de la Liberté",
        "76 avenue Victor Hugo",
        "5 rue du Général Leclerc",
        "11 chemin des Érables"
    ];

    const cities = [
        "Paris",
        "Lyon",
        "Marseille",
        "Lille",
        "Bordeaux",
        "Dijon",
        "Nice",
        "Nantes",
        "Toulouse",
        "Strasbourg"
    ];

    const postalCodes = [
        "75002",
        "69005",
        "13002",
        "59000",
        "33000",
        "21000",
        "06000",
        "44000",
        "31000",
        "67000"
    ];

    const countries = [
        "France",
        "Belgique",
        "Suisse",
        "Luxembourg",
        "Canada"
    ];
}
