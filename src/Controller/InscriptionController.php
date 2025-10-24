<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionController extends BaseController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(): Response
    {
        return $this->render('inscription.html.twig');
    }
}