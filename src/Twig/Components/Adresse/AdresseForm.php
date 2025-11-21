<?php

namespace App\Twig\Components\Adresse;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent("AdresseForm", template: "components/Adresse/AdresseForm.html.twig")]
class AdresseForm
{
    use ComponentToolsTrait;
    use DefaultActionTrait;

    #[LiveProp(writable: ["country", "city", "postalCode", "street"])]
    public Address $address;

    #[LiveProp]
    public User $user;

    public function __construct()
    {
        $this->address = new Address();
    }

    #[LiveAction]
    public function saveAddress(EntityManagerInterface $entityManager): void
    {
        $address = $this->address;

        if ($address->getCountry() && $address->getCity() && $address->getPostalCode() && $address->getStreet()) {
            $address->setUser($this->user);
            $address->setDeleted(false);

            $entityManager->persist($this->address);
            $entityManager->flush();

            $this->dispatchBrowserEvent('modal:close');
            $this->emit('address:created');

            $this->address = new Address();
            $this->address->setUser($this->user);
        }
    }
}
