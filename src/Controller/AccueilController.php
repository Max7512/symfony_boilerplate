<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends BaseController
{

    #[Route("/", name: "accueil")]
    public function accueil(): Response
    {
        return $this->render("accueil.html.twig");
    }
}