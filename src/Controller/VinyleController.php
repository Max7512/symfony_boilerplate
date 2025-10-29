<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;
use Symfony\Component\HttpFoundation\Request;

class VinyleController extends BaseController
{
    public ?VinyleRepository $vinyleRepository = null;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    #[Route("/vinyle/{id}", name: "vinyle")]
    public function vinyle(string $id, Request $request): Response
    {
        return $this->renderAndSwitchLocale($request, "vinyle.html.twig", ["vinyle" => $this->vinyleRepository->find($id)]);
    }
}