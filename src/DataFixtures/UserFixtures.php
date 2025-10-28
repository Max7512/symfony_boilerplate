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
        $possibleNames = [];
        foreach ($this::firstNames as $firstName) {
            foreach ($this::lastNames as $lastName) {
                $possibleNames[] = ["firstName" => $firstName, "lastName" => $lastName]; // pour une raison inconnue les boucle for et do while précédement mises en place posaient un problème avec la gestion de l'aléatoire et se bloquaient tout le temps en essayant de créer des noms uniques
            }
        }

        shuffle($possibleNames); // pour contourner le problème précedent j'ai donc décidé de générer tout les noms possibles puis mélanger la liste pour prendre arbitrairement dans l'ordre les noms, je perd malheureusement de l'efficacité avec ce système jusqu'à trouver une solution

        for ($i = 0; $i < 10; $i++) {
            $user = new User();

            $name = $possibleNames[$i];
            $firstName = $name["firstName"];
            $lastName = $name["lastName"];

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($firstName . $lastName . "@truc.com");
            $user->setPassword("$2y$13$9uGgMHtDM55GkvNLMdCmsOjqvTzbncvbArUd0iJ3KC/7joD205WwK"); // 00000000

            $roles = ["ROLE_USER"];

            if (mt_rand(0, 10) == 10) {
                $roles[] = "ROLE_ADMIN";
            }

            $user->setRoles($roles);

            $addressCount = mt_rand(1, 3);
            for ($j = 0; $j < $addressCount; $j++) {
                $address = new Address();

                $address->setStreet($this::streets[array_rand($this::streets)]);
                $address->setCity($this::cities[array_rand($this::cities)]);
                $address->setPostalCode($this::postalCodes[array_rand($this::postalCodes)]);
                $address->setCountry($this::countries[array_rand($this::countries)]);

                $user->addAddress($address);

                $manager->persist($address);
            }

            $manager->persist($user);
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
