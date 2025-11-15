<?php

namespace App\Twig\Components\Vinyle;

use App\Repository\VinyleRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchVinyles', template: 'components/Vinyle/SearchVinyles.html.twig')]
class SearchVinyles
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public ?string $search = null;

    public function __construct(private VinyleRepository $vinyleRepository)
    {
    }

    public function getVinyles(): array
    {
        return $this->vinyleRepository->getAll($this->search);
    }
}
