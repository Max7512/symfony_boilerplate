<?php

namespace App\Twig\Components\Adresse;

use App\Entity\User;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Adresse', template: 'components/Adresse/Adresse.html.twig')]
class Adresse
{
    use DefaultActionTrait;

    #[LiveProp]
    public User $user;

    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManager) {}

    public function getAdresses(): array
    {
        return $this->addressRepository->getUserAdresses($this->user->getId());
    }

    #[LiveAction]
    public function deleteAdresse(#[LiveArg] int $id): void
    {
        $adresse = $this->addressRepository->find($id);
        $this->entityManager->remove($adresse);
        $this->entityManager->flush();
    }
}
