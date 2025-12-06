<?php

namespace App\Twig\Components\Vinyle;

use App\Entity\Vinyle as VinyleEntity;
use App\Repository\VinyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Vinyle', template: 'components/Vinyle/Vinyle.html.twig')]
class Vinyle extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: ["name", "description", "price"])]
    public VinyleEntity $vinyle;

    public function __construct(private EntityManagerInterface $entityManager, private VinyleRepository $vinyleRepository) {}

    public function isAdmin(): bool
    {
        if (!$this->getUser()) return false;
        if (array_search("ROLE_ADMIN", $this->getUser()->getRoles()) === false) return false;
        else return true;
    }

    #[LiveAction]
    public function deleteVinyle(): ?RedirectResponse
    {
        try {
            $vinyle = $this->vinyleRepository->find($this->vinyle->getId());
            $vinyle->setDeleted(true);
            $this->entityManager->persist($vinyle);
            $this->entityManager->flush();
        } catch (Exception $e) {
        }

        return $this->redirectToRoute("accueil");
    }

    #[LiveAction]
    public function saveVinyle(): ?RedirectResponse
    {
        $this->entityManager->persist($this->vinyle);
        $this->entityManager->flush();

        return $this->redirectToRoute("accueil");
    }
}
