<?php

namespace App\Twig\Components\Adresse;

use App\Entity\User;
use App\Entity\Address as EntityAddress;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Adresse', template: 'components/Adresse/Adresse.html.twig')]
class Adresse
{
    use DefaultActionTrait;

    #[LiveProp]
    public User $user;

    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManager) {}

    #[LiveListener("refreshAddress")]
    public function getAdresses(): array
    {
        return $this->addressRepository->getUserAdresses($this->user->getId());
    }
}
