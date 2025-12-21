<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public $genreCreated = [];

    public function load(ObjectManager $manager): void
    {
        foreach ($this::data as $genre => $children) {
            $parentGenre = new Genre();
            $parentGenre->setName($genre);
            $manager->persist($parentGenre);
            $this->genreCreated[$genre] = $parentGenre;
        }

        foreach ($this::data as $genre => $children) {
            $this->loadChildren($manager, $parentGenre, $children);
        }

        $manager->flush();
    }

    function loadChildren($manager, &$parent, &$children)
    {
        foreach ($children as $child => $subChildren) {
            $exist = isset($this->genreCreated[$child]);
            if ($exist) {
                $genre = $this->genreCreated[$child];
            } else {
                $genre = new Genre();
                $genre->setName($child);
            }

            $genre->addParent($parent);

            $manager->persist($genre);

            if (!$exist) {
                $this->genreCreated[$child] = $genre;
                if ($subChildren) {
                    $this->loadChildren($manager, $genre, $subChildren);
                }
            }
        }
    }

    const data = [
        "Rock" => [
            "Grunge" => [],
            "Hard Rock" => [
                "Heavy Metal" => [
                    "Power Metal" => [],
                    "Speed Metal" => [],
                ],
                "Glam Rock" => [],
                "Arena Rock" => [],
                "Rock" => [],
            ],
            "Punk Rock" => [
                "Punk" => [
                    "Hardcore Punk" => [],
                    "Post-Punk" => [],
                    "Garage Rock" => [],
                ],
                "Pop Punk" => [],
                "Rock Alt" => [],
            ],
            "Rock Alt" => [
                "Indie Rock" => [],
                "Post-Rock" => [],
                "Garage Rock" => [],
                "Grunge" => [],
                "Punk Rock" => [],
                "Rock" => [],
            ],
            "Progressif" => [],
            "Metal" => [
                "Heavy Metal" => [
                    "Thrash Metal" => [],
                    "Death Metal" => [],
                    "Black Metal" => [],
                    "Doom Metal" => [],
                    "Power Metal" => [],
                ],
                "Nu Metal" => [
                    "Rap Metal" => [],
                    "Metal Alt" => [],
                    "Rock" => [],
                ],
                "Metal Alt" => [
                    "Nu Metal" => [],
                    "Rock Alt" => [],
                ],
                "Rock" => [],
            ],
        ],

        "Pop" => [
            "Synthpop" => [],
            "Electropop" => [],
            "Dance Pop" => [],
            "Pop Rock" => [],
            "Indie Pop" => [],
        ],

        "Electro" => [
            "Techno" => [],
            "House" => [],
            "Trance" => [],
            "Drum And Bass" => [],
            "Electropop" => [],
        ],

        "Hip Hop" => [
            "Rap" => [],
            "Trap" => [],
            "Boom Bap" => [],
            "Lofi Hip Hop" => [],
            "Nu Metal" => [],
        ],

        "Jazz" => [
            "Bebop" => [],
            "Smooth Jazz" => [],
            "Swing" => [],
            "Fusion" => [],
            "Blues" => [],
        ],

        "Blues" => [
            "Rock" => [],
            "Jazz" => [],
            "Rhythm And Blues" => [],
            "Soul" => [],
        ],

        "Classique" => [
            "Baroque" => [],
            "Romantique" => [],
            "Contemporain" => [],
            "Opéra" => [],
        ],

        "Folk" => [
            "Country" => [],
            "Bluegrass" => [],
            "Indie Folk" => [],
            "Pop" => [],
            "Rock" => [],
        ],

        "Reggae" => [
            "Ska" => [],
            "Dub" => [],
            "Dancehall" => [],
        ],

        "Soul" => [
            "Blues" => [],
            "Funk" => [],
            "R&B" => [],
            "Gospel" => [],
        ],

        "Funk" => [
            "Soul" => [],
            "Disco" => [],
            "Hip Hop" => [],
        ],
    ];
}
