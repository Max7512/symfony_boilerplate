<?php

namespace App\Twig\Components\Vinyle;

use App\Repository\VinyleRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchVinyles', template: 'components/Vinyle/SearchVinyles.html.twig')]
class SearchVinyles
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $search = null;

    #[LiveProp]
    public int $page = 1;

    #[LiveProp(writable: true)]
    public int $pageLimit = 30;

    #[LiveProp]
    public int $pageCount = 1;

    public function __construct(private VinyleRepository $vinyleRepository) {}

    public function getVinyles(): PaginationInterface
    {
        return $this->vinyleRepository->getAllPaginate($this->page, $this->search, $this->pageLimit);
    }

    #[LiveAction]
    public function pagePlus(): void
    {
        if ($this->page < $this->pageCount)
            $this->page++;

        $this->refreshPageOptions();
    }

    #[LiveAction]
    public function pageMoins(): void
    {
        if ($this->page > 1)
            $this->page--;

        $this->refreshPageOptions();
    }

    #[LiveAction]
    public function refreshPageOptions(): void {
        $this->pageCount = ceil($this->vinyleRepository->getAllPaginate($this->page, $this->search, $this->pageLimit)->getTotalItemCount() / $this->pageLimit);

        if ($this->page > $this->pageCount)
            $this->page = $this->pageCount;
    }
}
