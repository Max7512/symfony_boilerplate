<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends BaseController
{
    #[Route('/compte', name: 'compte')]
    public function compte(): Response
    {
        return $this->render('compte.html.twig');
    }
}