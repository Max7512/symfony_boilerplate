<?php

namespace App\Twig\Components\Adresse;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('AdresseItem', template: 'components/Adresse/AdresseItem.html.twig')]
class AdresseItem
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public Address $adresse;

    public function __construct(private EntityManagerInterface $entityManager) {}

    #[LiveAction]
    public function deleteAddress(): void
    {
        $this->adresse->setDeleted(true);
        $this->entityManager->persist($this->adresse);
        $this->entityManager->flush();

        $this->emit("refreshAddress");
    }
}
