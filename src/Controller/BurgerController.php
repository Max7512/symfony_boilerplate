<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BurgerRepository;
use App\Entity\Burger;
use Doctrine\ORM\EntityManagerInterface;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burgers')]
    public function list(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();
        return $this->render('burger_list.html.twig', ['burgers' => $burgers]);
    }

    #[Route('/burgers/{id}', name: 'burger')]
    public function burger(string $id, BurgerRepository $burgerRepository): Response
    {
        $burger = $burgerRepository->findById($id)[0];
        return $this->render('burger.html.twig', ['burger' => $burger]);
    }

    #[Route('/create/burgers', name: 'burger_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $burger->setName('Krazy Hamburger');
        $burger->setPrice(6.9);

        $entityManager->persist($burger);
        $entityManager->flush();

        return new Response('Burger créé avec succès');
    }
}