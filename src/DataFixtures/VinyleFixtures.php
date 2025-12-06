<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vinyle;
use App\Entity\Image;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VinyleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $genreRepository = $manager->getRepository(Genre::class);
        foreach ($this::data as $authorName => $albums) {
            $author = new Author();
            $author->setName($authorName);
            $manager->persist($author);
            foreach ($albums as $title => $info) {
                $vinyle = new Vinyle();
                $image = new Image();
                $vinyle->setDeleted(false);
                $vinyle->setAuthor($author);
                $vinyle->setName($title);
                $image->setUrl($info["image"]);
                $vinyle->setImage($image);
                $vinyle->setPrice(mt_rand(1999, 3999) / 100);
                $vinyle->setDescription($title . ": Album de " . $authorName);
                $vinyle->setStock(mt_rand(0, 30));

                foreach ($info["genres"] as $genreName) {
                    $genre = $genreRepository->findOneBy(['name' => $genreName]);
                    if ($genre) {
                        $vinyle->addGenre($genre);
                    }
                }

                $manager->persist($vinyle);
            }
        }

        $manager->flush();
    }

    const data = [
        "Foo Fighters" => [
            "Foo Fighters" => [
                "image" => "https://static.fnac-static.com/multimedia/Images/FR/NR/a1/5a/3f/4151969/1540-1/tsp20150417134442/Foo-fighters.jpg",
                "genres" => ["rock", "grunge", "rock alt", "post-grunge"],
            ],
            "The Colour and the Shape" => [
                "image" => "https://m.media-amazon.com/images/I/41Sg8rayxpL._SY300_SX300_QL70_ML2_.jpg",
                "genres" => ["rock", "rock alt", "grunge", "post-grunge"],
            ],
            "There Is Nothing Left to Lose" => [
                "image" => "https://m.media-amazon.com/images/I/71oNVLrVpRL._SX425_.jpg",
                "genres" => ["rock", "rock alt", "grunge", "post-grunge"],
            ],
            "One by One" => [
                "image" => "https://townsquare.media/site/366/files/2016/06/one_by_one_white.jpg?w=980&q=75",
                "genres" => ["rock", "post-grunge", "rock alt"],
            ],
            "In Your Honor" => [
                "image" => "https://static.fnac-static.com/multimedia/Images/FR/NR/3c/58/54/5527612/1540-1/tsp20150417134442/In-your-honor-mpdl.jpg",
                "genres" => ["rock", "rock alt", "post-grunge", "acoustique"],
            ],
            "Echoes, Silence, Patience and Grace" => [
                "image" => "https://static.fnac-static.com/multimedia/Images/FR/NR/db/f2/1e/2028251/1540-1/tsp20150417134442/Echoes-silence-patience-and-grace.jpg",
                "genres" => ["rock", "rock alt", "post-grunge"],
            ],
            "Wasting Light" => [
                "image" => "https://static.fnac-static.com/multimedia/FR/images_produits/FR/Fnac.com/ZoomPE/3/1/3/0886978449313/tsp20130828172949/Wasting-light.jpg",
                "genres" => ["rock", "hard rock", "post-rock", "rock alt"],
            ],
            "Sonic Highways" => [
                "image" => "https://m.media-amazon.com/images/I/81Ebxjui1qL._SX425_.jpg",
                "genres" => ["rock", "rock alt", "post-grunge", "hard rock"],
            ],
            "Concrete and Gold" => [
                "image" => "https://upload.wikimedia.org/wikipedia/en/thumb/e/e5/Concrete_and_Gold_Foo_Fighters_album.jpg/250px-Concrete_and_Gold_Foo_Fighters_album.jpg",
                "genres" => ["rock", "rock alt", "post-grunge"],
            ],
            "Medicine at Midnight" => [
                "image" => "https://static.fnac-static.com/multimedia/Images/FR/NR/a7/f4/c3/12842151/1541-1/tsp20201110085151/Medecine-At-Midnight.jpg",
                "genres" => ["rock", "pop rock", "rock alt"],
            ],
            "But Here We Are" => [
                "image" => "https://wshoccidentalist.com/wp-content/uploads/2023/06/Foo-Fighters-But-Here-We-Are.jpg",
                "genres" => ["rock", "post-grunge", "rock alt"],
            ],
        ],

        "Slipknot" => [
            "Slipknot" => [
                "image" => "https://metal.hu/shop/wp-content/uploads/2022/05/slipknot-slipknot-cd.jpg",
                "genres" => ["metal", "nu metal", "metal alt"],
            ],
            "Iowa" => [
                "image" => "https://upload.wikimedia.org/wikipedia/en/thumb/1/1d/Slipknot_Iowa.jpg/250px-Slipknot_Iowa.jpg",
                "genres" => ["metal", "nu metal", "extreme metal"],
            ],
            "Vol 3: The Subliminal Verses" => [
                "image" => "https://cdn-images.dzcdn.net/images/cover/35b093d22fe1539003d5d18dd8f309eb/500x500-000000-80-0-0.jpg",
                "genres" => ["metal", "nu metal", "experimental metal"],
            ],
            "All Hope Is Gone" => [
                "image" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/a9/All_Hope_is_Gone_%28original%29.jpg/250px-All_Hope_is_Gone_%28original%29.jpg",
                "genres" => ["metal", "groove metal", "nu metal"],
            ],
            ".5: The Gray Chapter" => [
                "image" => "https://t2.genius.com/unsafe/300x300/https%3A%2F%2Fimages.genius.com%2Fd3325a124f8d1042554e8babaec6fc50.1000x1000x1.jpg",
                "genres" => ["metal", "metal alt", "nu metal"],
            ],
            "We Are Not Your Kind" => [
                "image" => "https://static.fnac-static.com/multimedia/Images/FR/NR/1c/17/9b/10163996/1540-1/tsp20190517165949/We-Are-Not-Your-Kind.jpg",
                "genres" => ["metal", "industrial metal", "metal alt", "nu metal"],
            ],
            "The End, So Far" => [
                "image" => "https://linkstorage.linkfire.com/medialinks/images/18a713bc-c87d-4cf9-be45-961ed6183960/artwork-440x440.jpg",
                "genres" => ["metal", "experimental metal", "metal alt", "nu metal"],
            ],
        ],
    ];

    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
        ];
    }
}
