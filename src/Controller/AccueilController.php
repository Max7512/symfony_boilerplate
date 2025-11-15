<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;

class AccueilController extends BaseController
{
    public ?VinyleRepository $vinyleRepository = null;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    #[Route("/", name: "accueil")]
    public function accueil(): Response
    {
        return $this->render("accueil.html.twig");
    }
}