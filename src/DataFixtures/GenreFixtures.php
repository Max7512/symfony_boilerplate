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
        "rock" => [
            "grunge" => [],
            "hard rock" => [
                "heavy metal" => [
                    "power metal" => [],
                    "speed metal" => [],
                ],
                "glam rock" => [],
                "arena rock" => [],
                "rock" => [],
            ],
            "punk rock" => [
                "punk" => [
                    "hardcore punk" => [],
                    "post-punk" => [],
                    "garage rock" => [],
                ],
                "pop punk" => [],
                "rock alt" => [],
            ],
            "rock alt" => [
                "indie rock" => [],
                "post-rock" => [],
                "garage rock" => [],
                "grunge" => [],
                "punk rock" => [],
                "rock" => [],
            ],
            "progressif" => [],
            "metal" => [
                "heavy metal" => [
                    "thrash metal" => [],
                    "death metal" => [],
                    "black metal" => [],
                    "doom metal" => [],
                    "power metal" => [],
                ],
                "nu metal" => [
                    "rap metal" => [],
                    "metal alt" => [],
                    "rock" => [],
                ],
                "metal alt" => [
                    "nu metal" => [],
                    "rock alt" => [],
                ],
                "rock" => [],
            ],
        ],

        "pop" => [
            "synthpop" => [],
            "electropop" => [],
            "dance pop" => [],
            "pop rock" => [],
            "indie pop" => [],
        ],

        "electro" => [
            "techno" => [],
            "house" => [],
            "trance" => [],
            "drum and bass" => [],
            "electropop" => [],
        ],

        "hip hop" => [
            "rap" => [],
            "trap" => [],
            "boom bap" => [],
            "lofi hip hop" => [],
            "nu metal" => [],
        ],

        "jazz" => [
            "bebop" => [],
            "smooth jazz" => [],
            "swing" => [],
            "fusion" => [],
            "blues" => [],
        ],

        "blues" => [
            "rock" => [],
            "jazz" => [],
            "rhythm and blues" => [],
            "soul" => [],
        ],

        "classique" => [
            "baroque" => [],
            "romantique" => [],
            "contemporain" => [],
            "opéra" => [],
        ],

        "folk" => [
            "country" => [],
            "bluegrass" => [],
            "indie folk" => [],
            "pop" => [],
            "rock" => [],
        ],

        "reggae" => [
            "ska" => [],
            "dub" => [],
            "dancehall" => [],
        ],

        "soul" => [
            "blues" => [],
            "funk" => [],
            "r&b" => [],
            "gospel" => [],
        ],

        "funk" => [
            "soul" => [],
            "disco" => [],
            "hip hop" => [],
        ],
    ];
}
