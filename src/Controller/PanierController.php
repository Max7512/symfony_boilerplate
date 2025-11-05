<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PanierItemRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends BaseController
{
    public ?PanierItemRepository $panierItemRepository = null;

    public function __construct(PanierItemRepository $panierItemRepository)
    {
        $this->panierItemRepository = $panierItemRepository;
    }

    #[Route('/panier', name: 'panier')]
    public function panier(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new Exception("User is not logged in properly");
        }

        $panier = $this->panierItemRepository->getUserPanier($user->getId());
        $total = $this->panierItemRepository->getUserPanierTotal($user->getId());

        return $this->render('panier.html.twig', [ "panier" => $panier, "total" => $total ]);
    }
}