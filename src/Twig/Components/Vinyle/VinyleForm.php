<?php

namespace App\Twig\Components\Vinyle;

use App\Entity\Image;
use App\Entity\User;
use App\Entity\Vinyle;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent("VinyleForm", template: "components/Vinyle/VinyleForm.html.twig")]
class VinyleForm
{
    use ComponentToolsTrait;
    use DefaultActionTrait;

    #[LiveProp(writable: ["name", "description", "price", "stock"])]
    public Vinyle $vinyle;

    #[LiveProp(writable: true)]
    public ?int $authorId = null;

    #[LiveProp]
    public string $imageSrc = "/images/image_placeholder.png";

    #[LiveProp(writable: true)]
    public bool $precommande = false;

    #[LiveProp]
    public User $user;

    public function __construct(private AuthorRepository $authorRepository)
    {
        $this->vinyle = new Vinyle();
    }

    #[LiveAction]
    public function uploadFile(Request $request) {
        $image = $request->files->get('image');
        if ($image && $image instanceof UploadedFile && $image->getSize()) {
            $filePath = '/images/tmp/'.$this->user->getId();
            $image->move('images/tmp/', $this->user->getId());
            $this->imageSrc = $filePath;
        } else {
            $this->imageSrc = "/images/image_placeholder.png";
        }
    }

    #[LiveAction]
    public function saveVinyle(EntityManagerInterface $entityManager): void
    {
        $vinyle = $this->vinyle;
        $author = $this->authorRepository->find($this->authorId);
        $image = new Image();

        if ($vinyle->getName() && $vinyle->getAuthor() && $vinyle->getImage() && $vinyle->getPrice() && $vinyle->getStock() && $author && $image) {
            $vinyle->setDeleted(false);
            $vinyle->setAuthor($author);
            $vinyle->setImage($image);

            $entityManager->persist($vinyle);
            $entityManager->flush();

            $this->dispatchBrowserEvent('vinyle-form-close');
            $this->emit('vinyle-form-close');

            $this->vinyle = new Vinyle();
        }
    }
}
