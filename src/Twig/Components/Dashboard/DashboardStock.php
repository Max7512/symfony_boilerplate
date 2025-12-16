<?php

namespace App\Twig\Components\Dashboard;

use App\Repository\VinyleRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'DashboardStock', template: 'components/Dashboard/DashboardStock.html.twig')]
class DashboardStock
{
    private VinyleRepository $vinyleRepository;

    public function __construct(VinyleRepository $vinyleRepository)
    {
        $this->vinyleRepository = $vinyleRepository;
    }

    public function getCounts(): array
    {
        return $this->vinyleRepository->getVinylesStatusCounts();
    }

    public function getOutOfStockVinyles(): array
    {
        return $this->vinyleRepository->getOutOfStock();
    }
}
