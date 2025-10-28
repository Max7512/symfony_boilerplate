<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;

class HomeController extends BaseController
{
    public ?VinyleRepository $vinyleRepository = null;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render("accueil.html.twig", ["vinyles" => $this->vinyleRepository->findAll()]);
    }
}