<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VinyleController extends AbstractController
{
    public ?VinyleRepository $vinyleRepository = null;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    #[Route("/vinyle/{id}", name: "vinyle")]
    public function vinyle(string $id): Response
    {
        return $this->render("vinyle.html.twig", ["vinyle" => $this->vinyleRepository->find($id)]);
    }
}