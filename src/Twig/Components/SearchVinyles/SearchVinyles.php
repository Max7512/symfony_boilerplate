<?php

namespace App\Twig\Components\SearchVinyles;

use App\Entity\Author;
use App\Entity\Image;
use App\Entity\Vinyle;
use App\Form\VinyleFormType;
use App\Repository\VinyleRepository;
use App\Util\VinyleStatus;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchVinyles', template: 'components/SearchVinyles/SearchVinyles.html.twig')]
class SearchVinyles extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    public ?string $search = null;

    #[LiveProp]
    public int $page = 1;

    #[LiveProp(writable: true)]
    public int $pageLimit = 30;

    #[LiveProp]
    public int $pageCount = 1;

    #[LiveProp]
    public bool $formOpen = false;

    #[LiveProp]
    public ?Vinyle $vinyle = null;

    #[LiveProp(writable: true)]
    public ?string $newAuthor = null;

    public function __construct(
        private VinyleRepository $vinyleRepository
    ) {}

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(VinyleFormType::class, $this->vinyle);
    }

    public function getVinyles(): PaginationInterface
    {
        return $this->vinyleRepository->getAllPaginate($this->page, $this->search, $this->pageLimit);
    }

    #[LiveAction]
    public function pagePlus(): void
    {
        if ($this->page < $this->pageCount) {
            $this->page++;
        }

        $this->refreshPageOptions();
    }

    #[LiveAction]
    public function pageMoins(): void
    {
        if ($this->page > 1) {
            $this->page--;
        }

        $this->refreshPageOptions();
    }

    #[LiveAction]
    public function refreshPageOptions(): void
    {
        $this->pageCount = ceil($this->vinyleRepository->getAllPaginate($this->page, $this->search, $this->pageLimit)->getTotalItemCount() / $this->pageLimit);

        if ($this->page > $this->pageCount) {
            $this->page = $this->pageCount;
        }
    }

    #[LiveAction]
    public function openForm()
    {
        $this->formOpen = true;
    }

    #[LiveAction]
    public function closeForm()
    {
        $this->formOpen = false;
        $this->newAuthor = false;
        $this->resetForm();
    }

    #[LiveAction]
    public function addNewAuthor(EntityManagerInterface $entityManager): void
    {
        $author = new Author();
        $author->setName($this->newAuthor);

        $entityManager->persist($author);
        $entityManager->flush();
    }

    #[LiveAction]
    public function saveVinyle(Request $request, EntityManagerInterface $entityManager): void
    {
        $form = $this->getForm();
        $form->handleRequest($request);

        $vinyle = $form->getData();

        $precommande = $form->get('precommande')->getData();

        if ($precommande) {
            $vinyle->setStatus(VinyleStatus::PREORDER);
        } else {
            if ($vinyle->getStock() > 0) {
                $vinyle->setStatus(VinyleStatus::IN_STOCK);
            } else {
                $vinyle->setStatus(VinyleStatus::OUT_OF_STOCK);
            }
        }

        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    "images/vinyles",
                    $newFilename
                );
            } catch (FileException $e) {
            }

            $image = new Image();
            $image->setUrl('/images/vinyles/' . $newFilename);
            $vinyle->setImage($image);

            $entityManager->persist($vinyle);
            $entityManager->flush();

            $this->closeForm();
        }
    }
}
