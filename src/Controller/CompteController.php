<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends BaseController
{
    #[Route('/compte', name: 'compte')]
    public function compte(Request $request): Response
    {
        return $this->renderAndSwitchLocale($request, 'compte.html.twig');
    }
}