<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burgers')]
    public function list(): Response
    {
        $burgers = [
            [
                "name" => "Cheeseburger",
                "id" => 1
            ],
            [
                "name" => "Baconator",
                "id" => 2
            ],
            [
                "name" => "Crispy chicken",
                "id" => 3
            ]
        ];
        return $this->render('burgers_list.html.twig');
    }

    #[Route('/burgers/{id}', name: 'burger')]
    public function burger(string $id): Response
    {
        return $this->render('burger.html.twig');
    }
}