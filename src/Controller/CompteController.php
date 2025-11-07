<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends BaseController
{
    #[Route('/compte', name: 'compte')]
    public function compte(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new Exception("User is not logged in properly");
        }

        $form = $this->createForm(AccountEditFormType::class, $user, ["attr" => ["class" => "modifier-compte conteneur colonne-centre"]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('compte.html.twig', [
            'accountEditForm' => $form,
        ]);
    }
}