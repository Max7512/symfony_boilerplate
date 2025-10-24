<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends BaseController
{
    #[Route('/panier', name: 'panier')]
    public function panier(): Response
    {
        return $this->render('panier.html.twig');
    }
}