<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class HomeController extends BaseController
{
    public ?VinyleRepository $vinyleRepository = null;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    #[Route("/", name: "home")]
    public function home(#[MapQueryParameter] ?string $search = null, #[MapQueryParameter] ?int $pageLimit = null, Request $request): Response
    {
        return $this->render("accueil.html.twig", ["vinyles" => $this->vinyleRepository->getAllPaginate($request, $search, $pageLimit), "search" => $search]);
    }
}