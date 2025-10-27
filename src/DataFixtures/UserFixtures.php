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
        $picked = [];

        for ($i = 0; $i < 10; $i++) {
            $user = new User();

            $firstName = "";
            $lastName = "";

            do {
                $firstName = $this::firstNames[mt_rand(0, count($this::firstNames) - 1)]; // ne marche pas car pour quelques raisons les fonctions aléatoires donnent toujours le meme nombre
                $lastName = $this::lastNames[mt_rand(0, count($this::lastNames) - 1)];
            } while (in_array($firstName . $lastName, $picked));

            array_push($picked, $firstName . $lastName);

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($firstName . $lastName . "@truc.com");
            $user->setPassword("$2y$13$9uGgMHtDM55GkvNLMdCmsOjqvTzbncvbArUd0iJ3KC/7joD205WwK"); // 00000000

            $roles = ["ROLE_USER"];

            if (mt_rand(0, 10) == 10) array_push($roles, "ROLE_ADMIN");

            $user->setRoles($roles);

            for ($i = 0; $i < mt_rand(0, 3); $i++) {
                $address = new Address();

                $address->setStreet($this::streets[mt_rand(0, count($this::streets) - 1)]);
                $address->setCity($this::cities[mt_rand(0, count($this::cities) - 1)]);
                $address->setPostalCode($this::postalCodes[mt_rand(0, count($this::postalCodes) - 1)]);
                $address->setCountry($this::countries[mt_rand(0, count($this::countries) - 1)]);

                $user->addAddress($address);

                $manager->persist($address);
            }

            $manager->persist($user);
            $manager->flush();
        }
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
