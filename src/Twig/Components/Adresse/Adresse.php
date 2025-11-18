<?php

namespace App\Twig\Components\Adresse;

use App\Entity\User;
use App\Entity\Address as EntityAddress;
use App\Form\AddAddressFormType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
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

    #[LiveProp(useSerializerForHydration: true)]
    public ?FormView $form = null;

    #[LiveProp]
    public EntityAddress $adresse;

    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManager, private FormFactoryInterface $formFactory) 
    {
        $this->adresse = new EntityAddress();
        $this->form = $this->formFactory->create(AddAddressFormType::class, $this->adresse)->createView();
    }

    #[LiveListener("refreshAddress")]
    public function getAdresses(): array
    {
        return $this->addressRepository->getUserAdresses($this->user->getId());
    }
}
