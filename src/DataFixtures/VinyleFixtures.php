<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vinyle;
use App\Entity\Image;

class VinyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this::data as $author => $albums) {
            foreach ($albums as $title => $cover) {
                $vinyle = new Vinyle();
                $image = new Image();
                $vinyle->setAuthor($author);
                $vinyle->setName($title);
                $image->setUrl($cover);
                $vinyle->setImage($image);
                $vinyle->setPrice(mt_rand(1999, 3999) / 100);
                $vinyle->setDescription($title.": Album de ".$author);
                $vinyle->setStock(mt_rand(0,30));

                $manager->persist($vinyle);
            }
        }

        $manager->flush();
    }

    const data = [
        "Foo Fighters" => [
            "Foo Fighters" => "https://static.fnac-static.com/multimedia/Images/FR/NR/a1/5a/3f/4151969/1540-1/tsp20150417134442/Foo-fighters.jpg",
            "The colour and the shape" => "https://m.media-amazon.com/images/I/41Sg8rayxpL._SY300_SX300_QL70_ML2_.jpg",
            "There is nothing left to lose" => "https://m.media-amazon.com/images/I/71oNVLrVpRL._SX425_.jpg",
            "One by one" => "https://townsquare.media/site/366/files/2016/06/one_by_one_white.jpg?w=980&q=75",
            "In your honor" => "https://static.fnac-static.com/multimedia/Images/FR/NR/3c/58/54/5527612/1540-1/tsp20150417134442/In-your-honor-mpdl.jpg",
            "Echoes, Silence, Patience and Grace" => "https://static.fnac-static.com/multimedia/Images/FR/NR/db/f2/1e/2028251/1540-1/tsp20150417134442/Echoes-silence-patience-and-grace.jpg",
            "Wasting light" => "https://static.fnac-static.com/multimedia/FR/images_produits/FR/Fnac.com/ZoomPE/3/1/3/0886978449313/tsp20130828172949/Wasting-light.jpg",
            "Sonic highways" => "https://m.media-amazon.com/images/I/81Ebxjui1qL._SX425_.jpg",
            "Concrete and gold" => "https://upload.wikimedia.org/wikipedia/en/thumb/e/e5/Concrete_and_Gold_Foo_Fighters_album.jpg/250px-Concrete_and_Gold_Foo_Fighters_album.jpg",
            "Medicine at midnight" => "https://static.fnac-static.com/multimedia/Images/FR/NR/a7/f4/c3/12842151/1541-1/tsp20201110085151/Medecine-At-Midnight.jpg",
            "But here we are" => "https://wshoccidentalist.com/wp-content/uploads/2023/06/Foo-Fighters-But-Here-We-Are.jpg"
        ],
        "Slipknot" => [
            "Slipknot" => "https://metal.hu/shop/wp-content/uploads/2022/05/slipknot-slipknot-cd.jpg",
            "Iowa" => "https://upload.wikimedia.org/wikipedia/en/thumb/1/1d/Slipknot_Iowa.jpg/250px-Slipknot_Iowa.jpg",
            "Vol 3: The subliminal verses" => "https://cdn-images.dzcdn.net/images/cover/35b093d22fe1539003d5d18dd8f309eb/500x500-000000-80-0-0.jpg",
            "All hope is gone" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/a9/All_Hope_is_Gone_%28original%29.jpg/250px-All_Hope_is_Gone_%28original%29.jpg",
            ".5 The gray chapter" => "https://t2.genius.com/unsafe/300x300/https%3A%2F%2Fimages.genius.com%2Fd3325a124f8d1042554e8babaec6fc50.1000x1000x1.jpg",
            "We are not your kind" => "https://static.fnac-static.com/multimedia/Images/FR/NR/1c/17/9b/10163996/1540-1/tsp20190517165949/We-Are-Not-Your-Kind.jpg",
            "The end so far" => "https://linkstorage.linkfire.com/medialinks/images/18a713bc-c87d-4cf9-be45-961ed6183960/artwork-440x440.jpg"
        ]
    ];
}
