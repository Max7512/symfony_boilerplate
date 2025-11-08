<?php

namespace App\Controller;

use App\Entity\PanierItem;
use App\Entity\User;
use App\Form\AddToCartFormType;
use App\Repository\PanierItemRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VinyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class VinyleController extends BaseController
{
    public ?VinyleRepository $vinyleRepository = null;
    public ?PanierItemRepository $panierItemRepository = null;

    public function __construct(VinyleRepository $vinyleRepository, PanierItemRepository $panierItemRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
        $this->panierItemRepository = $panierItemRepository;
    }

    #[Route("/vinyle/{id}", name: "vinyle")]
    public function vinyle(string $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $vinyle = $this->vinyleRepository->find($id);
        $user = $this->getUser();

        $form = null;

        if ($user) {
            if (!$user instanceof User) {
                return $this->redirectToRoute('connexion');
            }

            $panierItem = $this->panierItemRepository->getUserPanierItem($user->getId(), $vinyle->getId());

            if (!$panierItem) {
                $panierItem = new PanierItem();
                $panierItem->setVinyle($vinyle);
                $panierItem->setUser($user);
            }

            $form = $this->createForm(AddToCartFormType::class, $panierItem, ["attr" => ["class" => "colonne-centre"]]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($panierItem);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }
        }

        return $this->render("vinyle.html.twig", ["vinyle" => $vinyle, "addToCartForm" => $form]);
    }
}
