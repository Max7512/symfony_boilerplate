<?php

namespace App\Twig\Components\Vinyle;

use App\Repository\VinyleRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchVinyles', template: 'components/Vinyle/SearchVinyles.html.twig')]
class SearchVinyles
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public ?string $search = null;

    #[LiveProp]
    public int $page = 1;

    #[LiveProp(writable: true)]
    public int $pageLimit = 25;

    public function __construct(private VinyleRepository $vinyleRepository)
    {
    }

    public function getVinyles(): PaginationInterface
    {
        return $this->vinyleRepository->getAllPaginate($this->page, $this->search, $this->pageLimit);
    }

    #[LiveListener('pagePlus')]
    public function pagePlus(): void {
        $this->page++;
    }

    #[LiveListener('pageMoins')]
    public function pageMoins(): void {
        $this->page--;
    }
}
