<?php

namespace App\Twig\Components\Adresse;

use App\Entity\User;
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

    #[LiveProp]
    public bool $formOpen = false;

    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManager) {}

    #[LiveListener("refreshAddress")]
    public function getAdresses(): array
    {
        return $this->addressRepository->getUserAdresses($this->user->getId());
    }

    #[LiveListener("adresse-form-open")]
    public function openForm()
    {
        $this->formOpen = true;
    }

    #[LiveListener("adresse-form-close")]
    public function closeForm()
    {
        $this->formOpen = false;
    }
}
