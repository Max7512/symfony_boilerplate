<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends BaseController
{
    #[Route('/panier', name: 'panier')]
    public function panier(Request $request): Response
    {
        return $this->renderAndSwitchLocale($request, 'panier.html.twig');
    }
}